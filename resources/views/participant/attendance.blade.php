<!-- resources/views/participant/attendance/scan.blade.php -->
@extends('layouts.app')

@section('title', 'Scan Absensi - PressGO')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3">Scan Absensi</h1>
                        <p class="text-muted mb-0">Gunakan tombol di bawah untuk check in/check out</p>
                    </div>
                    <a href="{{ route('participant.attendance.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history"></i> Riwayat Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Card Scan -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="fas fa-qrcode fa-3x mb-3"></i>
                    <h4 class="mb-0">ABSENSI DIGITAL</h4>
                    <p class="mb-0 opacity-75">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="card-body text-center p-5">
                    <!-- Informasi Peserta -->
                    <div class="participant-info mb-4">
                        <img src="{{ auth()->guard('participant')->user()->gambar_url }}" 
                             alt="{{ auth()->guard('participant')->user()->name }}" 
                             class="rounded-circle img-thumbnail mb-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="mb-1">{{ auth()->guard('participant')->user()->name }}</h5>
                        <p class="text-muted mb-2">{{ auth()->guard('participant')->user()->nim }}</p>
                        <span class="badge bg-info">{{ auth()->guard('participant')->user()->program_type }}</span>
                    </div>

                    <!-- Status Hari Ini -->
                    @php
                        $todayAttendance = \App\Models\Attendance::where('participant_id', auth()->guard('participant')->id())
                            ->whereDate('date', \Carbon\Carbon::today())
                            ->first();
                    @endphp
                    
                    <div class="attendance-status mb-4">
                        @if($todayAttendance)
                            @if($todayAttendance->check_out)
                                <div class="alert alert-warning">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Absensi hari ini selesai</strong><br>
                                    <small>Check In: {{ $todayAttendance->check_in }} | Check Out: {{ $todayAttendance->check_out }}</small>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-clock"></i>
                                    <strong>Sudah Check In</strong><br>
                                    <small>Waktu: {{ $todayAttendance->check_in }} | Status: 
                                        @if($todayAttendance->status == 'present')
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @else
                                            <span class="badge bg-warning">Terlambat</span>
                                        @endif
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-secondary">
                                <i class="fas fa-info-circle"></i>
                                <strong>Belum ada absensi hari ini</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Absensi -->
                    <div class="attendance-buttons">
                        @if(!$todayAttendance)
                            <button type="button" class="btn btn-success btn-lg w-100 mb-3" onclick="processAttendance()">
                                <i class="fas fa-sign-in-alt"></i> CHECK IN
                            </button>
                        @elseif(!$todayAttendance->check_out)
                            <button type="button" class="btn btn-warning btn-lg w-100 mb-3" onclick="processAttendance()">
                                <i class="fas fa-sign-out-alt"></i> CHECK OUT
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                                <i class="fas fa-check"></i> ABSENSI SELESAI
                            </button>
                        @endif
                    </div>

                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="d-none text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memproses absensi...</p>
                    </div>

                    <!-- Result Message -->
                    <div id="resultMessage" class="alert d-none mt-3"></div>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>Sistem akan mencatat waktu secara otomatis</small>
                </div>
            </div>

            <!-- Statistik Cepat -->
            <div class="row mt-4">
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body py-3">
                            <h5 class="mb-0 text-primary">{{ \App\Models\Attendance::where('participant_id', auth()->guard('participant')->id())->count() }}</h5>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body py-3">
                            <h5 class="mb-0 text-success">{{ \App\Models\Attendance::where('participant_id', auth()->guard('participant')->id())->where('status', 'present')->count() }}</h5>
                            <small class="text-muted">Tepat Waktu</small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-body py-3">
                            <h5 class="mb-0 text-warning">{{ \App\Models\Attendance::where('participant_id', auth()->guard('participant')->id())->where('status', 'late')->count() }}</h5>
                            <small class="text-muted">Terlambat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function processAttendance() {
    const button = event.target;
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultMessage = document.getElementById('resultMessage');
    
    // Show loading
    button.disabled = true;
    loadingSpinner.classList.remove('d-none');
    resultMessage.classList.add('d-none');

    // Send request
    fetch('{{ route("participant.attendance.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading
        loadingSpinner.classList.add('d-none');
        
        if (data.success) {
            resultMessage.classList.remove('d-none', 'alert-danger');
            resultMessage.classList.add('alert-success');
            resultMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <strong>${data.message}</strong><br>
                <small>Waktu: ${data.time} | Status: ${data.type === 'check_in' ? (data.status === 'present' ? 'Tepat Waktu' : 'Terlambat') : 'Check Out'}</small>
            `;
            
            // Reload page after 2 seconds to update status
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            resultMessage.classList.remove('d-none', 'alert-success');
            resultMessage.classList.add('alert-danger');
            resultMessage.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <strong>${data.message}</strong>
            `;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loadingSpinner.classList.add('d-none');
        resultMessage.classList.remove('d-none', 'alert-success');
        resultMessage.classList.add('alert-danger');
        resultMessage.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <strong>Terjadi kesalahan. Silakan coba lagi.</strong>
        `;
        button.disabled = false;
    });
}
</script>
@endpush