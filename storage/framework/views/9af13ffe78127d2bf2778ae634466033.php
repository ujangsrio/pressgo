<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Data Absensi
                    </h1>
                    <p class="text-muted mb-0">Perbarui data absensi peserta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('attendance.show', $attendance)); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>
                        Lihat Detail
                    </a>
                    <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check me-2"></i>
                        Form Edit Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('attendance.update', $attendance)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="participant_id" class="form-label fw-semibold">Peserta <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['participant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="participant_id" 
                                        name="participant_id"
                                        required>
                                    <option value="">Pilih Peserta</option>
                                    <?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($participant->id); ?>" 
                                            <?php echo e(old('participant_id', $attendance->participant_id) == $participant->id ? 'selected' : ''); ?>>
                                            <?php echo e($participant->name); ?> (<?php echo e($participant->nim); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['participant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="date" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="date" 
                                       name="date" 
                                       value="<?php echo e(old('date', $attendance->date)); ?>"
                                       required>
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="check_in" class="form-label fw-semibold">Masuk <span class="text-danger">*</span></label>
                                <input type="time" 
                                       class="form-control <?php $__errorArgs = ['check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="check_in" 
                                       name="check_in" 
                                       value="<?php echo e(old('check_in', $attendance->check_in)); ?>"
                                       required>
                                <?php $__errorArgs = ['check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">
                                    <small>Check in setelah jam 08:00 akan otomatis status Terlambat</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="check_out" class="form-label fw-semibold">Keluar</label>
                                <input type="time" 
                                       class="form-control <?php $__errorArgs = ['check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="check_out" 
                                       name="check_out" 
                                       value="<?php echo e(old('check_out', $attendance->check_out)); ?>">
                                <?php $__errorArgs = ['check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="status" 
                                        name="status"
                                        required>
                                    <option value="present" <?php echo e(old('status', $attendance->status) == 'present' ? 'selected' : ''); ?>>Tepat Waktu</option>
                                    <option value="late" <?php echo e(old('status', $attendance->status) == 'late' ? 'selected' : ''); ?>>Terlambat</option>
                                    <option value="absent" <?php echo e(old('status', $attendance->status) == 'absent' ? 'selected' : ''); ?>>Absen</option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3" 
                                          placeholder="Masukkan catatan tambahan..."><?php echo e(old('notes', $attendance->notes)); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Current Data Info -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Data Saat Ini
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small><strong>Peserta:</strong> <?php echo e($attendance->participant->name); ?></small><br>
                                            <small><strong>Tanggal:</strong> <?php echo e(\Carbon\Carbon::parse($attendance->date)->format('d/m/Y')); ?></small>
                                        </div>
                                        <div class="col-md-6">
                                            <small><strong>Masuk:</strong> <?php echo e($attendance->check_in); ?></small><br>
                                            <small><strong>Keluar:</strong> <?php echo e($attendance->check_out ?? '-'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>
                                            Update Data
                                        </button>
                                        <a href="<?php echo e(route('attendance.show', $attendance)); ?>" class="btn btn-secondary">
                                            <i class="bi bi-x-circle me-2"></i>
                                            Batal
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash me-2"></i>
                                            Hapus Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                        Data yang sudah dihapus tidak dapat dikembalikan. Tindakan ini akan menghapus permanen data absensi.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?php echo e(route('attendance.destroy', $attendance)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto update status based on check_in time
    const checkInInput = document.getElementById('check_in');
    const statusSelect = document.getElementById('status');
    
    checkInInput.addEventListener('change', function() {
        const checkInTime = this.value;
        if (checkInTime) {
            const [hours, minutes] = checkInTime.split(':');
            if (parseInt(hours) > 8 || (parseInt(hours) === 8 && parseInt(minutes) > 0)) {
                statusSelect.value = 'late';
            } else {
                statusSelect.value = 'present';
            }
        }
    });

    // Validate check_out time
    const checkOutInput = document.getElementById('check_out');
    
    checkOutInput.addEventListener('change', function() {
        const checkInTime = checkInInput.value;
        const checkOutTime = this.value;
        
        if (checkInTime && checkOutTime) {
            if (checkOutTime <= checkInTime) {
                alert('Check out time harus setelah check in time');
                this.value = '';
                this.focus();
            }
        }
    });
});
</script>

<style>
.form-text small {
    font-size: 0.8rem;
}

.alert {
    border-radius: 0.75rem;
}

.btn {
    border-radius: 0.5rem;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\attendance\edit.blade.php ENDPATH**/ ?>