<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index')->with([
            'user' => $user,

        ]);
    }

    public function dataIndex()
    {
        $data = DB::table('profiles')
            ->orderBy('id', 'ASC')
            ->get();

        return Datatables()->of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('profile.create')->with([
            'user' => $user,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/profiles'), $imageName);
        $data = [
            'key' => $request->key,
            'title' => $request->title,
            'description' => $request->editor,
            'image' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('profiles')->insert($data);
        Session::flash('success', 'Data berhasil ditambahkan');
        return redirect()->route('profile.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $model = DB::table('profiles')->where('id', $id)->first();

        return view('profile.edit')->with([
            'user' => $user,
            'model' => $model,
            'id' => $id,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = [
            'key' => $request->key,
            'title' => $request->title,
            'description' => $request->editor,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/profiles'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('profiles')->where('id', $id)->update($data);
        Session::flash('success', 'Berita berhasil diupdate');
        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $news = DB::table('profiles')->where('id', $id)->first();
        if ($news) {
            // Delete the image from storage
            $imagePath = public_path('images/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the news record from the database
            DB::table('profiles')->where('id', $id)->delete();
            Session::flash('success', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }
        return redirect()->route('profile.index');
    }

    public function view($id = null)
    {
        // Ambil semua data yang key-nya mengandung "sejarah"
        $sejarahItems = DB::table('profiles')
            ->where('key', 'like', '%sejarah%')
            ->orderBy('created_at', 'desc')
            ->get();

        $sejarahItems = $sejarahItems->sortByDesc(function ($item) {
            return str_contains(strtolower($item->key), 'utama');
        })->values();

        // Jika ada ID dikirim (klik item tertentu), pakai itu
        if ($id) {
            $model = $sejarahItems->firstWhere('id', $id);
        }

        // Jika tidak ada ID, ambil yang "utama" atau yang pertama
        if (!isset($model)) {
            $model = $sejarahItems->first(function ($item) {
                return str_contains(strtolower($item->key), 'utama');
            }) ?? $sejarahItems->first();
        }

        return view('frontend.profile.sejarah', [
            'model' => $model,
            'data_all' => $sejarahItems
        ]);
    }
    public function sambutan()
    {
        // Ambil data dengan key "sambutan"
        $sambutan = DB::table('profiles')
            ->where('key', 'like', '%sambutan%')
            ->latest()
            ->first();

        return view('frontend.profile.sambutan', [
            'sambutan' => $sambutan
        ]);
    }
    public function visiMisi()
    {
        $visi = DB::table('profiles')
            ->where('key', 'like', '%visi%')
            ->where('title', 'visi')
            ->latest()
            ->first();

        $misi = DB::table('profiles')
            ->where('key', 'like', '%misi%')
            ->where('title', 'misi')
            ->latest()
            ->first();

        return view('frontend.profile.visi-misi', compact('visi', 'misi'));
    }
    public function strukturOrganisasi()
    {
        $data = DB::table('profiles')
            ->where('key', 'like', '%organisasi%')
            ->orderByDesc('created_at')
            ->first(); // Ambil satu data terbaru

        return view('frontend.profile.struktur', [
            'data' => $data
        ]);
    }
}