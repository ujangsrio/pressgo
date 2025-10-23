@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-calendar-check me-2"></i>
                        Laporan Absensi
                    </h1>
                    <p class="text-muted mb-0">Data lengkap riwayat absensi peserta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.export.attendance', request()->query()) }}" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>
                        Export CSV
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filter Data
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.attendance') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="participant_id" class="form-label">Peserta</label>
                        <select class="form-select" id="participant_id" name="participant_id">
                            <option value="">Semua Peserta</option>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}" {{ request('participant_id') == $participant->id ? 'selected' : '' }}>
                                    {{ $participant->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Tepat Waktu</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-filter me-2"></i>Terapkan Filter
                            </button>
                            <a href="{{ route('reports.attendance') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card card-custom">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-check me-2"></i>
                Data Absensi
                @if(request()->hasAny(['start_date', 'end_date', 'participant_id', 'status']))
                    <small class="text-muted">(Data Difilter)</small>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Institusi</th>
                            <th>Program</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td class="ps-4 fw-semibold">
                                {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ substr($attendance->participant->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $attendance->participant->name }}</h6>
                                        <small class="text-muted">{{ $attendance->participant->program_type }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $attendance->participant->nim }}</td>
                            <td>{{ $attendance->participant->institution }}</td>
                            <td>
                                @if($attendance->participant->program_type === 'Magang')
                                    <span class="badge bg-primary">Magang</span>
                                @else
                                    <span class="badge bg-info">PKL</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-success">{{ $attendance->check_in }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-info">{{ $attendance->check_out ?? '-' }}</span>
                            </td>
                            <td>
                                @if($attendance->status === 'present')
                                    <span class="badge bg-success">Tepat Waktu</span>
                                @else
                                    <span class="badge bg-warning text-dark">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $attendance->notes ?? '-' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                                    <h5>Tidak ada data absensi</h5>
                                    <p class="mb-0">Tidak ditemukan data absensi dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($attendances->hasPages())
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $attendances->firstItem() ?? 0 }} - {{ $attendances->lastItem() ?? 0 }} dari {{ $attendances->total() }} data
                </div>
                <nav>
                    {{ $attendances->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection