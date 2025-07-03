<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class LecturerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('lecturer.index')->with([
            'user' => $user,
            
        ]);
    }

    public function dataIndex()    
    {
        $data = DB::table('lecturers')
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
        return view('lecturer.create')->with([
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
            'full_name' => $request->full_name,
            'last_education' => $request->last_education,
            'expertise' => $request->expertise,
            'image' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('lecturers')->insert($data);
        Session::flash('success', 'Data berhasil ditambahkan');
        return redirect()->route('lecturer.index');
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
        $model = DB::table('lecturers')->where('id', $id)->first();
       
        return view('lecturer.edit')->with([
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
            'full_name' => $request->full_name,
            'last_education' => $request->last_education,
            'expertise' => $request->expertise,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('lecturers')->where('id', $id)->update($data);
        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('lecturer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = DB::table('lecturers')->where('id', $id)->first();
        if ($news) {
            // Delete the image from storage
            $imagePath = public_path('images/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the news record from the database
            DB::table('lecturers')->where('id', $id)->delete();
            Session::flash('success', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }
        return redirect()->route('lecturer.index');
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $model = DB::table('lecturers')->where('id', $id)->first();
        $model_all = DB::table('lecturers')->orderBy('updated_at', 'desc')->limit(10)->get();
        return view('frontend.lecturer.view')->with([
            'user' => $user,
            'model' => $model,
            'id' => $id,
            'model_all' => $model_all,
        ]);
        
    }

    public function frontendIndex()
    {
        $user = Auth::user();
        $model = DB::table('lecturers')->orderBy('updated_at', 'desc')->paginate(50);
        $model_all = DB::table('lecturers')->orderBy('updated_at', 'asc')->limit(50)->get();
        return view('frontend.lecturer.index')->with([
            'user' => $user,
            'model' => $model,
            'model_all' => $model_all,
        ]);
        
    }
}
