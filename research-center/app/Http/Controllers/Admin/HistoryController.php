<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Histories;

class HistoryController extends Controller
{
    public function index()
    {
        $history = Histories::first();
        return view('admin.history.index', compact('history'));
    }

    public function create()
    {
        return view('admin.history.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Histories::create($request->only('content'));

        return redirect()->route('admin.history.index')->with('success', 'Sejarah berhasil disimpan.');
    }

    public function edit($id)
    {
        $history = Histories::findOrFail($id);
        return view('admin.history.edit', compact('history'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $history = Histories::findOrFail($id);
        $history->update($request->only('content'));

        return redirect()->route('admin.history.index')->with('success', 'Sejarah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $history = Histories::findOrFail($id);
        $history->delete();

        return redirect()->route('admin.history.index')->with('success', 'Sejarah berhasil dihapus.');
    }
}

