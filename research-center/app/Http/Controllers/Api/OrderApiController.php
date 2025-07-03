<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\EventRegistration;
use App\Models\ResearchData;
use App\Models\Review;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Storage;

class OrderApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->get();
        return response()->json($orders);
    }

    public function verifyAttendanceToken(Request $request)
    {
        $request->validate([
            'event_registration_id' => 'required|integer',
            'attendance_token' => 'required|string',
        ]);

        $registration = EventRegistration::with('event')
            ->where('id', $request->event_registration_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Registrasi event tidak ditemukan.'], 404);
        }

        if ($registration->event->attendance_token === $request->attendance_token) {
            $registration->token_verified = 'verified';
            $registration->save();

            foreach (User::whereHas('roles', function ($q) {
    $q->where('name', 'admin');
})->get() as $admin) {
                $admin->notify(new AdminNotification(
                    "{$registration->user->name} berhasil verifikasi token untuk event {$registration->event->name}", null
                ));
            }

            return response()->json(['message' => 'Token berhasil diverifikasi.']);
        }

        $registration->token_verified = 'failed';
        $registration->save();

        return response()->json(['message' => 'Token tidak valid.'], 400);
    }

    public function submitReview(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'reviews' => 'required|array',
            'reviews.*' => 'required|string|max:2000',
        ]);

        foreach ($request->reviews as $researchId => $reviewText) {
            Review::updateOrCreate([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'research_data_id' => $researchId,
            ], ['review' => $reviewText]);
        }

        $order->status = 'reviewed';
        $order->save();

        foreach (User::whereHas('roles', function ($q) {
    $q->where('name', 'admin');})->get() as $admin) {
            $admin->notify(new AdminNotification("User {$order->user->name} memberikan review untuk order #{$order->id}", $order->id));
        }

        return response()->json(['message' => 'Review berhasil dikirim.']);
    }
    public function downloadDataset($id)
{
    $user = Auth::user();

    try {
        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->whereIn('status', ['paid', 'delivered', 'reviewed'])
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan atau tidak valid.'], 404);
        }

        $datasetPaths = [];
        $itemIds = json_decode($order->item_id, true);
        $itemTypes = json_decode($order->item_type, true);

        if (!$itemIds || !$itemTypes) {
            return response()->json(['message' => 'Format item_id atau item_type tidak valid.'], 400);
        }

        foreach ($itemIds as $index => $itemId) {
            if (($itemTypes[$index] ?? null) === 'research_data') {
                $researchData = ResearchData::find($itemId);

                if (!$researchData || !is_array($researchData->file_path)) {
                    continue;
                }

                foreach ($researchData->file_path as $filePath) {
                    $fullPath = public_path($filePath);
                    if (file_exists($fullPath)) {
                        $datasetPaths[] = $fullPath;
                    }
                }
            }
        }

        if (empty($datasetPaths)) {
            return response()->json(['message' => 'File tidak ditemukan atau kosong.'], 404);
        }

        $zip = new \ZipArchive();
        $zipFileName = 'datasets_order_' . $order->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['message' => 'Gagal membuat file ZIP.'], 500);
        }

        foreach ($datasetPaths as $path) {
            $zip->addFile($path, basename($path));
        }

        $zip->close();

        if ($order->status === 'paid') {
            $order->status = 'delivered';
            $order->save();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);

    } catch (\Throwable $e) {
        return response()->json(['message' => 'Gagal download: ' . $e->getMessage()], 500);
    }
}


    public function downloadInvoice($id)
    {
        $order = Order::with('coupon')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $itemIds   = json_decode($order->item_id, true);
        $itemTypes = json_decode($order->item_type, true);
        $itemNames = [];

        foreach ($itemTypes as $index => $type) {
            $itemId = $itemIds[$index];
            if ($type === 'research_data') {
                $item = ResearchData::find($itemId);
                $itemNames[] = $item ? $item->research_title : 'Unknown Dataset';
            } elseif ($type === 'event') {
                $item = \App\Models\Event::find($itemId);
                $itemNames[] = $item ? $item->name : 'Unknown Event';
            } else {
                $itemNames[] = 'Unknown';
            }
        }

        $pdf = Pdf::loadView('frontend.order.invoice', [
            'order' => $order,
            'itemNames' => $itemNames,
        ])->setPaper('a4');

        $filename = 'invoice_order_' . $order->id . '.pdf';
        $path = storage_path('app/public/' . $filename);
        $pdf->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function exportExcel()
    {
        $filename = 'laporan-pesanan.xlsx';
        $path = storage_path("app/public/{$filename}");
        Excel::store(new OrdersExport, "public/{$filename}");
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
