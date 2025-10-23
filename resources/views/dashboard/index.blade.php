@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard Sistem Absensi
                    </h1>
                    <p class="text-muted mb-0">Overview data absensi dan peserta secara real-time</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-dark me-3">
                        <i class="bi bi-clock me-1"></i>
                        <span id="currentTime">{{ now()->format('H:i:s') }}</span>
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.export.attendance') }}">
                                <i class="bi bi-file-pdf me-2 text-danger"></i>PDF Absensi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.export.participants') }}">
                                <i class="bi bi-file-pdf me-2 text-danger"></i>PDF Peserta
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-primary">{{ $stats['total_participants'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Peserta</p>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i>
                                {{ $stats['new_this_week'] ?? 0 }} baru minggu ini
                            </small>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="bi bi-people text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-success">{{ $stats['total_attendance'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Absensi</p>
                            <small class="text-muted">
                                Rata-rata: {{ $stats['avg_daily_attendance'] ?? 0 }}/hari
                            </small>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="bi bi-calendar-check text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-info">{{ $stats['today_attendance'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Absensi Hari Ini</p>
                            <small class="{{ $stats['attendance_trend'] >= 0 ? 'text-success' : 'text-danger' }}">
                                <i class="bi bi-arrow-{{ $stats['attendance_trend'] >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($stats['attendance_trend']) }}% dari kemarin
                            </small>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="bi bi-calendar-day text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-warning">{{ $stats['avg_daily_attendance'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Rata-rata Harian</p>
                            <small class="text-muted">
                                Berdasarkan {{ $stats['total_days'] ?? 0 }} hari
                            </small>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="bi bi-graph-up-arrow text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Summary -->
        <div class="col-lg-4 mb-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-day me-2 text-primary"></i>
                        Ringkasan Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                                <h4 class="fw-bold text-success mb-1">{{ $stats['present_today'] ?? 0 }}</h4>
                                <small class="text-muted">Tepat Waktu</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning border-opacity-25">
                                <h4 class="fw-bold text-warning mb-1">{{ $stats['late_today'] ?? 0 }}</h4>
                                <small class="text-muted">Terlambat</small>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['magang_count'] ?? 0 }}</h4>
                                <small class="text-muted">Magang</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-info bg-opacity-10 rounded-3 border border-info border-opacity-25">
                                <h4 class="fw-bold text-info mb-1">{{ $stats['pkl_count'] ?? 0 }}</h4>
                                <small class="text-muted">PKL</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2 text-success"></i>
                        Distribusi Program
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <canvas id="programChart" width="200" height="200"></canvas>
                    </div>
                    <div class="mt-3">
                        @php
                            $magangCount = $participantStats['by_program']['Magang'] ?? 0;
                            $pklCount = $participantStats['by_program']['PKL'] ?? 0;
                            $total = $magangCount + $pklCount;
                            $magangPercent = $total > 0 ? round(($magangCount / $total) * 100, 1) : 0;
                            $pklPercent = $total > 0 ? round(($pklCount / $total) * 100, 1) : 0;
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-light">
                            <span class="badge bg-primary">Magang</span>
                            <span class="fw-semibold">{{ $magangCount }} ({{ $magangPercent }}%)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded bg-light">
                            <span class="badge bg-info">PKL</span>
                            <span class="fw-semibold">{{ $pklCount }} ({{ $pklPercent }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Attenders -->
        <div class="col-lg-4 mb-4">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trophy me-2 text-warning"></i>
                        Top 5 Peserta Aktif
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($participantStats['top_attenders'] ?? [] as $index => $participant)
                    <div class="d-flex align-items-center mb-3 p-2 rounded bg-light">
                        <div class="rank-badge me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold">{{ $participant->name }}</h6>
                            <small class="text-muted">{{ $participant->attendances_count ?? 0 }} absensi</small>
                        </div>
                        <span class="badge bg-success">{{ $participant->program_type ?? 'N/A' }}</span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-info-circle display-6 d-block mb-2"></i>
                        <p>Belum ada data absensi</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Attendance -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2 text-info"></i>
                        Absensi Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama</th>
                                    <th>Tanggal</th>
                                    <th>Check In</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAttendances as $attendance)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ $attendance->participant ? substr($attendance->participant->name, 0, 1) : '?' }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">
                                                    {{ $attendance->participant->name ?? 'Peserta Tidak Ditemukan' }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $attendance->participant->program_type ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                                    <td>{{ $attendance->check_in ?? '-' }}</td>
                                    <td>
                                        @if($attendance->status === 'present')
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @elseif($attendance->status === 'late')
                                            <span class="badge bg-warning text-dark">Terlambat</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $attendance->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Tidak ada data absensi terbaru
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('reports.attendance') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua Absensi
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2 text-success"></i>
                        Statistik Bulanan ({{ date('Y') }})
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning me-2 text-warning"></i>
                        Akses Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('reports.attendance') }}" class="card card-custom text-decoration-none h-100 border-0 shadow-sm-hover">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-check display-4 text-primary mb-3"></i>
                                    <h6>Laporan Absensi</h6>
                                    <small class="text-muted">Lihat detail data absensi</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('reports.participants') }}" class="card card-custom text-decoration-none h-100 border-0 shadow-sm-hover">
                                <div class="card-body text-center">
                                    <i class="bi bi-people display-4 text-success mb-3"></i>
                                    <h6>Laporan Peserta</h6>
                                    <small class="text-muted">Data lengkap peserta</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('participants.index') }}" class="card card-custom text-decoration-none h-100 border-0 shadow-sm-hover">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus display-4 text-warning mb-3"></i>
                                    <h6>Kelola Peserta</h6>
                                    <small class="text-muted">Tambah/edit data peserta</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('attendance.scan') }}" class="card card-custom text-decoration-none h-100 border-0 shadow-sm-hover">
                                <div class="card-body text-center">
                                    <i class="bi bi-qr-code-scan display-4 text-info mb-3"></i>
                                    <h6>Scan QR Code</h6>
                                    <small class="text-muted">Absensi peserta</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.stat-card {
    transition: transform 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-2px);
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
}
.rank-badge {
    width: 32px;
    height: 32px;
    font-size: 0.8rem;
    font-weight: bold;
}
.shadow-sm-hover:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Update current time every second
function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    });
    document.getElementById('currentTime').textContent = timeString;
}
setInterval(updateCurrentTime, 1000);

