<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use App\Services\GeolocationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParticipantAttendanceController extends Controller
{
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    public function scan()
    {
        $locationSettings = $this->geolocationService->getLocationSettings();

        return view('participant.attendance.scan', compact('locationSettings'));
    }

    public function processAttendance(Request $request)
    {
        $participant = auth()->guard('participant')->user();

        // Validasi lokasi jika diperlukan
        $locationValidation = $this->validateLocation($request);
        if (!$locationValidation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $locationValidation['message'],
                'location_error' => true
            ], 400);
        }

        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = Attendance::where('participant_id', $participant->id)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if (!$attendance->check_out) {
                $attendance->update([
                    'check_out' => $now->format('H:i:s')
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Check out berhasil',
                    'participant' => $participant,
                    'type' => 'check_out',
                    'time' => $now->format('H:i:s'),
                    'location_info' => $locationValidation['message']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan check out hari ini'
                ], 400);
            }
        } else {
            $status = $now->format('H:i') > '08:00' ? 'late' : 'present';

            $attendance = Attendance::create([
                'participant_id' => $participant->id,
                'date' => $today,
                'check_in' => $now->format('H:i:s'),
                'status' => $status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check in berhasil',
                'participant' => $participant,
                'type' => 'check_in',
                'status' => $status,
                'time' => $now->format('H:i:s'),
                'location_info' => $locationValidation['message']
            ]);
        }
    }

    private function validateLocation(Request $request)
    {
        $locationSettings = $this->geolocationService->getLocationSettings();

        if (!$locationSettings['enabled']) {
            return ['valid' => true, 'message' => 'Pembatasan lokasi tidak aktif'];
        }

        // Get coordinates from request
        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');

        if (!$userLat || !$userLon) {
            return [
                'valid' => false,
                'message' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif dan izin lokasi diberikan.'
            ];
        }

        return $this->geolocationService->validateLocation($userLat, $userLon);
    }


    public function index()
    {
        $participant = auth()->guard('participant')->user();

        $attendances = Attendance::where('participant_id', $participant->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Attendance::where('participant_id', $participant->id)->count(),
            'present' => Attendance::where('participant_id', $participant->id)
                ->where('status', 'present')->count(),
            'late' => Attendance::where('participant_id', $participant->id)
                ->where('status', 'late')->count(),
            'this_month' => Attendance::where('participant_id', $participant->id)
                ->whereYear('date', Carbon::now()->year)
                ->whereMonth('date', Carbon::now()->month)
                ->count(),
        ];

        return view('participant.attendance.index', compact('attendances', 'stats'));
    }

    public function show(Attendance $attendance)
    {
        // Pastikan attendance milik peserta yang login
        if ($attendance->participant_id !== auth()->guard('participant')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $attendance->load('participant');
        return view('participant.attendance.show', compact('attendance'));
    }
}
