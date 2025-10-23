<?php $__env->startSection('content'); ?>
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
                    <a href="<?php echo e(route('reports.export.attendance', request()->query())); ?>" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>
                        Export CSV
                    </a>
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-outline-secondary">
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
            <form method="GET" action="<?php echo e(route('reports.attendance')); ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="<?php echo e(request('start_date')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="<?php echo e(request('end_date')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="participant_id" class="form-label">Peserta</label>
                        <select class="form-select" id="participant_id" name="participant_id">
                            <option value="">Semua Peserta</option>
                            <?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($participant->id); ?>" <?php echo e(request('participant_id') == $participant->id ? 'selected' : ''); ?>>
                                    <?php echo e($participant->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all" <?php echo e(request('status') == 'all' ? 'selected' : ''); ?>>Semua Status</option>
                            <option value="present" <?php echo e(request('status') == 'present' ? 'selected' : ''); ?>>Tepat Waktu</option>
                            <option value="late" <?php echo e(request('status') == 'late' ? 'selected' : ''); ?>>Terlambat</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-filter me-2"></i>Terapkan Filter
                            </button>
                            <a href="<?php echo e(route('reports.attendance')); ?>" class="btn btn-secondary">
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
                <?php if(request()->hasAny(['start_date', 'end_date', 'participant_id', 'status'])): ?>
                    <small class="text-muted">(Data Difilter)</small>
                <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-semibold">
                                <?php echo e(\Carbon\Carbon::parse($attendance->date)->format('d/m/Y')); ?>

                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo e(substr($attendance->participant->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?php echo e($attendance->participant->name); ?></h6>
                                        <small class="text-muted"><?php echo e($attendance->participant->program_type); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($attendance->participant->nim); ?></td>
                            <td><?php echo e($attendance->participant->institution); ?></td>
                            <td>
                                <?php if($attendance->participant->program_type === 'Magang'): ?>
                                    <span class="badge bg-primary">Magang</span>
                                <?php else: ?>
                                    <span class="badge bg-info">PKL</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-semibold text-success"><?php echo e($attendance->check_in); ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold text-info"><?php echo e($attendance->check_out ?? '-'); ?></span>
                            </td>
                            <td>
                                <?php if($attendance->status === 'present'): ?>
                                    <span class="badge bg-success">Tepat Waktu</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Terlambat</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($attendance->notes ?? '-'); ?></small>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                                    <h5>Tidak ada data absensi</h5>
                                    <p class="mb-0">Tidak ditemukan data absensi dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <?php if($attendances->hasPages()): ?>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan <?php echo e($attendances->firstItem() ?? 0); ?> - <?php echo e($attendances->lastItem() ?? 0); ?> dari <?php echo e($attendances->total()); ?> data
                </div>
                <nav>
                    <?php echo e($attendances->links()); ?>

                </nav>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\reports\attendance.blade.php ENDPATH**/ ?>