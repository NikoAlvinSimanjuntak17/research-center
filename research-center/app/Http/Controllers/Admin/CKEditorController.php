<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        try {
            if (!$request->hasFile('upload')) {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }

            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $file = $request->file('upload');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $filename);

            return response()->json([
                'url' => asset('storage/uploads/' . $filename),
            ]);
        } catch (\Exception $e) {
            Log::error('CKEditor Upload Error: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed.'], 500);
        }
    }
}
