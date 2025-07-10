<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ResearchData;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Coupon;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;

class DatasetContoller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dataset.index', compact('user'));
    }
    public function detail($id)
{
    $data = ResearchData::findOrFail($id);
    return view('dataset._modal-detail', compact('data'));
}

public function frontendIndex(Request $request)
{
    $user = Auth::user();
    $categoryId = $request->query('category');

    $query = DB::table('research_datas')->orderBy('updated_at', 'desc');

    if ($categoryId) {
        $query->where('research_category_id', $categoryId);
    }

    $datasets = $query->paginate(10)->appends(['category' => $categoryId]);
    $category = DB::table('categories')->get();

    // Ambil 1 kupon terbaru yang belum kadaluarsa
    $latestCoupon = Coupon::where('expired_at', '>', now())
        ->orderBy('created_at', 'desc')
        ->first();

    return view('frontend.dataset.index')->with([
        'user' => $user,
        'datasets' => $datasets,
        'news_category' => $category,
        'latestCoupon' => $latestCoupon, // <-- kirim ke view
    ]);
}
public function view($id)
{
    $user = Auth::user();
    $dataset = ResearchData::with(['reviews.user'])->findOrFail($id); // eager load user dari review
    $latestCoupon = Coupon::where('expired_at', '>', now())
        ->orderBy('created_at', 'desc')
        ->first();
    return view('frontend.dataset.view', compact('dataset', 'user','latestCoupon'));
}

    public function downloadDirect($id)
    {
        $dataset = ResearchData::findOrFail($id);

        $filePaths = (array) $dataset->file_path; // Pastikan array
        $datasetPaths = [];

        foreach ($filePaths as $filePath) {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath)) {
                $datasetPaths[] = $fullPath;
            }
        }

        if (empty($datasetPaths)) {
            return redirect()->back()->with('error', 'File dataset tidak ditemukan.');
        }
        
        $zip = new \ZipArchive();
        $zipFileName = 'dataset_' . $dataset->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
        }

        foreach ($datasetPaths as $path) {
            $zip->addFile($path, basename($path));
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }



    public function dataIndex()
    {
        $data = ResearchData::orderBy('updated_at', 'DESC')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $detail = '<button class="btn btn-info btn-sm" onclick="showDetail(' . $row->id . ')">Detail</button>';
                $edit = '<a href="' . route('dataset.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $delete = '<a href="' . route('dataset.destroy', $row->id) . '" onclick="return confirm(\'Yakin ingin hapus?\')" class="btn btn-danger btn-sm">Hapus</a>';
                return $detail . ' ' . $edit . ' ' . $delete;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();

        // Join ke tabel users untuk ambil nama user dari researcher
        $researchers = DB::table('researchers')
            ->join('users', 'researchers.user_id', '=', 'users.id')
            ->select('researchers.id as id', 'users.name as name')
            ->get();

        return view('dataset.create', compact('user', 'categories', 'researchers'));
    }


    public function store(Request $request)
        {
            $request->validate([
                'research_title' => 'required|string',
                'abstract' => 'required|string',
                'price' => 'required|numeric',
                'research_category_id' => 'required|integer',
                'researcher_id' => 'required|integer',
                'year' => 'required|integer',
                'doi' => 'required|string',
                'file_paths.*' => 'nullable|file|max:10485760',
                'preview_path' => 'nullable|file|max:10485760',
            ]);

            // Ambil nama kategori
            $categoryName = Category::where('id', $request->research_category_id)->value('category_name');

            // Ambil nama peneliti dari tabel users melalui tabel researchers
            $researcherName = DB::table('researchers')
                ->join('users', 'researchers.user_id', '=', 'users.id')
                ->where('researchers.id', $request->researcher_id)
                ->value('users.name');

            // Simpan file dataset
            $filePaths = [];
            if ($request->hasFile('file_paths')) {
                foreach ($request->file('file_paths') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/datasets'), $fileName);
                    $filePaths[] = 'storage/datasets/' . $fileName;
                }
            }

            // Simpan preview
            $previewPath = null;
            if ($request->hasFile('preview_path')) {
                $previewFile = $request->file('preview_path');
                $previewFileName = Str::uuid() . '.' . $previewFile->getClientOriginalExtension();
                $previewFile->move(public_path('storage/previews'), $previewFileName);
                $previewPath = 'storage/previews/' . $previewFileName;
            }

            // Simpan ke database
            ResearchData::create([
                'research_title' => $request->research_title,
                'abstract' => $request->abstract,
                'price' => $request->price,
                'research_category_id' => $request->research_category_id,
                'research_category_name' => $categoryName,
                'researcher_id' => $request->researcher_id,
                'researcher_name' => $researcherName,
                'year' => $request->year,
                'doi' => $request->doi,
                'file_path' => $filePaths,
                'preview_path' => $previewPath,
                'created_by' => Auth::id(),
            ]);

            Session::flash('success', 'Dataset berhasil ditambahkan');
            return redirect()->route('dataset.index');
    }


    public function edit($id)
    {
        $user = Auth::user();
        $product = ResearchData::findOrFail($id);
        $categories = Category::all();
        $researchers = Researcher::all();

        return view('dataset.edit', compact('user', 'product', 'categories', 'researchers', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'research_title' => 'required|string',
            'abstract' => 'required|string',
            'price' => 'required|numeric',
            'research_category_id' => 'required|integer',
            'researcher_id' => 'required|integer',
            'year' => 'required|integer',
            'doi' => 'required|string',
            'file_paths.*' => 'nullable|file|max:10485760',
            'preview_path' => 'nullable|file|max:10485760',

        ]);

        $product = ResearchData::findOrFail($id);

        $categoryName = Category::where('id', $request->research_category_id)->value('category_name');

        $researcherName = DB::table('researchers')
            ->join('users', 'researchers.user_id', '=', 'users.id')
            ->where('researchers.id', $request->researcher_id)
            ->value('users.name');

        $filePaths = [];
        if ($request->hasFile('file_paths')) {
            foreach ($request->file('file_paths') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/datasets'), $fileName);
                    $filePaths[] = 'storage/datasets/' . $fileName;
                }
            $product->update([
                'file_path' => $filePaths,
            ]);
        }
        if ($request->hasFile('preview_path')) {
                $previewFile = $request->file('preview_path');
                $previewFileName = Str::uuid() . '.' . $previewFile->getClientOriginalExtension();
                $previewFile->move(public_path('storage/previews'), $previewFileName);
                $previewPath = 'storage/previews/' . $previewFileName;
                
                $product->update([
                'preview_path' => $previewPath,
            ]);
        }


        $product->update([
            'research_title' => $request->research_title,
            'abstract' => $request->abstract,
            'price' => $request->price,
            'research_category_id' => $request->research_category_id,
            'research_category_name' => $categoryName,
            'researcher_id' => $request->researcher_id,
            'researcher_name' => $researcherName,
            'year' => $request->year,
            'doi' => $request->doi,
            'updated_by' => Auth::id(),
        ]);

        Session::flash('success', 'Dataset berhasil diperbarui');
        return redirect()->route('dataset.index');
    }


    public function destroy($id)
    {
        $product = ResearchData::findOrFail($id);

        foreach ((array) $product->file_path as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) unlink($fullPath);
        }

        if ($product->preview_path && file_exists(public_path($product->preview_path))) {
            unlink(public_path($product->preview_path));
        }

        $product->delete();
        Session::flash('success', 'Dataset berhasil dihapus');
        return redirect()->route('dataset.index');
    }

        public function show(Request $request, $filename)
    {
        $filePath = public_path('storage/previews/' . $filename);
        if (!file_exists($filePath)) abort(404, 'Preview file not found.');

        $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $baseName = pathinfo($filename, PATHINFO_FILENAME);

        /* ---------- PDF ---------- */
        if ($ext === 'pdf') {
            $jpg = public_path("storage/preview_images/{$baseName}-1.jpg");
            if (!file_exists($jpg)) {
                $pdftoppmPath = "C:\\poppler-24.08.0\\Library\\bin\\pdftoppm.exe";
                exec("\"$pdftoppmPath\" -jpeg -f 1 -l 1 \"$filePath\" \"" . public_path("storage/preview_images/{$baseName}") . "\"");
            }
            return response()->file($jpg);
        }

        /* ---------- FASTQ / FQ ---------- */
if (in_array($ext, ['fastq', 'fq'])) {
    // Ambil jumlah byte dari query (default 1 MB)
    $bytes  = intval($request->query('bytes', 1048576));

    // Batasi maksimal hanya sampai 10 MB
    $bytes  = max(0, min($bytes, 10485760)); // 10 * 1024 * 1024

    $handle = fopen($filePath, 'rb');
    $data   = ($bytes > 0) ? fread($handle, $bytes) : file_get_contents($filePath);
    fclose($handle);

    // Potong di newline terakhir agar tidak ada baris terpotong
    $nlPos  = strrpos($data, "\n");
    if ($nlPos !== false) $data = substr($data, 0, $nlPos);

    return response($data, 200, [
        'Content-Type'   => 'text/plain; charset=utf-8',
        'Content-Length' => strlen($data),
        'Cache-Control'  => 'no-store'
    ]);
}


        abort(415, 'Unsupported preview file format.');
    }
}
