<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('coupon.index', compact('coupons'));
    }
    public function dataIndex()
    {
        $data = Coupon::orderBy('updated_at', 'DESC')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('coupon.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $delete = '
                    <form action="' . route('coupon.destroy', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus?\')">Hapus</button>
                    </form>';
                return $edit . ' ' . $delete;
            })
            ->editColumn('type', function ($row) {
                return $row->type === 'percent' ? 'Persentase' : 'Tetap (Rp)';
            })
            ->editColumn('value', function ($row) {
                return $row->type === 'percent' ? $row->value . '%' : 'Rp ' . number_format($row->value, 0, ',', '.');
            })
            ->editColumn('expired_at', function ($row) {
                return $row->expired_at ? \Carbon\Carbon::parse($row->expired_at)->format('d-m-Y H:i') : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {
        return view('coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expired_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());
        return redirect()->route('coupon.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = Coupon::findOrFail($id);
        return view('coupon.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $coupon = coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expired_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());
        return redirect()->route('coupon.index')->with('success', 'Kupon berhasil diupdate.');
    }

public function destroy($id)
{
    $coupon = Coupon::findOrFail($id);
    $coupon->delete();
    return redirect()->route('coupon.index')->with('success', 'Kupon berhasil dihapus.');
}

}
