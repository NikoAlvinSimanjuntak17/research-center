<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PublicationSyncService;

class PublicationSyncController extends Controller
{
    protected $syncService;

    public function __construct(PublicationSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function sync(Request $request)
    {
        ini_set('max_execution_time', 1000); // Tambah waktu eksekusi jika perlu

        $researcher = auth()->user()?->researcher;

        if (!$researcher) {
            return back()->with('error', 'Data peneliti tidak ditemukan.');
        }

        // ... existing code ...

        try {
            $this->syncService->syncFromOrcid($researcher->first());
            $this->syncService->syncFromScopus($researcher->first());
            $this->syncService->syncFromGaruda($researcher->first());
            $this->syncService->syncFromGoogleScholar($researcher->first());

            return back()->with('success', 'Sinkronisasi publikasi berhasil.');
        } catch (\Throwable $e) {
            \Log::error('Gagal sinkronisasi publikasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat sinkronisasi. Silakan coba lagi.');
        }
    }
}
