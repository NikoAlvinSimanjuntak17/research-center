<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function dataIndex()    
    {
        $data = DB::table('announcements')
                ->orderBy('updated_at','DESC')
                ->get();

            return Datatables()->of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $model = DB::table('announcements')->where('id', $id)->first();
        $model_all = DB::table('announcements')->orderBy('updated_at', 'desc')->limit(10)->get();
        
        return view('frontend.announcement.view')->with([
            'user' => $user,
            'model' => $model,
            'id' => $id,
            'model_all' => $model_all,
            
        ]);
        
    }

    public function frontendIndex()
    {
        //
        $user = Auth::user();
        $model = DB::table('announcements')->orderBy('updated_at', 'desc')->paginate(10);
        $model_all = DB::table('announcements')->orderBy('updated_at', 'desc')->limit(10)->get();
        return view('frontend.announcement.index')->with([
            'user' => $user,
            'model' => $model,
            'model_all' => $model_all,
        ]);
        
    }
}
