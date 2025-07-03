<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\EventRegistration;
use App\Models\ResearchData;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
class Ordercontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->get();

        $currentOrders = $orders->filter(fn($o) => !in_array($o->status, ['delivered', 'reviewed']));
        $historyOrders = $orders->filter(fn($o) => in_array($o->status, ['delivered', 'reviewed']));
        
        $eventRegistrations = EventRegistration::with(['event', 'certificate'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        
        return view('frontend.order.index', compact('currentOrders', 'historyOrders', 'eventRegistrations'));
    }
    public function adminIndex()
{
    $orders = Order::with('user')
        ->orderByDesc('created_at')
        ->get();

    return view('order.index', compact('orders'));
}

public function verifyAttendanceToken(Request $request): JsonResponse
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
        return response()->json([
            'message' => 'Registrasi event tidak ditemukan.'
        ], 404);
    }

    // Bandingkan token yang dimasukkan dengan token dari event yang bersangkutan
    if ($registration->event->attendance_token === $request->attendance_token) {
        $registration->token_verified = 'verified';
        $registration->save();
         // Kirim notifikasi ke admin
        $admins = User::whereHas('roles', function($q) {
                    $q->where('name', 'admin');
                })->get();        
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification(
                "{$registration->user->name} berhasil memverifikasi token untuk event {$registration->event->name}",
                null // karena tidak ada order ID
            ));
        }


        return response()->json([
            'message' => 'Token berhasil diverifikasi. Harap tunggu admin akan segera menerbitkan sertifikat.'
        ]);
        
    }

    // Token salah
    $registration->token_verified = 'failed';
    $registration->save();

    return response()->json([
        'message' => 'Token tidak valid.'
    ], 400);
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
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau tidak valid.');
        }

        $datasetPaths = [];
        $itemIds = json_decode($order->item_id, true);
        $itemTypes = json_decode($order->item_type, true);

        if (!$itemIds || !$itemTypes) {
            return redirect()->back()->with('error', 'Format item_id atau item_type tidak valid.');
        }

        foreach ($itemIds as $index => $itemId) {
            if (($itemTypes[$index] ?? null) === 'research_data') {
                $researchData = ResearchData::find($itemId);

                if (!$researchData) {
                    Log::warning("Dataset dengan ID $itemId tidak ditemukan.");
                    continue;
                }

                $files = $researchData->file_path;

                if (!is_array($files)) {
                    Log::warning("File path dataset ID $itemId bukan array.", ['file_path' => $files]);
                    continue;
                }

                foreach ($files as $filePath) {
                    $fullPath = public_path($filePath);
                    if (File::exists($fullPath)) {
                        $datasetPaths[] = $fullPath;
                    } else {
                        Log::warning("File tidak ditemukan: " . $fullPath);
                    }
                }
            }
        }

        if (empty($datasetPaths)) {
            return redirect()->back()->with('error', 'Dataset tidak ditemukan atau file kosong.');
        }

        $zip = new \ZipArchive();
        $zipFileName = 'datasets_order_' . $order->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuka ZIP untuk penulisan.');
        }

        foreach ($datasetPaths as $path) {
            $zip->addFile($path, basename($path));
        }

        $zip->close();

        // Update status menjadi delivered
        if ($order->status === 'paid') {
            $order->status = 'delivered';
            $order->save();
        }

        // Kirim notifikasi ke admin
        $admins = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification("User {$user->name} telah mengunduh dataset untuk pesanan #{$order->id}", $order->id));
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    } catch (\Throwable $e) {
        Log::error('Gagal saat download dataset order', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat proses download: ' . $e->getMessage());
    }
}

public function showReviewForm($orderId)
{
    $order = Order::where('id', $orderId)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $itemIds = json_decode($order->item_id, true);
    $itemTypes = json_decode($order->item_type, true);

    $researchDatas = [];

    foreach ($itemIds as $index => $id) {
        if ($itemTypes[$index] === 'research_data') {
            $data = ResearchData::find($id);
            if ($data) {
                $researchDatas[] = $data;
            }
        }
    }

    return view('frontend.order.review', compact('order', 'researchDatas'));
}


public function submitReview(Request $request, $orderId)
{
    $order = Order::where('id', $orderId)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $request->validate([
        'reviews' => 'required|array',
        'reviews.*' => 'required|string|max:2000',
    ]);

    foreach ($request->reviews as $researchId => $reviewText) {
        Review::updateOrCreate([
            'user_id' => Auth::id(),
            'order_id' => $orderId,
            'research_data_id' => $researchId,
        ], [
            'review' => $reviewText,
        ]);
    }

    // Update status menjadi "reviewed"
    $order->status = 'reviewed';
    $order->save();
    $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->get();
    foreach ($admins as $admin) {
        $admin->notify(new AdminNotification("User {$order->user->name} memberikan review untuk order #{$order->id}", $order->id));
    }


    return redirect()->route('frontend-orders.index')->with('success', 'Semua review berhasil dikirim.');
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

    return $pdf->download('invoice_order_' . $order->id . '.pdf');
}

public function exportExcel()
{
    return Excel::download(new OrdersExport, 'laporan-pesanan.xlsx');
}

}
