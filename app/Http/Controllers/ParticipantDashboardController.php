<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantDashboardController extends Controller
{
    public function index()
    {
        $participant = auth()->guard('participant')->user();

        // Statistik absensi peserta
        $stats = $this->getParticipantStats($participant);

        // Riwayat absensi terbaru
        $recentAttendances = Attendance::where('participant_id', $participant->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Data bulanan untuk chart
        $monthlyData = $this->getMonthlyAttendanceData($participant);

        return view('participant.dashboard', compact(
            'participant',
            'stats',
            'recentAttendances',
            'monthlyData'
        ));
    }

    private function getParticipantStats($participant)
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return [
            'total_attendance' => Attendance::where('participant_id', $participant->id)->count(),
            'present_today' => Attendance::where('participant_id', $participant->id)
                ->whereDate('date', $today)
                ->where('status', 'present')
                ->count(),
            'late_today' => Attendance::where('participant_id', $participant->id)
                ->whereDate('date', $today)
                ->where('status', 'late')
                ->count(),
            'monthly_attendance' => Attendance::where('participant_id', $participant->id)
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->count(),
            'present_count' => Attendance::where('participant_id', $participant->id)
                ->where('status', 'present')
                ->count(),
            'late_count' => Attendance::where('participant_id', $participant->id)
                ->where('status', 'late')
                ->count(),
            'attendance_rate' => $this->calculateAttendanceRate($participant),
        ];
    }

    private function calculateAttendanceRate($participant)
    {
        $startDate = $participant->start_date ? Carbon::parse($participant->start_date) : Carbon::now()->startOfMonth();
        $endDate = $participant->end_date ? Carbon::parse($participant->end_date) : Carbon::now();

        $workingDays = $this->getWorkingDays($startDate, $endDate);
        $actualAttendance = Attendance::where('participant_id', $participant->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

        if ($workingDays > 0) {
            return round(($actualAttendance / $workingDays) * 100, 1);
        }

        return 0;
    }

    private function getWorkingDays($startDate, $endDate)
    {
        $days = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            // Hanya hitung hari kerja (Senin-Jumat)
            if ($current->dayOfWeek >= 1 && $current->dayOfWeek <= 5) {
                $days++;
            }
            $current->addDay();
        }

        return $days;
    }

    private function getMonthlyAttendanceData($participant)
    {
        $currentYear = Carbon::now()->year;

        return Attendance::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present'),
            DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late')
        )
            ->where('participant_id', $participant->id)
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->month => [
                        'total' => $item->total,
                        'present' => $item->present,
                        'late' => $item->late
                    ]
                ];
            });
    }
}
