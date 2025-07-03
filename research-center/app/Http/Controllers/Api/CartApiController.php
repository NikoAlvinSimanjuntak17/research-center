<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Event;
use App\Models\Coupon;
use App\Models\ResearchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
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

        return response()->json([
            'eventItems' => $eventItems,
            'datasetItems' => $datasetItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function add(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->input('type');

        if ($type === 'event') {
            $event = Event::findOrFail($id);
            if (!Cart::where('user_id', $user->id)->where('event_id', $id)->exists()) {
                Cart::create([
                    'user_id' => $user->id,
                    'event_id' => $id,
                    'price' => $event->price,
                    'file_path' => $event->image,
                    'item_type' => 'event',
                ]);
            }
        } else {
            $data = ResearchData::findOrFail($id);
            if (!Cart::where('user_id', $user->id)->where('research_data_id', $id)->exists()) {
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

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang.']);
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cart = Cart::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $cart->delete();

        return response()->json(['message' => 'Item berhasil dihapus dari keranjang.']);
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
            })->first();

        if (!$coupon) {
            return response()->json(['message' => 'Kupon tidak ditemukan atau kadaluarsa.'], 404);
        }

        $totalPrice = Cart::where('user_id', $user->id)->sum('price');
        $discount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($totalPrice * $coupon->value) / 100;

        $finalPrice = max(0, $totalPrice - $discount);

        return response()->json([
            'message' => 'Kupon berhasil diterapkan.',
            'code' => $coupon->code,
            'discount' => $discount,
            'total_before' => $totalPrice,
            'total_after' => $finalPrice,
        ]);
    }
}
