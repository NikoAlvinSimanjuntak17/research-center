<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('news.index')->with([
            'user' => $user,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataIndex()    
    {
        $data = DB::table('news')
                ->join('news_categories', 'news.news_category_id', '=', 'news_categories.id')
                ->select('news.*', 'news_categories.name as news_category_name')
                ->orderBy('news.updated_at','DESC')
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
        return view('news.create')->with([
            'user' => $user,
            
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $this->validate($request, [
        //     'news_category_id' => 'required',
        //     'title' => 'required',
        //     'editor' => 'required',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('storage/news'), $imageName);
        $data = [
            'news_category_id' => 1,
            'title' => $request->title,
            'description' => $request->editor,
            'image' => $imageName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('news')->insert($data);
        Session::flash('success', 'Berita berhasil ditambahkan');
        return redirect()->route('news.index');
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
        //
        $user = Auth::user();
        $news = DB::table('news')->where('id', $id)->first();
       
        $news_category = DB::table('news_categories')->get();
        return view('news.edit')->with([
            'user' => $user,
            'news' => $news,
            'id' => $id,
            'news_category' => $news_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        // $this->validate($request, [
        //     'news_category_id' => 'required',
        //     'title' => 'required',
        //     'editor' => 'required',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        $data = [
            'news_category_id' => 1,
            'title' => $request->title,
            'description' => $request->editor,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('storage/news/'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('news')->where('id', $id)->update($data);
        Session::flash('success', 'Berita berhasil diupdate');
        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $news = DB::table('news')->where('id', $id)->first();
        if ($news) {
            // Delete the image from storage
            $imagePath = public_path('storage/news/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the news record from the database
            DB::table('news')->where('id', $id)->delete();
            Session::flash('success', 'Berita berhasil dihapus');
        } else {
            Session::flash('error', 'Berita tidak ditemukan');
        }
        return redirect()->route('news.index');
    }

    public function view($id)
    {
        //
        $user = Auth::user();
        $news = DB::table('news')->where('id', $id)->first();
        $news_all = DB::table('news')->orderBy('updated_at', 'desc')->limit(10)->get();
        $news_category = DB::table('news_categories')->get();
        return view('frontend.news.view')->with([
            'user' => $user,
            'news' => $news,
            'id' => $id,
            'news_all' => $news_all,
            'news_category' => $news_category,
        ]);
        
    }

    public function frontendIndex()
    {
        //
        $user = Auth::user();
        $news = DB::table('news')->orderBy('updated_at', 'desc')->paginate(10);
        $news_category = DB::table('news_categories')->get();
        return view('frontend.news.index')->with([
            'user' => $user,
            'news' => $news,
            'news_category' => $news_category,
        ]);
        
    }

    
}
