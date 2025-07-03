<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SliderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('slider.index')->with([
            'user' => $user,
        ]);
    }

    public function dataIndex()
    {
        $data = DB::table('sliders')->orderBy('updated_at', 'DESC')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                $url = $row->image ? asset('storage/sliders/' . $row->image) : asset('no-image.jpg');
                return '<img src="' . $url . '" width="100">';
            })
            ->editColumn('active', function ($row) {
                return $row->active ? 'Aktif' : 'Tidak Aktif';
            })
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('slider.edit', $row->id) . '" class="btn btn-sm btn-warning">Edit</a>';
                $delete = '<a href="' . route('slider.destroy', $row->id) . '" onclick="return confirm(\'Yakin ingin hapus?\')" class="btn btn-sm btn-danger">Hapus</a>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function create()
    {
        $user = Auth::user();
        return view('slider.create')->with([
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/sliders'), $imageName);
        }

        DB::table('sliders')->insert([
            'title' => $request->title,
            'description' => $request->editor,
            'active' => $request->active ?? 1,
            'image' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('success', 'Slider berhasil ditambahkan');
        return redirect()->route('slider.index');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $slider = DB::table('sliders')->where('id', $id)->first();

        return view('slider.edit')->with([
            'user' => $user,
            'slider' => $slider,
            'id' => $id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'active' => $request->active ?? 0,
            'updated_at' => Carbon::now(),
        ];

        if ($request->hasFile('image')) {
            $old = DB::table('sliders')->where('id', $id)->value('image');
            $oldPath = public_path('storage/sliders/' . $old);
            if ($old && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/sliders'), $imageName);
            $data['image'] = $imageName;
        }

        DB::table('sliders')->where('id', $id)->update($data);
        Session::flash('success', 'Slider berhasil diperbarui');
        return redirect()->route('slider.index');
    }

    public function destroy($id)
    {
        $slider = DB::table('sliders')->where('id', $id)->first();
        if ($slider) {
            if ($slider->image && file_exists(public_path('storage/sliders/' . $slider->image))) {
                unlink(public_path('storage/sliders/' . $slider->image));
            }
            DB::table('sliders')->where('id', $id)->delete();
            Session::flash('success', 'Slider berhasil dihapus');
        } else {
            Session::flash('error', 'Slider tidak ditemukan');
        }
        return redirect()->route('slider.index');
    }
    public function frontendIndex()
{
    $sliders = DB::table('sliders')
        ->where('active', 1)
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('index', compact('sliders'));
}

}
