<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function scan()
    {
        return view('attendance.scan');
    }

    public function processAttendance(Request $request)
    {
        $request->validate([
            'barcode_id' => 'required|string'
        ]);

        $participant = Participant::where('barcode_id', $request->barcode_id)->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak valid'
            ], 404);
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
                    'message' => 'Keluar berhasil',
                    'participant' => $participant,
                    'type' => 'check_out'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan keluar hari ini'
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
                'message' => 'Masuk berhasil',
                'participant' => $participant,
                'type' => 'check_in',
                'status' => $status
            ]);
        }
    }

    public function index()
    {
        // Hanya ambil attendance yang memiliki participant
        $attendances = Attendance::with(['participant'])
            ->whereHas('participant') // Hanya yang punya participant
            ->latest()
            ->paginate(10);


        // Atau jika ingin tetap menampilkan yang participantnya null:
        // $attendances = Attendance::with('participant')->latest()->paginate(10);

        $stats = [
            'total' => Attendance::count(),
            'present' => Attendance::where('status', 'present')->count(),
            'late' => Attendance::where('status', 'late')->count(),
            'participants' => Participant::count(),
        ];

        return view('attendance.index', compact('attendances', 'stats'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('participant');
        return view('attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $participants = Participant::orderBy('name')->get();
        return view('attendance.edit', compact('attendance', 'participants'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,late,absent, izin',
            'notes' => 'nullable|string|max:500'
        ]);

        $attendance->update($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Data absensi berhasil diperbarui!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')
            ->with('success', 'Data absensi berhasil dihapus!');
    }
}
