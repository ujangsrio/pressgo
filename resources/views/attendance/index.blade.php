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
                        Data Absensi
                    </h1>
                    <p class="text-muted mb-0">Data absensi Mahasiswa Magang dan Siswa PKL</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $stats['total'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Absensi</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $stats['present'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Tepat Waktu</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $stats['late'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Terlambat</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $stats['participants'] ?? 0 }}</h2>
                            <p class="mb-0 opacity-75">Total Peserta</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <!-- Attendance Table -->
<div class="row">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bi bi-list-check me-2"></i>
                    Riwayat Absensi Terbaru
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">
                                    <i class="bi bi-person me-2"></i>
                                    Nama
                                </th>
                                <th>
                                    <i class="bi bi-id-card me-2"></i>
                                    NIM/NISN
                                </th>
                                <th>
                                    <i class="bi bi-calendar me-2"></i>
                                    Tanggal
                                </th>
                                <th>
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    Masuk
                                </th>
                                <th>
                                    <i class="bi bi-arrow-left-circle me-2"></i>
                                    Keluar
                                </th>
                                <th>
                                    <i class="bi bi-info-circle me-2"></i>
                                    Status
                                </th>
                                <th class="text-center">
                                    <i class="bi bi-activity me-2"></i>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
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
                                <td>
                                    <span class="fw-semibold">
                                        {{ $attendance->participant->nim ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-success">
                                        {{ $attendance->check_in ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-info">
                                        {{ $attendance->check_out ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($attendance->status === 'present')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Tepat Waktu
                                        </span>
                                    @elseif($attendance->status === 'late')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock-history me-1"></i>
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Absen
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('attendance.show', $attendance) }}" 
                                           class="btn btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('attendance.edit', $attendance) }}" 
                                           class="btn btn-outline-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Edit Absensi">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $attendance->id }}, '{{ ($attendance->participant->name ?? 'Peserta Tidak Ditemukan') . ' - ' . \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}')"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Absensi"
                                                {{ !$attendance->participant ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        <h5>Belum ada data absensi</h5>
                                        <p class="mb-0">Belum ada mahasiswa yang melakukan absensi.</p>
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
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon bg-danger rounded-circle me-3">
                        <i class="bi bi-exclamation-triangle text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">
                            Konfirmasi Hapus
                        </h5>
                        <p class="text-muted mb-0 small">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body py-4">
                <div class="text-center mb-3">
                    <i class="bi bi-trash display-4 text-danger mb-3"></i>
                    <h6 class="fw-bold">Anda akan menghapus data absensi:</h6>
                    <p class="mb-0" id="deleteAttendanceInfo"></p>
                </div>
                
                <div class="alert alert-warning border-warning">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle me-2 mt-1 text-warning"></i>
                        <div>
                            <small class="fw-semibold">Perhatian:</small>
                            <ul class="mb-0 ps-3 mt-1">
                                <li><small>Data yang dihapus tidak dapat dikembalikan</small></li>
                                <li><small>Riwayat absensi akan hilang permanen</small></li>
                                <li><small>Statistik peserta akan terpengaruh</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash me-2"></i>Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Delete confirmation
function confirmDelete(id, info) {
    document.getElementById('deleteAttendanceInfo').textContent = info;
    document.getElementById('deleteForm').action = `/attendance/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.1rem;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}

.modal-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-custom {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s;
}

.card-custom:hover {
    transform: translateY(-5px);
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
    transform: translateY(-1px);
    transition: all 0.2s;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin: 0 2px;
}
</style>
@endsection