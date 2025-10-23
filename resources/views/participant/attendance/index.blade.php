<!-- resources/views/participant/attendance/index.blade.php -->
@extends('layouts.app')

@section('title', 'Riwayat Absensi - PressGO')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3">Riwayat Absensi</h1>
                        <p class="text-muted mb-0">Data kehadiran, {{ auth()->guard('participant')->user()->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('participant.attendance.scan') }}" class="btn btn-primary">
                            <i class="fas fa-qrcode"></i> Scan Absensi
                        </a>
                        <a href="{{ route('participant.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-chart-bar"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kehadiran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tepat Waktu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['present'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Terlambat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['late'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['this_month'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Absensi -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Absensi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Status</th>
                                    <th>Durasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $attendance->check_in }}</span>
                                    </td>
                                    <td>
                                        @if($attendance->check_out)
                                            <span class="badge bg-secondary">{{ $attendance->check_out }}</span>
                                        @else
                                            <span class="badge bg-warning">Belum Check Out</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @else
                                            <span class="badge bg-warning">Terlambat</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_in && $attendance->check_out)
                                            @php
                                                $checkIn = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in);
                                                $checkOut = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out);
                                                $duration = $checkIn->diff($checkOut);
                                            @endphp
                                            <span class="badge bg-primary">
                                                {{ $duration->h }}j {{ $duration->i }}m
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('participant.attendance.show', $attendance->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                            <p>Belum ada data absensi</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($attendances->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $attendances->firstItem() }} - {{ $attendances->lastItem() }} dari {{ $attendances->total() }} data
                        </div>
                        <div>
                            {{ $attendances->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary { border-left: 4px solid #4e73df; }
.border-left-success { border-left: 4px solid #1cc88a; }
.border-left-warning { border-left: 4px solid #f6c23e; }
.border-left-info { border-left: 4px solid #36b9cc; }
</style>
@endpush