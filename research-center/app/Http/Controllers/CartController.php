<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Event;
use App\Models\Coupon;
use App\Models\ResearchData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $eventItems = Cart::with('event')
            ->where('user_id', $user->id)
            ->whereNotNull('event_id')
            ->get();

        $datasetItems = Cart::with('research_data')
            ->where('user_id', $user->id)
            ->whereNotNull('research_data_id')
            ->get();
        $totalPrice = Cart::where('user_id', $user->id)->sum('price');


        return view('frontend.cart.index', compact('user', 'eventItems', 'datasetItems','totalPrice'));
    }

    public function add(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->input('type') === 'event') {
            $event = Event::findOrFail($id);
            $exists = Cart::where('user_id', $user->id)
                ->where('event_id', $id)
                ->exists();

            if (!$exists) {
                Cart::create([
                    'user_id' => $user->id,
                    'event_id' => $id,
                    'price' => $event->price,
                    'file_path' => $event->image, // image disimpan di file_path
                    'item_type' => 'event',
                ]);
            }
        } else {
            $data = ResearchData::findOrFail($id);
            $exists = Cart::where('user_id', $user->id)
                ->where('research_data_id', $id)
                ->exists();

            if (!$exists) {
                Cart::create([
                    'user_id' => $user->id,
                    'research_data_id' => $id,
                    'price' => $data->price,
                    'preview_path' => $data->preview_path,
                    'file_path' => $data->file_path,
                    'item_type' => 'research_data',
                ]);
            }
        }

        $count = Cart::where('user_id', $user->id)->count();
        Session::put('cart_count', $count);

        return redirect()->route('frontend-cart.index')->with('success', 'Berhasil ditambahkan ke keranjang.');
    }


    public function remove($id)
    {
        $user = Auth::user();
        $cart = Cart::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $cart->delete();

        $count = Cart::where('user_id', $user->id)->count();
        Session::put('cart_count', $count);

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function applyCoupon(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('coupon_error', 'Kupon tidak ditemukan atau sudah kadaluarsa.');
        }

        $totalPrice = Cart::where('user_id', $user->id)->sum('price');
        $discount = 0;

        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } elseif ($coupon->type === 'percent') {
            $discount = ($totalPrice * $coupon->value) / 100;
        }

        $finalPrice = max(0, $totalPrice - $discount);

        // Simpan ke session permanen (bukan flash)
        session([
            'coupon_code' => $coupon->code,
            'discount' => $discount,
            'final_price' => $finalPrice,
            'coupon_success' => 'Kupon berhasil diterapkan!',
        ]);

        return redirect()->back();
    }

}
