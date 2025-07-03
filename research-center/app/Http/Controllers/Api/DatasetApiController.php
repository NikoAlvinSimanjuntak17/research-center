<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ResearchData;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DatasetApiController extends Controller
{
    public function index(Request $request)
    {
        $query = ResearchData::orderBy('updated_at', 'desc');

        if ($request->has('category')) {
            $query->where('research_category_id', $request->category);
        }

        $datasets = $query->paginate(10);

        return response()->json($datasets);
    }

    public function show($id)
    {
        $dataset = ResearchData::findOrFail($id);
        return response()->json($dataset);
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
            'file_paths.*' => 'nullable|file|max:50120',
            'preview_path' => 'nullable|file|max:50120',
        ]);

        $categoryName = Category::find($request->research_category_id)->category_name ?? '';
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
        }

        $previewPath = null;
        if ($request->hasFile('preview_path')) {
            $file = $request->file('preview_path');
            $previewFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/previews'), $previewFileName);
            $previewPath = 'storage/previews/' . $previewFileName;
        }

        $data = ResearchData::create([
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

        return response()->json(['message' => 'Dataset created', 'data' => $data], 201);
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
            'file_paths.*' => 'nullable|file|max:50120',
            'preview_path' => 'nullable|file|max:50120',
        ]);

        $data = ResearchData::findOrFail($id);

        $filePaths = $data->file_path;
        if ($request->hasFile('file_paths')) {
            $filePaths = [];
            foreach ($request->file('file_paths') as $file) {
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/datasets'), $fileName);
                $filePaths[] = 'storage/datasets/' . $fileName;
            }
        }

        if ($request->hasFile('preview_path')) {
            $file = $request->file('preview_path');
            $previewFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/previews'), $previewFileName);
            $data->preview_path = 'storage/previews/' . $previewFileName;
        }

        $data->update([
            'research_title' => $request->research_title,
            'abstract' => $request->abstract,
            'price' => $request->price,
            'research_category_id' => $request->research_category_id,
            'research_category_name' => Category::find($request->research_category_id)->category_name ?? '',
            'researcher_id' => $request->researcher_id,
            'researcher_name' => DB::table('researchers')
                ->join('users', 'researchers.user_id', '=', 'users.id')
                ->where('researchers.id', $request->researcher_id)
                ->value('users.name'),
            'year' => $request->year,
            'doi' => $request->doi,
            'file_path' => $filePaths,
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['message' => 'Dataset updated', 'data' => $data]);
    }

    public function destroy($id)
    {
        $data = ResearchData::findOrFail($id);

        foreach ((array) $data->file_path as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) unlink($fullPath);
        }

        if ($data->preview_path && file_exists(public_path($data->preview_path))) {
            unlink(public_path($data->preview_path));
        }

        $data->delete();

        return response()->json(['message' => 'Dataset deleted']);
    }

    public function download($id)
    {
        $data = ResearchData::findOrFail($id);
        $paths = (array) $data->file_path;
        $zip = new \ZipArchive();
        $zipFileName = 'dataset_' . $data->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create ZIP'], 500);
        }

        foreach ($paths as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                $zip->addFile($fullPath, basename($path));
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function edit($id)
{
    $dataset = ResearchData::findOrFail($id);
    return response()->json($dataset);
}

public function dataIndex()
{
    $data = ResearchData::orderBy('updated_at', 'DESC')->get();

    return response()->json($data); // Kalau kamu pakai DataTables AJAX JS, bisa diubah jadi format datatables
}

public function frontendIndex(Request $request)
{
    $query = ResearchData::orderBy('updated_at', 'desc');

    if ($request->has('category')) {
        $query->where('research_category_id', $request->category);
    }

    return response()->json($query->paginate(10));
}

public function frontendShow($id)
{
    $dataset = ResearchData::findOrFail($id);
    return response()->json($dataset);
}
public function preview(Request $request, $filename)
{
    $filePath = public_path('storage/previews/' . $filename);

    if (!file_exists($filePath)) {
        return response()->json([
            'message' => 'File not found',
            'path_checked' => $filePath,
        ], 404);
    }

    $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $baseName = pathinfo($filename, PATHINFO_FILENAME);

    if ($ext === 'pdf') {
        $jpg = public_path("storage/preview_images/{$baseName}-1.jpg");

        if (!file_exists($jpg)) {
            $pdftoppmPath = "C:\\poppler-24.08.0\\Library\\bin\\pdftoppm.exe";
            $cmd = "\"$pdftoppmPath\" -jpeg -f 1 -l 1 \"$filePath\" \"" . public_path("storage/preview_images/{$baseName}") . "\"";

            exec($cmd, $output, $status);

            if ($status !== 0) {
                return response()->json([
                    'message' => 'Konversi PDF gagal',
                    'command' => $cmd,
                    'status' => $status,
                    'output' => $output,
                ], 500);
            }
        }

        if (!file_exists($jpg)) {
            return response()->json([
                'message' => 'JPG hasil konversi tidak ditemukan',
                'expected_jpg' => $jpg,
            ], 500);
        }

        return response()->file($jpg);
    }

    return response()->json(['message' => 'Format tidak didukung'], 415);
}

}
