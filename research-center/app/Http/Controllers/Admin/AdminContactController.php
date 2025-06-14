<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        $existingKeys = Contact::select('key')->distinct()->pluck('key');

        return view('admin.contacts.create', compact('existingKeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'active' => 'required|boolean',
        ]);

        $data = $request->only(['key', 'title', 'value', 'active']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $fileName   = uniqid() . '.' . $image->getClientOriginalExtension();
            $targetPath = public_path('storgae/contacts');

            // Pastikan foldernya ada
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }

            $image->move($targetPath, $fileName);

            // Simpan path relatif untuk keperluan tampil di web
            $data['image'] = 'contacts/' . $fileName;
        }


        Contact::create($data);
        return redirect()->route('admin.contacts.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

public function update(Request $request, Contact $contact)
{
    $request->validate([
        'key' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'value' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
        'active' => 'required|boolean',
    ]);

    $data = $request->only(['key', 'title', 'value', 'active']);
    $data['updated_by'] = Auth::id();

    if ($request->hasFile('image')) {
        // Hapus file lama (jika ada) dari folder public
        if ($contact->image) {
            $oldImagePath = public_path($contact->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        // Simpan gambar baru ke folder public/contacts
        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $targetPath = public_path('storage/contacts');

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $image->move($targetPath, $fileName);
        $data['image'] = 'contacts/' . $fileName;
    }

    $contact->update($data);

    return redirect()->route('admin.contacts.index')->with('success', 'Kontak berhasil diperbarui.');
}

    public function destroy(Contact $contact)
    {
        if ($contact->image) {
            Storage::disk('public')->delete($contact->image);
        }
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Kontak berhasil dihapus.');
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }    
}
