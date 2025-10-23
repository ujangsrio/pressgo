<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Statistics for dashboard
        $stats = $this->getDashboardStats();

        // Recent attendance
        $recentAttendances = Attendance::with('participant')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Monthly data for charts
        $monthlyData = $this->getMonthlyAttendanceData();

        // Participant statistics
        $participantStats = $this->getParticipantStatistics();

        return view('dashboard.index', compact(
            'stats',
            'recentAttendances',
            'monthlyData',
            'participantStats'
        ));
    }

    public function getDashboardData(Request $request)
    {
        // API endpoint for AJAX dashboard updates
        $stats = $this->getDashboardStats();
        $recentAttendances = Attendance::with('participant')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats' => $stats,
            'recentAttendances' => $recentAttendances,
            'lastUpdate' => now()->format('H:i:s')
        ]);
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Hitung total hari unik untuk rata-rata
        $totalDays = Attendance::select(DB::raw('COUNT(DISTINCT date) as days'))->first()->days;

        return [
            'total_participants' => Participant::count(),
            'total_attendance' => Attendance::count(),
            'today_attendance' => Attendance::whereDate('date', $today)->count(),
            'yesterday_attendance' => Attendance::whereDate('date', $yesterday)->count(),
            'present_today' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'late_today' => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'magang_count' => Participant::where('program_type', 'Magang')->count(),
            'pkl_count' => Participant::where('program_type', 'PKL')->count(),
            'avg_daily_attendance' => $this->getAverageDailyAttendance(),
            'attendance_trend' => $this->getAttendanceTrend(),
            'total_days' => $totalDays, // Tambahkan ini
            'new_this_week' => Participant::where('created_at', '>=', Carbon::now()->startOfWeek())->count()
        ];
    }

    private function getMonthlyAttendanceData()
    {
        $currentYear = Carbon::now()->year;

        return Attendance::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present'),
            DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late')
        )
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

    private function getParticipantStatistics()
    {
        return [
            'by_program' => Participant::select('program_type', DB::raw('COUNT(*) as count'))
                ->groupBy('program_type')
                ->get()
                ->pluck('count', 'program_type'),
            'by_institution' => Participant::select('institution', DB::raw('COUNT(*) as count'))
                ->groupBy('institution')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'top_attenders' => Participant::withCount(['attendances' => function ($query) {
                $query->whereNotNull('check_in');
            }])
                ->whereHas('attendances')
                ->orderBy('attendances_count', 'desc')
                ->take(5)
                ->get(),
            'new_this_week' => Participant::where('created_at', '>=', Carbon::now()->startOfWeek())->count()
        ];
    }

    private function getAverageDailyAttendance()
    {
        $totalDays = Attendance::select(DB::raw('COUNT(DISTINCT date) as days'))->first()->days;
        $totalAttendance = Attendance::count();

        return $totalDays > 0 ? round($totalAttendance / $totalDays, 1) : 0;
    }

    private function getAttendanceTrend()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayCount = Attendance::whereDate('date', $today)->count();
        $yesterdayCount = Attendance::whereDate('date', $yesterday)->count();

        if ($yesterdayCount == 0) {
            return $todayCount > 0 ? 100 : 0;
        }

        return round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1);
    }
}
