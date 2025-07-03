<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\EventRegistration;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\AdminNotification;


class CheckoutController extends Controller
{
    public function showCheckoutPage(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with(['research_data', 'event'])->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend-cart.index')->with('error', 'Keranjang kosong');
        }

        $totalPrice = $cartItems->sum('price');
        $couponCode = session('coupon_code');
        $discount = session('discount') ?? 0;
        $finalPrice = max($totalPrice - $discount, 0);

        return view('frontend.checkout.index', compact('cartItems', 'totalPrice', 'discount', 'finalPrice', 'couponCode'));
    }

public function placeOrder(Request $request)
{
    $user = Auth::user();
    $cartItems = Cart::with(['research_data', 'event'])->where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('frontend-cart.index')->with('error', 'Keranjang kosong');
    }

    $validated = $request->validate([
        'nama' => 'required',
        'address' => 'required',
        'shipping_city' => 'required',
        'shipping_postalcode' => 'required',
        'shipping_phonenumber' => 'required',
    ]);

    DB::beginTransaction();

    try {
        $itemIds = [];
        $itemTypes = [];
        $prices = [];
        $filePaths = [];
        $itemDetails = [];

        foreach ($cartItems as $item) {
            $price = (int) $item->price;
            $prices[] = $price;

            if ($item->item_type === 'research_data' && $item->research_data) {
                $itemIds[] = $item->research_data->id;
                $itemTypes[] = 'research_data';
                $filePaths[] = $item->research_data->preview_path;
                $itemDetails[] = [
                    'id' => 'RD-' . $item->research_data->id,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => $item->research_data->research_title,
                ];
            }

            if ($item->item_type === 'event' && $item->event) {
                $itemIds[] = $item->event->id;
                $itemTypes[] = 'event';
                $filePaths[] = $item->event->image;
                $itemDetails[] = [
                    'id' => 'EV-' . $item->event->id,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => $item->event->name,
                ];
            }
        }

        $totalPrice = array_sum($prices);
        $discount = session('discount') ?? 0;
        $couponCode = session('coupon_code');
        $couponId = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $couponId = $coupon->id;
                $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -1 * $discount,
                    'quantity' => 1,
                    'name' => 'Diskon Kupon',
                ];
            }
        }

        $finalPrice = max($totalPrice - $discount, 0);

        // Simpan order awal
        $order = new Order();
        $order->user_id = $user->id;
        $order->nama = $validated['nama'];
        $order->address = $validated['address'];
        $order->shipping_city = $validated['shipping_city'];
        $order->shipping_postalcode = $validated['shipping_postalcode'];
        $order->shipping_phonenumber = $validated['shipping_phonenumber'];
        $order->status = $finalPrice <= 0 ? 'paid' : 'pending';
        $order->item_id = json_encode($itemIds);
        $order->item_type = json_encode($itemTypes);
        $order->file_path = json_encode($filePaths);
        $order->totalprice = json_encode($prices);
        $order->coupon_id = $couponId;
        $order->snap_token = ''; // placeholder
        $order->save(); // simpan untuk dapat ID-nya

        // Midtrans config
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapToken = '';

        if ($finalPrice > 0) {
            $params = [
                'transaction_details' => [
                    'order_id' => (string) $order->id, // kirim ID langsung
                    'gross_amount' => $finalPrice,
                ],
                'customer_details' => [
                    'first_name' => $validated['nama'],
                    'email' => $user->email,
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($params); //https://app.sandbox.midtrans.com/snap/v1/transactions
        } else {
            $snapToken = 'FREE-ORDER-' . uniqid();
        }

        // Update snap_token setelah dapat
        $order->snap_token = $snapToken;
        $order->save();
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification("Pesanan baru dibuat oleh {$user->name}", $order->id));
        }

        // Bersihkan keranjang
        foreach ($cartItems as $item) {
            $item->delete();
        }

        DB::commit();
        session()->forget(['coupon_success','coupon_error','cart_count','discount', 'coupon_code', 'final_price']);

        if ($finalPrice <= 0) {
            return redirect()->route('frontend-orders.index')->with('success', 'Pesanan berhasil tanpa pembayaran.');
        }

        return view('frontend.checkout.midtrans', [
            'snapToken' => $snapToken,
            'redirectUrl' => route('frontend-orders.index'),
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->withErrors([
            'error' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}


public function handleMidtransNotification(Request $request)
{
    Log::info('Midtrans Notification received', $request->all());

    try {
        $payload = json_decode($request->getContent());

        $transaction = $payload->transaction_status ?? null;
        $orderId = $payload->order_id ?? null;

        if (!$orderId) {
            Log::error('Order ID not found in payload');
            return response()->json(['message' => 'Order ID missing.'], 400);
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::warning("Order ID {$orderId} not found in DB.");
            return response()->json(['message' => 'Order not found.'], 404);
        }

        if (in_array($transaction, ['settlement', 'capture'])) {
            $order->status = 'paid';
            $order->save();
            $admins = User::whereHas('roles', function($q) {
                        $q->where('name', 'admin');
                    })->get();            
            foreach ($admins as $admin) {
                $admin->notify(new AdminNotification(
                    "Pembayaran berhasil untuk Order #{$order->id} oleh {$order->user->name}", $order->id
                ));
            }

            

            // Tambahkan ke registrasi event jika ada
            $itemIds = json_decode($order->item_id, true);
            $itemTypes = json_decode($order->item_type, true);

            foreach ($itemTypes as $index => $type) {
                if ($type === 'event') {
                    EventRegistration::updateOrCreate([
                        'user_id' => $order->user_id,
                        'event_id' => $itemIds[$index],
                        'order_id' => $order->id,
                    ], [
                        'attendance_token' => null,
                        'token_verified' => 'pending',
                    ]);
                }
            }

            Log::info("Order #{$orderId} marked as paid.");
        } elseif (in_array($transaction, ['expire', 'cancel', 'deny'])) {
            $order->status = 'failed';
            $order->save();
            Log::warning("Order #{$orderId} marked as failed (status: {$transaction}).");
        }

        return response()->json(['message' => 'Notification processed successfully.'], 200);
    } catch (\Exception $e) {
        Log::error('Midtrans Notification Error: ' . $e->getMessage());
        return response()->json(['message' => 'Callback error.'], 500);
    }
}




    
}
