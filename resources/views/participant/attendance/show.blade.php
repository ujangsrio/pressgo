<!-- resources/views/participant/attendance/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Absensi - PressGO')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3">Detail Absensi</h1>
                        <p class="text-muted mb-0">Informasi lengkap absensi</p>
                    </div>
                    <div>
                        <a href="{{ route('participant.attendance.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Absensi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Tanggal</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Masuk</label>
                                <p class="mb-0">
                                    <span class="badge bg-info fs-6">{{ $attendance->check_in }}</span>
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Status</label>
                                <p class="mb-0">
                                    @if($attendance->status == 'present')
                                        <span class="badge bg-success fs-6">Tepat Waktu</span>
                                    @else
                                        <span class="badge bg-warning fs-6">Terlambat</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Keluar</label>
                                <p class="mb-0">
                                    @if($attendance->check_out)
                                        <span class="badge bg-secondary fs-6">{{ $attendance->check_out }}</span>
                                    @else
                                        <span class="badge bg-warning fs-6">Belum Check Out</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Durasi Kerja</label>
                                <p class="mb-0">
                                    @if($attendance->check_in && $attendance->check_out)
                                        @php
                                            $checkIn = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in);
                                            $checkOut = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out);
                                            $duration = $checkIn->diff($checkOut);
                                        @endphp
                                        <span class="badge bg-primary fs-6">
                                            {{ $duration->h }} jam {{ $duration->i }} menit
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark fs-6">-</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Catatan</label>
                                <p class="mb-0">
                                    {{ $attendance->notes ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Peserta -->
            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Peserta</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="{{ $attendance->participant->gambar_url }}" 
                                 alt="{{ $attendance->participant->name }}" 
                                 class="rounded-circle img-thumbnail" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <label class="fw-bold text-muted">Nama</label>
                                        <p class="mb-0">{{ $attendance->participant->name }}</p>
                                    </div>
                                    <div class="info-item mb-2">
                                        <label class="fw-bold text-muted">NIM</label>
                                        <p class="mb-0">{{ $attendance->participant->nim }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <label class="fw-bold text-muted">Program</label>
                                        <p class="mb-0">{{ $attendance->participant->program_type }}</p>
                                    </div>
                                    <div class="info-item mb-2">
                                        <label class="fw-bold text-muted">Institusi</label>
                                        <p class="mb-0">{{ $attendance->participant->institution }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection