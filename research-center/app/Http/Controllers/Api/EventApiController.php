<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventApiController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return response()->json($events);
    }

    public function frontendIndex(Request $request)
    {
        $query = Event::query();

        if ($request->has('event_type') && $request->event_type !== '') {
            $query->where('event_type', $request->event_type);
        }

        $events = $query->orderBy('date', 'desc')->paginate(6);
        $latestEvents = Event::latest()->take(3)->get();

        return response()->json([
            'events' => $events,
            'latest' => $latestEvents,
        ]);
    }

    public function view($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/events'), $imageName);
            $imagePath = 'storage/events/' . $imageName;
        }

        $event = Event::create([
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

        return response()->json(['message' => 'Event created successfully', 'data' => $event], 201);
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
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
            if ($event->image && File::exists(public_path($event->image))) {
                File::delete(public_path($event->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/events'), $imageName);

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
            'image' => $event->image,
        ]);

        return response()->json(['message' => 'Event updated successfully', 'data' => $event]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image && File::exists(public_path($event->image))) {
            File::delete(public_path($event->image));
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function verifiedParticipants()
    {
        $registrations = EventRegistration::with(['user', 'event', 'certificate','order'])
            ->where('token_verified', 'verified')
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($registrations);
    }

    public function uploadCertificate(Request $request, $registrationId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $registration = EventRegistration::with('event')->findOrFail($registrationId);

        $file = $request->file('certificate');
        $filename = 'certificate_' . $registration->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/certificate');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $file->move($destinationPath, $filename);
        $publicPath = 'storage/certificate/' . $filename;

        $certificate = EventCertificate::updateOrCreate([
            'event_registration_id' => $registration->id,
        ], [
            'user_id' => $registration->user_id,
            'event_id' => $registration->event_id,
            'certificate_link' => $publicPath,
            'issued_at' => now(),
        ]);

        return response()->json(['message' => 'Sertifikat berhasil diunggah', 'data' => $certificate]);
    }
public function downloadCertificate($event_registration_id)
{
    $registration = EventRegistration::with('certificate')
        ->where('id', $event_registration_id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$registration || !$registration->certificate) {
        return response()->json(['message' => 'Sertifikat tidak ditemukan'], 404);
    }

    $path = public_path($registration->certificate->certificate_link);

    if (!file_exists($path)) {
        return response()->json(['message' => 'File tidak ditemukan'], 404);
    }

    return response()->download($path);
}


}
