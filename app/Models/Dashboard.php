<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Model
{
    public $timestamps = false;

    public static function getWeeklyAttendance()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        return Attendance::select(
            DB::raw('DAYNAME(date) as day'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy(DB::raw('DAYNAME(date)'), DB::raw('DATE(date)'))
            ->orderBy(DB::raw('DATE(date)'))
            ->get();
    }

    public static function getAttendanceByHour()
    {
        return Attendance::select(
            DB::raw('HOUR(check_in) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->whereNotNull('check_in')
            ->groupBy(DB::raw('HOUR(check_in)'))
            ->orderBy('hour')
            ->get();
    }

    public static function getInstitutionStats()
    {
        return Participant::select(
            'institution',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN program_type = "Magang" THEN 1 ELSE 0 END) as magang'),
            DB::raw('SUM(CASE WHEN program_type = "PKL" THEN 1 ELSE 0 END) as pkl')
        )
            ->groupBy('institution')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();
    }
}
