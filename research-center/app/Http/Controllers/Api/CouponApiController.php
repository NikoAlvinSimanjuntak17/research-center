<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponApiController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return response()->json($coupons);
    }

    public function dataIndex()
    {
        $data = Coupon::orderBy('updated_at', 'DESC')->get();

        return response()->json($data); // JSON version for datatables
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expired_at' => 'nullable|date',
        ]);

        $coupon = Coupon::create($request->all());
        return response()->json(['message' => 'Kupon berhasil ditambahkan', 'data' => $coupon], 201);
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json($coupon);
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json($coupon);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expired_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());
        return response()->json(['message' => 'Kupon berhasil diperbarui', 'data' => $coupon]);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['message' => 'Kupon berhasil dihapus']);
    }
}
