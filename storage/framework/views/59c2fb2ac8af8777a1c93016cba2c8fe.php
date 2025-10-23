<?php $__env->startSection('content'); ?>
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
                    <a href="<?php echo e(route('reports.export.participants', request()->query())); ?>" class="btn btn-success">
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
            <form method="GET" action="<?php echo e(route('reports.participants')); ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="program_type" class="form-label">Jenis Program</label>
                        <select class="form-select" id="program_type" name="program_type">
                            <option value="all" <?php echo e(request('program_type') == 'all' ? 'selected' : ''); ?>>Semua Program</option>
                            <option value="Magang" <?php echo e(request('program_type') == 'Magang' ? 'selected' : ''); ?>>Magang</option>
                            <option value="PKL" <?php echo e(request('program_type') == 'PKL' ? 'selected' : ''); ?>>PKL</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="institution" class="form-label">Institusi</label>
                        <select class="form-select" id="institution" name="institution">
                            <option value="">Semua Institusi</option>
                            <?php $__currentLoopData = $institutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($institution); ?>" <?php echo e(request('institution') == $institution ? 'selected' : ''); ?>>
                                    <?php echo e($institution); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter me-2"></i>Terapkan Filter
                            </button>
                            <a href="<?php echo e(route('reports.participants')); ?>" class="btn btn-secondary">
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
                <?php if(request()->hasAny(['program_type', 'institution'])): ?>
                    <small class="text-muted">(Data Difilter)</small>
                <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo e(substr($participant->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?php echo e($participant->name); ?></h6>
                                        <small class="text-muted"><?php echo e($participant->program_type); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($participant->email); ?></td>
                            <td><?php echo e($participant->nim); ?></td>
                            <td><?php echo e($participant->institution); ?></td>
                            <td>
                                <?php if($participant->program_type === 'Magang'): ?>
                                    <span class="badge bg-primary">Magang</span>
                                <?php else: ?>
                                    <span class="badge bg-info">PKL</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <code class="bg-light p-1 rounded"><?php echo e($participant->barcode_id); ?></code>
                            </td>
                            <td>
                                <span class="fw-semibold"><?php echo e($participant->total_attendance); ?></span>
                            </td>
                            <td>
                                <span class="text-success fw-semibold"><?php echo e($participant->present_count); ?></span>
                            </td>
                            <td>
                                <span class="text-warning fw-semibold"><?php echo e($participant->late_count); ?></span>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($participant->created_at->format('d/m/Y')); ?></small>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-people display-4 d-block mb-3"></i>
                                    <h5>Tidak ada data peserta</h5>
                                    <p class="mb-0">Tidak ditemukan data peserta dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <?php if($participants->hasPages()): ?>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan <?php echo e($participants->firstItem() ?? 0); ?> - <?php echo e($participants->lastItem() ?? 0); ?> dari <?php echo e($participants->total()); ?> peserta
                </div>
                <nav>
                    <?php echo e($participants->links()); ?>

                </nav>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\reports\participants.blade.php ENDPATH**/ ?>