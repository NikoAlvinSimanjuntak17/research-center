<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admission.index')->with([
            'user' => $user,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataIndex()    
    {
        $data = DB::table('admissions')
                ->orderBy('id','ASC')
                ->get();

            return Datatables()->of($data)
                ->addIndexColumn()
                /*->editColumn('delete', function ($row) use ($path) {
                    $delete = '<a href="javascript:void(0)" data-toggle="tooltip"  data-kode_kelas_cabang="'.$row->kode_kelas.'" data-original-title="Hapus Kelas" class="btn btn-danger rounded-pill mb-3 remove_kelas_cabang"><span class="fa fa-trash"></span> Hapus</a>';

                                return $edit_kelas_cabang;
                })*/
                ->rawColumns([
                    
                ])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('admission.create')->with([
            'user' => $user,
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the request data
        $image = $request->file('file');
        $imageName = time().'.'.$image->getClientOriginalName();
        $image->move(public_path('files'), $imageName);
        $data = [
            'title' => $request->title,
            'description' => $request->editor,
            'file' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('admissions')->insert($data);
        Session::flash('success', 'Admisi berhasil ditambahkan');
        return redirect()->route('admission.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = Auth::user();
        $admission = DB::table('admissions')->where('id', $id)->first();
        return view('admission.show')->with([
            'user' => $user,
            'admission' => $admission,
            'id' => $id,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // 
        $user = Auth::user();
        $admission = DB::table('admissions')->where('id', $id)->first();
        return view('admission.edit')->with([
            'user' => $user,
            'admission' => $admission,
            'id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validate the request data
        // $this->validate($request, [
        //     'title' => 'required',
        //     'editor' => 'required',
        //     'file' => 'nullable|file|mimes:pdf|max:2048',
        // ]);
        $data = [
            'title' => $request->title,
            'description' => $request->editor,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('file')) {
            // Delete the old file
            $admission = DB::table('admissions')->where('id', $id)->first();
            if ($admission) {
                Storage::delete('files/' . $admission->file);
            }
            // Store the new file
            $image = $request->file('file');
            $imageName = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('files'), $imageName);
            $data['file'] = $imageName;
        }
        DB::table('admissions')->where('id', $id)->update($data);
        Session::flash('success', 'Admisi berhasil diupdate');
        return redirect()->route('admission.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        //create delete function
        $admission = DB::table('admissions')->where('id', $id)->first();
        if ($admission) {
            // Delete the file from storage
            Storage::delete('files/' . $admission->file);
            // Delete the record from the database
            DB::table('admissions')->where('id', $id)->delete();
            Session::flash('success', 'Admisi berhasil dihapus');
        } else {
            Session::flash('error', 'Admisi tidak ditemukan');
        }
        return redirect()->route('admission.index');
        
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $admission = DB::table('admissions')->where('id', $id)->first();
        return view('frontend.admission.view')->with([
            'user' => $user,
            'admission' => $admission,
            'id' => $id,
        ]);
        
    }
}
