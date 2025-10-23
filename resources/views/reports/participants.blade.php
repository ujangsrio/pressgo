@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-people me-2"></i>
                        Laporan Peserta
                    </h1>
                    <p class="text-muted mb-0">Data lengkap peserta magang dan PKL</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.export.participants', request()->query()) }}" class="btn btn-success">
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
            <form method="GET" action="{{ route('reports.participants') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="program_type" class="form-label">Jenis Program</label>
                        <select class="form-select" id="program_type" name="program_type">
                            <option value="all" {{ request('program_type') == 'all' ? 'selected' : '' }}>Semua Program</option>
                            <option value="Magang" {{ request('program_type') == 'Magang' ? 'selected' : '' }}>Magang</option>
                            <option value="PKL" {{ request('program_type') == 'PKL' ? 'selected' : '' }}>PKL</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="institution" class="form-label">Institusi</label>
                        <select class="form-select" id="institution" name="institution">
                            <option value="">Semua Institusi</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution }}" {{ request('institution') == $institution ? 'selected' : '' }}>
                                    {{ $institution }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter me-2"></i>Terapkan Filter
                            </button>
                            <a href="{{ route('reports.participants') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="card card-custom">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-check me-2"></i>
                Data Peserta
                @if(request()->hasAny(['program_type', 'institution']))
                    <small class="text-muted">(Data Difilter)</small>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Peserta</th>
                            <th>Email</th>
                            <th>NIM</th>
                            <th>Institusi</th>
                            <th>Program</th>
                            <th>Barcode ID</th>
                            <th>Total Absensi</th>
                            <th>Tepat Waktu</th>
                            <th>Terlambat</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ substr($participant->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $participant->name }}</h6>
                                        <small class="text-muted">{{ $participant->program_type }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->nim }}</td>
                            <td>{{ $participant->institution }}</td>
                            <td>
                                @if($participant->program_type === 'Magang')
                                    <span class="badge bg-primary">Magang</span>
                                @else
                                    <span class="badge bg-info">PKL</span>
                                @endif
                            </td>
                            <td>
                                <code class="bg-light p-1 rounded">{{ $participant->barcode_id }}</code>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $participant->total_attendance }}</span>
                            </td>
                            <td>
                                <span class="text-success fw-semibold">{{ $participant->present_count }}</span>
                            </td>
                            <td>
                                <span class="text-warning fw-semibold">{{ $participant->late_count }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $participant->created_at->format('d/m/Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-people display-4 d-block mb-3"></i>
                                    <h5>Tidak ada data peserta</h5>
                                    <p class="mb-0">Tidak ditemukan data peserta dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($participants->hasPages())
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $participants->firstItem() ?? 0 }} - {{ $participants->lastItem() ?? 0 }} dari {{ $participants->total() }} peserta
                </div>
                <nav>
                    {{ $participants->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection