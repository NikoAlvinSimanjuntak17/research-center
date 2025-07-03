<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\EventRegistration;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\User;
use App\Notifications\AdminNotification;

class CheckoutApiController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with(['research_data', 'event'])->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalPrice = $cartItems->sum('price');
        $couponCode = $request->input('coupon_code');
        $discount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where(function ($query) {
                    $query->whereNull('expired_at')->orWhere('expired_at', '>', now());
                })->first();

            if ($coupon) {
                $discount = $coupon->type === 'percent' ? ($totalPrice * $coupon->value / 100) : $coupon->value;
            }
        }

        $finalPrice = max(0, $totalPrice - $discount);

        return response()->json([
            'cart_items' => $cartItems,
            'total_price' => $totalPrice,
            'discount' => $discount,
            'final_price' => $finalPrice,
            'coupon_code' => $couponCode,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with(['research_data', 'event'])->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_postalcode' => 'required',
            'shipping_phonenumber' => 'required',
            'coupon_code' => 'nullable|string',
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

                if ($item->item_type === 'research_data') {
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

                if ($item->item_type === 'event') {
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
            $discount = 0;
            $couponId = null;

            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon) {
                    $discount = $coupon->type === 'percent' ? ($totalPrice * $coupon->value / 100) : $coupon->value;
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
            $order->snap_token = '';
            $order->save();

            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $snapToken = '';
            if ($finalPrice > 0) {
                $params = [
                    'transaction_details' => [
                        'order_id' => (string) $order->id,
                        'gross_amount' => $finalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => $validated['nama'],
                        'email' => $user->email,
                    ],
                    'item_details' => $itemDetails,
                ];

                $snapToken = Snap::getSnapToken($params);
            } else {
                $snapToken = 'FREE-' . uniqid();
            }

            $order->snap_token = $snapToken;
            $order->save();

            foreach ($cartItems as $item) {
                $item->delete();
            }

            DB::commit();

            return response()->json([
                'message' => 'Order created',
                'order_id' => $order->id,
                'snap_token' => $snapToken,
                'final_price' => $finalPrice,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleMidtransNotification(Request $request)
    {
        Log::info('Midtrans Notification received', $request->all());

        try {
            $payload = json_decode($request->getContent());
            $transaction = $payload->transaction_status ?? null;
            $orderId = $payload->order_id ?? null;

            $order = Order::find($orderId);
            if (!$order) return response()->json(['message' => 'Order not found.'], 404);

            if (in_array($transaction, ['settlement', 'capture'])) {
                $order->status = 'paid';
                $order->save();

                $itemIds = json_decode($order->item_id, true);
                $itemTypes = json_decode($order->item_type, true);

                foreach ($itemTypes as $i => $type) {
                    if ($type === 'event') {
                        EventRegistration::updateOrCreate([
                            'user_id' => $order->user_id,
                            'event_id' => $itemIds[$i],
                            'order_id' => $order->id,
                        ], [
                            'attendance_token' => null,
                            'token_verified' => 'pending',
                        ]);
                    }
                }
            } elseif (in_array($transaction, ['expire', 'cancel', 'deny'])) {
                $order->status = 'failed';
                $order->save();
            }

            return response()->json(['message' => 'Notification processed.']);
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['error' => 'Callback error.'], 500);
        }
    }
}
