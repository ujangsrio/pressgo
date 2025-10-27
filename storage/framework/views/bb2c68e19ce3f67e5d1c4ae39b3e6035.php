<!-- resources/views/participant/dashboard.blade.php -->


<?php $__env->startSection('title', 'Dashboard Peserta'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <h1 class="h3">Dashboard Peserta</h1>
                <p class="text-muted">Selamat datang, <?php echo e(auth()->guard('participant')->user()->name); ?>!</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->  
    

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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($stats['total_attendance']); ?>

                            </div>
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
                                Hadir Tepat Waktu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($stats['present_count']); ?>

                            </div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($stats['late_count']); ?>

                            </div>
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
                                Tingkat Kehadiran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($stats['attendance_rate']); ?>%
                            </div>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-info" role="progressbar" 
                                     style="width: <?php echo e($stats['attendance_rate']); ?>%" 
                                     aria-valuenow="<?php echo e($stats['attendance_rate']); ?>" 
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percent fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Riwayat Absensi Terbaru -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi Terbaru</h6>
                    <a href="<?php echo e(route('participant.attendance.index')); ?>" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Status</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(\Carbon\Carbon::parse($attendance->date)->format('d/m/Y')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($attendance->date)->translatedFormat('l')); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($attendance->check_in); ?></span>
                                    </td>
                                    <td>
                                        <?php if($attendance->check_out): ?>
                                            <span class="badge bg-secondary"><?php echo e($attendance->check_out); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Belum Check Out</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($attendance->status == 'present'): ?>
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Terlambat</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($attendance->check_in && $attendance->check_out): ?>
                                            <?php
                                                $checkIn = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in);
                                                $checkOut = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out);
                                                $duration = $checkIn->diff($checkOut);
                                            ?>
                                            <span class="badge bg-primary">
                                                <?php echo e($duration->h); ?>j <?php echo e($duration->i); ?>m
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                            <p>Belum ada data absensi</p>
                                            <a href="<?php echo e(route('participant.attendance.scan')); ?>" class="btn btn-primary btn-sm">
                                                Lakukan Absensi Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Statistik Bulanan -->
            <?php if(isset($monthlyData) && count($monthlyData) > 0): ?>
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <?php
                        $currentMonth = \Carbon\Carbon::now()->month;
                        $monthData = $monthlyData[$currentMonth] ?? null;
                    ?>
                    <?php if($monthData): ?>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h4 class="text-primary"><?php echo e($monthData['total']); ?></h4>
                                <small class="text-muted">Total Kehadiran</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h4 class="text-success"><?php echo e($monthData['present']); ?></h4>
                                <small class="text-muted">Tepat Waktu</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h4 class="text-warning"><?php echo e($monthData['late']); ?></h4>
                                <small class="text-muted">Terlambat</small>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="text-muted text-center">Belum ada data untuk bulan ini</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Informasi Peserta -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Peserta</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?php echo e(auth()->guard('participant')->user()->gambar_url); ?>" 
                             alt="<?php echo e(auth()->guard('participant')->user()->name); ?>" 
                             class="rounded-circle img-thumbnail" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="mt-2 mb-1"><?php echo e(auth()->guard('participant')->user()->name); ?></h5>
                        <p class="text-muted mb-2"><?php echo e(auth()->guard('participant')->user()->nim); ?></p>
                    </div>
                    
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Program</strong></td>
                            <td><?php echo e(auth()->guard('participant')->user()->program_type); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Institusi</strong></td>
                            <td><?php echo e(auth()->guard('participant')->user()->institution); ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Mulai</strong></td>
                            <td><?php echo e(auth()->guard('participant')->user()->tanggal_bergabung_formatted); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Selesai</strong></td>
                            <td>
                                <?php if(auth()->guard('participant')->user()->end_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse(auth()->guard('participant')->user()->end_date)->format('d/m/Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <?php if(auth()->guard('participant')->user()->is_active): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('participant.attendance.scan')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-qrcode"></i> Scan Absensi
                        </a>
                        <a href="<?php echo e(route('participant.attendance.index')); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-history"></i> Riwayat Absensi
                        </a>
                        <!-- Ganti dengan link yang menggunakan JavaScript untuk konsistensi -->
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status Hari Ini -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Hari Ini</h6>
                </div>
                <div class="card-body">
                    <?php
                        $todayAttendance = $recentAttendances->first(function ($attendance) {
                            return \Carbon\Carbon::parse($attendance->date)->isToday();
                        });
                    ?>
                    
                    <?php if($todayAttendance): ?>
                        <div class="text-center">
                            <?php if($todayAttendance->check_out): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h6>Absensi Selesai</h6>
                                    <p class="mb-1">Masuk: <?php echo e($todayAttendance->check_in); ?></p>
                                    <p class="mb-0">Keluar: <?php echo e($todayAttendance->check_out); ?></p>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h6>Sudah Masuk</h6>
                                    <p class="mb-1">Waktu: <?php echo e($todayAttendance->check_in); ?></p>
                                    <p class="mb-0">
                                        Status: 
                                        <?php if($todayAttendance->status == 'present'): ?>
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Terlambat</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <a href="<?php echo e(route('participant.attendance.scan')); ?>" class="btn btn-warning btn-sm w-100">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center">
                            <div class="alert alert-secondary">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <h6>Belum Absen</h6>
                                <p class="mb-0">Anda belum melakukan absensi hari ini</p>
                            </div>
                            <a href="<?php echo e(route('participant.attendance.scan')); ?>" class="btn btn-success btn-sm w-100">
                                <i class="fas fa-sign-in-alt"></i> Absen Sekarang
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Profil Saya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="<?php echo e(auth()->guard('participant')->user()->gambar_url); ?>" 
                         alt="<?php echo e(auth()->guard('participant')->user()->name); ?>" 
                         class="rounded-circle img-thumbnail" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->name); ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIM</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->nim); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->email); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Telepon</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->phone ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Program</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->program_type); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Institusi</strong></td>
                        <td><?php echo e(auth()->guard('participant')->user()->institution); ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Logout Form -->
<form id="participant-logout-form" action="<?php echo e(route('participant.logout')); ?>" method="POST" class="d-none">
    <?php echo csrf_field(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            const button = document.querySelector('.btn-outline-danger');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Logging out...';
            button.disabled = true;
            
            // Submit form after a short delay to show loading state
            setTimeout(() => {
                document.getElementById('participant-logout-form').submit();
            }, 500);
        }
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.border-left-primary { border-left: 4px solid #4e73df; }
.border-left-success { border-left: 4px solid #1cc88a; }
.border-left-warning { border-left: 4px solid #f6c23e; }
.border-left-info { border-left: 4px solid #36b9cc; }
.progress { height: 8px; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\PressGO\resources\views/participant/dashboard.blade.php ENDPATH**/ ?>