// Program Distribution Chart
const programCtx = document.getElementById('programChart').getContext('2d');
const programChart = new Chart(programCtx, {
    type: 'doughnut',
    data: {
        labels: ['Magang', 'PKL'],
        datasets: [{
            data: [{{ $participantStats['by_program']['Magang'] ?? 0 }}, {{ $participantStats['by_program']['PKL'] ?? 0 }}],
            backgroundColor: ['#007bff', '#17a2b8'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Monthly Attendance Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Tepat Waktu',
                data: [
                    {{ $monthlyData[1]['present'] ?? 0 }},
                    {{ $monthlyData[2]['present'] ?? 0 }},
                    {{ $monthlyData[3]['present'] ?? 0 }},
                    {{ $monthlyData[4]['present'] ?? 0 }},
                    {{ $monthlyData[5]['present'] ?? 0 }},
                    {{ $monthlyData[6]['present'] ?? 0 }},
                    {{ $monthlyData[7]['present'] ?? 0 }},
                    {{ $monthlyData[8]['present'] ?? 0 }},
                    {{ $monthlyData[9]['present'] ?? 0 }},
                    {{ $monthlyData[10]['present'] ?? 0 }},
                    {{ $monthlyData[11]['present'] ?? 0 }},
                    {{ $monthlyData[12]['present'] ?? 0 }}
                ],
                backgroundColor: '#28a745'
            },
            {
                label: 'Terlambat',
                data: [
                    {{ $monthlyData[1]['late'] ?? 0 }},
                    {{ $monthlyData[2]['late'] ?? 0 }},
                    {{ $monthlyData[3]['late'] ?? 0 }},
                    {{ $monthlyData[4]['late'] ?? 0 }},
                    {{ $monthlyData[5]['late'] ?? 0 }},
                    {{ $monthlyData[6]['late'] ?? 0 }},
                    {{ $monthlyData[7]['late'] ?? 0 }},
                    {{ $monthlyData[8]['late'] ?? 0 }},
                    {{ $monthlyData[9]['late'] ?? 0 }},
                    {{ $monthlyData[10]['late'] ?? 0 }},
                    {{ $monthlyData[11]['late'] ?? 0 }},
                    {{ $monthlyData[12]['late'] ?? 0 }}
                ],
                backgroundColor: '#ffc107'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: false
            },
            y: {
                stacked: false,
                beginAtZero: true
            }
        }
    }
});

// Auto-refresh dashboard data every 30 seconds
setInterval(function() {
    fetch('/dashboard/data')
        .then(response => response.json())
        .then(data => {
            // Update statistics cards
            document.querySelector('[data-stat="total_participants"]').textContent = data.stats.total_participants;
            document.querySelector('[data-stat="total_attendance"]').textContent = data.stats.total_attendance;
            document.querySelector('[data-stat="today_attendance"]').textContent = data.stats.today_attendance;
            // You can update more elements as needed
        })
        .catch(error => console.error('Error refreshing dashboard:', error));
}, 30000);
</script>
@endsection