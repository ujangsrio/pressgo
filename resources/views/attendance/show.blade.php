@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-eye me-2"></i>
                        Detail Absensi
                    </h1>
                    <p class="text-muted mb-0">Detail lengkap data absensi peserta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>
                        Edit
                    </a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i>
                        Hapus
                    </button>
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Attendance Details Card -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Tanggal Absensi</label>
                                <div class="fs-5 fw-bold text-primary">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d F Y') }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Masuk</label>
                                <div class="fs-5 fw-bold text-success">
                                    {{ $attendance->check_in }}
                                    @if($attendance->status === 'late')
                                        <span class="badge bg-warning text-dark ms-2">Terlambat</span>
                                    @else
                                        <span class="badge bg-success ms-2">Tepat Waktu</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Keluar</label>
                                <div class="fs-5 fw-bold text-info">
                                    {{ $attendance->check_out ?? '-' }}
                                    @if($attendance->check_out)
                                        <span class="badge bg-info ms-2">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">Belum Keluar</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Status</label>
                                <div>
                                    @if($attendance->status === 'present')
                                        <span class="badge bg-success fs-6">Tepat Waktu</span>
                                    @elseif($attendance->status === 'late')
                                        <span class="badge bg-warning text-dark fs-6">Terlambat</span>
                                    @else
                                        <span class="badge bg-danger fs-6">Absen</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Durasi Kerja</label>
                                <div class="fs-5 fw-bold text-dark">
                                    @if($attendance->check_in && $attendance->check_out)
                                        @php
                                            $checkIn = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in);
                                            $checkOut = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out);
                                            $duration = $checkIn->diff($checkOut);
                                        @endphp
                                        {{ $duration->h }} jam {{ $duration->i }} menit
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Catatan</label>
                                <div class="p-3 bg-light rounded-3">
                                    @if($attendance->notes)
                                        {{ $attendance->notes }}
                                    @else
                                        <span class="text-muted">Tidak ada catatan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card card-custom">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Timeline Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $attendance->check_in ? 'completed' : '' }}">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="fw-semibold">Masuk</h6>
                                <p class="mb-1">{{ $attendance->check_in ?? 'Belum masuk' }}</p>
                                <small class="text-muted">
                                    @if($attendance->check_in)
                                        {{ \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->check_in)->format('d F Y H:i') }}
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $attendance->check_out ? 'completed' : '' }}">
                            <div class="timeline-marker {{ $attendance->check_out ? 'bg-info' : 'bg-secondary' }}"></div>
                            <div class="timeline-content">
                                <h6 class="fw-semibold">Keluar</h6>
                                <p class="mb-1">{{ $attendance->check_out ?? 'Belum keluar' }}</p>
                                <small class="text-muted">
                                    @if($attendance->check_out)
                                        {{ \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->check_out)->format('d F Y H:i') }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Participant Info Card -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person me-2"></i>
                        Informasi Peserta
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="user-avatar-lg mx-auto mb-3">
                            {{ substr($attendance->participant->name, 0, 1) }}
                        </div>
                        <h4 class="fw-bold">{{ $attendance->participant->name }}</h4>
                        <p class="text-muted mb-0">{{ $attendance->participant->program_type }}</p>
                    </div>

                    <div class="participant-info">
                        <div class="info-item mb-3">
                            <i class="bi bi-id-card me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">NIM / ID</small>
                                <div class="fw-semibold">{{ $attendance->participant->nim }}</div>
                            </div>
                        </div>

                        <div class="info-item mb-3">
                            <i class="bi bi-envelope me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <div class="fw-semibold">{{ $attendance->participant->email }}</div>
                            </div>
                        </div>

                        <div class="info-item mb-3">
                            <i class="bi bi-building me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Institusi</small>
                                <div class="fw-semibold">{{ $attendance->participant->institution }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-upc-scan me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Barcode ID</small>
                                <div class="fw-semibold">
                                    <code class="bg-light p-1 rounded">{{ $attendance->participant->barcode_id }}</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card card-custom">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        Statistik Peserta
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $totalAttendance = $attendance->participant->attendances()->count();
                        $presentCount = $attendance->participant->attendances()->where('status', 'present')->count();
                        $lateCount = $attendance->participant->attendances()->where('status', 'late')->count();
                        $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;
                    @endphp

                    <div class="stats-grid">
                        <div class="stat-item text-center">
                            <div class="stat-number text-primary">{{ $totalAttendance }}</div>
                            <small class="text-muted">Total Absensi</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-number text-success">{{ $presentCount }}</div>
                            <small class="text-muted">Tepat Waktu</small>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-number text-warning">{{ $lateCount }}</div>
                            <small class="text-muted">Terlambat</small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Rate Kehadiran</small>
                            <small class="fw-semibold">{{ $attendanceRate }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $attendanceRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data absensi ini?</p>
                <div class="alert alert-warning">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('attendance.destroy', $attendance) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Additional scripts if needed
</script>

<style>
.user-avatar-lg {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 2rem;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid white;
}

.timeline-content {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.timeline-item.completed .timeline-content {
    border-left-color: #28a745;
}

.participant-info .info-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.participant-info .info-item:last-child {
    border-bottom: none;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.stat-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.progress {
    border-radius: 10px;
}
</style>
@endsection