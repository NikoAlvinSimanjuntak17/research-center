<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('community.index')->with([
            'user' => $user,
            
        ]);
    }

    public function dataIndex()    
    {
        $data = DB::table('communities')
                ->orderBy('updated_at','DESC')
                ->get();

            return Datatables()->of($data)->addIndexColumn()->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('community.create')->with([
            'user' => $user,
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data = [
            'title' => $request->title,
            'description' => $request->editor,
            'image' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('communities')->insert($data);
        Session::flash('success', 'Data berhasil ditambahkan');
        return redirect()->route('community.index');
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
        $model = DB::table('communities')->where('id', $id)->first();
       
        return view('community.edit')->with([
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
            'title' => $request->title,
            'description' => $request->editor,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('communities')->where('id', $id)->update($data);
        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('community.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = DB::table('communities')->where('id', $id)->first();
        if ($news) {
            // Delete the image from storage
            $imagePath = public_path('images/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the news record from the database
            DB::table('communities')->where('id', $id)->delete();
            Session::flash('success', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }
        return redirect()->route('community.index');
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $model = DB::table('communities')->where('id', $id)->first();
        $model_all = DB::table('communities')->orderBy('updated_at', 'desc')->limit(10)->get();
        return view('frontend.community.view')->with([
            'user' => $user,
            'model' => $model,
            'id' => $id,
            'model_all' => $model_all,
        ]);
        
    }
}
