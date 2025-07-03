<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Coupon;
use App\Models\EventRegistration;
use App\Models\EventCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('event.index', compact('events'));
    }
    public function frontendIndex(Request $request)
    {
        $query = Event::query();

        if ($request->has('event_type') && $request->event_type !== '') {
            $query->where('event_type', $request->event_type);
        }

        $events = $query->orderBy('date', 'desc')->paginate(6); // Gunakan paginate

        $latestEvents = Event::latest()->take(3)->get();

            // Ambil 1 kupon terbaru yang belum kadaluarsa
        $latestCoupon = Coupon::where('expired_at', '>', now())
        ->orderBy('created_at', 'desc')
        ->first();

        return view('frontend.event.index', compact('events', 'latestEvents','latestCoupon'));
    }
    public function view($id)
    {
        $event = Event::findOrFail($id);
            $latestCoupon = Coupon::where('expired_at', '>', now())
        ->orderBy('created_at', 'desc')
        ->first();
        return view('frontend.event.view', compact('event','latestCoupon'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'people' => 'required|integer',
            'image' => 'nullable|image|max:5048',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'event_type' => 'required|in:workshop,seminar,conference',
            'status' => 'nullable|string',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/events'), $imageName);
            $imagePath = 'storage/events/' . $imageName;
        } else {
            $imagePath = null;
        }


        Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
            'people' => $request->people,
            'image' => $imagePath,
            'description' => $request->description,
            'price' => $request->price,
            'event_type' => $request->event_type,
            'status' => $request->status ?? 'schedule',
            'registration_start_date' => $request->registration_start_date,
            'registration_end_date' => $request->registration_end_date,
            'attendance_token' => 'EVT-' . strtoupper(Str::random(6)),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'people' => 'required|integer',
            'image' => 'nullable|image|max:5048',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'event_type' => 'required|in:workshop,seminar,conference',
            'status' => 'nullable|string',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image && File::exists(public_path($event->image))) {
                File::delete(public_path($event->image));
            }

            // Simpan file baru ke public/storage/events
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/events'), $imageName);

            // Update path gambar
            $event->image = 'storage/events/' . $imageName;
        }

        $event->update([
            'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
            'people' => $request->people,
            'description' => $request->description,
            'price' => $request->price,
            'event_type' => $request->event_type,
            'status' => $request->status,
            'registration_start_date' => $request->registration_start_date,
            'registration_end_date' => $request->registration_end_date,
            'updated_by' => Auth::id(),
            'image' => $event->image, // pastikan tetap ditulis agar path tersimpan
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus.');
    }

    public function verifiedParticipants()
{
    $registrations = EventRegistration::with(['user', 'event', 'certificate','order'])
        ->where('token_verified', 'verified')
        ->orderByDesc('updated_at')
        ->get();

    return view('certificate.index', compact('registrations'));
}

    public function uploadCertificate(Request $request, $registrationId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096', // max 4MB
        ]);

        $registration = EventRegistration::with('event')->findOrFail($registrationId);

        $file = $request->file('certificate');
        $filename = 'certificate_' . $registration->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Lokasi final
        $destinationPath = public_path('storage/certificate');

        // Pastikan folder ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Pindahkan file ke lokasi
        $file->move($destinationPath, $filename);

        // Simpan path relatif ke database (agar bisa dipakai di URL)
        $publicPath = 'storage/certificate/' . $filename;

        EventCertificate::updateOrCreate([
            'event_registration_id' => $registration->id,
        ], [
            'user_id' => $registration->user_id,
            'event_id' => $registration->event_id,
            'certificate_link' => $publicPath,
            'issued_at' => now(),
        ]);

        return back()->with('success', 'Sertifikat berhasil diunggah.');
    }


}
