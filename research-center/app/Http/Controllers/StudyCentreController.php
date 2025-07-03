<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StudyCentreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('study-centre.index')->with([
            'user' => $user,
            
        ]);
    }

    public function dataIndex()    
    {
        $data = DB::table('study_centres')
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
        return view('study-centre.create')->with([
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
        DB::table('study_centres')->insert($data);
        Session::flash('success', 'Data berhasil ditambahkan');
        return redirect()->route('study-centre.index');
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
        $model = DB::table('study_centres')->where('id', $id)->first();
       
        return view('study-centre.edit')->with([
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
        DB::table('study_centres')->where('id', $id)->update($data);
        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('study-centre.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = DB::table('study_centres')->where('id', $id)->first();
        if ($news) {
            // Delete the image from storage
            $imagePath = public_path('images/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the news record from the database
            DB::table('study_centres')->where('id', $id)->delete();
            Session::flash('success', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }
        return redirect()->route('study-centre.index');
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $model = DB::table('study_centres')->where('id', $id)->first();
        $model_all = DB::table('study_centres')->orderBy('updated_at', 'desc')->limit(10)->get();
        return view('frontend.study-centre.view')->with([
            'user' => $user,
            'model' => $model,
            'id' => $id,
            'model_all' => $model_all,
        ]);
        
    }

}
