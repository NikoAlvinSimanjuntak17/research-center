<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $existingKeys = Contact::select('key')->distinct()->pluck('key');

        return view('contacts.create', compact('existingKeys'));
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
            $file = $request->file('image');

            // Simpan ke storage/app/public/contacts
            $path = $file->store('contacts', 'public');
            $data['image'] = $path;

            // Buat folder public/storage/contacts jika belum ada
            $publicStoragePath = public_path('storage/contacts');
            if (!file_exists($publicStoragePath)) {
                mkdir($publicStoragePath, 0777, true);
            }

            // Salin file ke public/storage/contacts
            $filename = basename($path); // hanya nama file-nya
            copy(
                storage_path('app/public/contacts/' . $filename),
                public_path('storage/contacts/' . $filename)
            );
        }


        Contact::create($data);
        return redirect()->route('contact.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function edit(Contact $contact)
    {
        $existingKeys = Contact::select('key')->distinct()->pluck('key');
        return view('contacts.edit', compact('contact', 'existingKeys'));
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
    $file = $request->file('image');

    // Hapus file lama dari storage/app/public
    if ($contact->image && Storage::disk('public')->exists($contact->image)) {
        Storage::disk('public')->delete($contact->image);

        // Hapus juga dari public/storage jika ada
        $publicPath = public_path('storage/' . $contact->image);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    // Simpan file baru ke storage/app/public/contacts
    $path = $file->store('contacts', 'public');
    $data['image'] = $path;

    // Pastikan folder public/storage/contacts ada
    $publicFolder = public_path('storage/contacts');
    if (!file_exists($publicFolder)) {
        mkdir($publicFolder, 0777, true);
    }

    // Salin file ke public/storage/contacts
    $filename = basename($path);
    copy(
        storage_path('app/public/contacts/' . $filename),
        public_path('storage/contacts/' . $filename)
    );
}


        $contact->update($data);
        return redirect()->route('contact.index')->with('success', 'Kontak berhasil diperbarui.');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->image) {
            Storage::disk('public')->delete($contact->image);
        }
        $contact->delete();
        return redirect()->route('contact.index')->with('success', 'Kontak berhasil dihapus.');
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }
}
