<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
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

        $topAttenders = Participant::withCount(['attendances' => function ($query) {
            $query->whereNotNull('check_in');
        }])
            ->whereHas('attendances')
            ->orderBy('attendances_count', 'desc')
            ->take(5)
            ->get();

        // Monthly data for charts
        $monthlyData = $this->getMonthlyAttendanceData();

        // Participant statistics
        $participantStats = $this->getParticipantStatistics();

        return view('reports.index', compact(
            'stats',
            'recentAttendances',
            'monthlyData',
            'participantStats'
        ));
    }

    public function attendanceReport(Request $request)
    {
        $query = Attendance::with('participant');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $query->whereBetween('date', [$startDate, $endDate]);
        } else {
            // Default to current month
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Filter by participant
        if ($request->has('participant_id')) {
            $query->where('participant_id', $request->participant_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $participants = Participant::orderBy('name')->get();

        return view('reports.attendance', compact('attendances', 'participants'));
    }

    public function participantReport(Request $request)
    {
        $query = Participant::withCount(['attendances as total_attendance'])
            ->withCount(['attendances as present_count' => function ($q) {
                $q->where('status', 'present');
            }])
            ->withCount(['attendances as late_count' => function ($q) {
                $q->where('status', 'late');
            }]);

        // Filter by program type
        if ($request->has('program_type') && $request->program_type !== 'all') {
            $query->where('program_type', $request->program_type);
        }

        // Filter by institution
        if ($request->has('institution')) {
            $query->where('institution', 'like', '%' . $request->institution . '%');
        }

        $participants = $query->orderBy('name')
            ->paginate(20);

        $institutions = Participant::select('institution')
            ->distinct()
            ->orderBy('institution')
            ->pluck('institution');

        return view('reports.participants', compact('participants', 'institutions'));
    }

    public function exportAttendance(Request $request)
    {
        $query = Attendance::with('participant');

        // Filter parameters
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'participant_id' => $request->participant_id,
            'status' => $request->status
        ];

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($request->has('participant_id')) {
            $query->where('participant_id', $request->participant_id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        // Statistics for the report
        $stats = [
            'total_records' => $attendances->count(),
            'present_count' => $attendances->where('status', 'present')->count(),
            'late_count' => $attendances->where('status', 'late')->count(),
            'date_range' => $request->has('start_date') ?
                Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($request->end_date)->format('d/m/Y') :
                'Semua Tanggal'
        ];

        $pdf = PDF::loadView('reports.pdf.attendance', [
            'attendances' => $attendances,
            'stats' => $stats,
            'filters' => $filters
        ]);

        $filename = 'laporan_absensi_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportParticipants(Request $request)
    {
        $query = Participant::withCount(['attendances as total_attendance'])
            ->withCount(['attendances as present_count' => function ($q) {
                $q->where('status', 'present');
            }])
            ->withCount(['attendances as late_count' => function ($q) {
                $q->where('status', 'late');
            }]);

        // Filter parameters
        $filters = [
            'program_type' => $request->program_type,
            'institution' => $request->institution
        ];

        if ($request->has('program_type') && $request->program_type !== 'all') {
            $query->where('program_type', $request->program_type);
        }

        if ($request->has('institution')) {
            $query->where('institution', 'like', '%' . $request->institution . '%');
        }

        $participants = $query->orderBy('name')->get();

        // Statistics for the report
        $stats = [
            'total_participants' => $participants->count(),
            'magang_count' => $participants->where('program_type', 'Magang')->count(),
            'pkl_count' => $participants->where('program_type', 'PKL')->count(),
            'total_attendance' => $participants->sum('total_attendance')
        ];

        $pdf = PDF::loadView('reports.pdf.participants', [
            'participants' => $participants,
            'stats' => $stats,
            'filters' => $filters
        ]);

        $filename = 'laporan_peserta_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();

        return [
            'total_participants' => Participant::count(),
            'total_attendance' => Attendance::count(),
            'today_attendance' => Attendance::whereDate('date', $today)->count(),
            'present_today' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'late_today' => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'magang_count' => Participant::where('program_type', 'Magang')->count(),
            'pkl_count' => Participant::where('program_type', 'PKL')->count(),
            'avg_daily_attendance' => $this->getAverageDailyAttendance(),
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
            'top_attenders' => Participant::withCount('attendances')
                ->orderBy('attendances_count', 'desc')
                ->limit(5)
                ->get()
        ];
    }

    private function getAverageDailyAttendance()
    {
        $totalDays = Attendance::select(DB::raw('COUNT(DISTINCT date) as days'))->first()->days;
        $totalAttendance = Attendance::count();

        return $totalDays > 0 ? round($totalAttendance / $totalDays, 1) : 0;
    }

    private function getStatusText($status)
    {
        return match ($status) {
            'present' => 'Tepat Waktu',
            'late' => 'Terlambat',
            'absent' => 'Absen',
            default => $status
        };
    }
}
