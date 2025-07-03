<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CKEditorController extends Controller
{
    // Upload gambar dari CKEditor
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/ckeditor'), $filename);

            $url = asset('uploads/ckeditor/' . $filename);
            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }
    }

    // Hapus gambar dari folder CKEditor
    public function delete(Request $request)
    {
        $filename = $request->get('filename');

        // Validasi nama file agar tidak berbahaya
        if (!$filename || preg_match('/[^a-zA-Z0-9_\.\-]/', $filename)) {
            return response()->json(['error' => 'Nama file tidak valid.'], 400);
        }

        $path = public_path('uploads/ckeditor/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }
    }
}
