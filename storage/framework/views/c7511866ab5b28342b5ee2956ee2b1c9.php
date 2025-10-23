<!-- resources/views/participant/settings/index.blade.php -->


<?php $__env->startSection('title', 'Pengaturan Akun - PressGO'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3">Pengaturan Akun</h1>
                        <p class="text-muted">Kelola informasi akun dan pengaturan keamanan</p>
                    </div>
                    <a href="<?php echo e(route('participant.dashboard')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i>Profil
                        </a>
                        <a href="#password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i>Ubah Password
                        </a>
                        <a href="#photo" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-camera me-2"></i>Foto Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Tab Profil -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('participant.settings.update-profile')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" 
                                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="name" 
                                               name="name" 
                                               value="<?php echo e(old('name', $participant->name)); ?>" 
                                               required>
                                        <?php $__errorArgs = ['name'];
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
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="email" 
                                               name="email" 
                                               value="<?php echo e(old('email', $participant->email)); ?>" 
                                               required>
                                        <?php $__errorArgs = ['email'];
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
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="text" 
                                               class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="phone" 
                                               name="phone" 
                                               value="<?php echo e(old('phone', $participant->phone)); ?>">
                                        <?php $__errorArgs = ['phone'];
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
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIM/NISN</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="<?php echo e($participant->nim); ?>" 
                                               disabled>
                                        <small class="form-text text-muted">NIM tidak dapat diubah</small>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Program</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="<?php echo e($participant->program_type); ?>" 
                                               disabled>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Institusi</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="<?php echo e($participant->institution); ?>" 
                                               disabled>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small class="text-muted">Terakhir update: <?php echo e($participant->updated_at->format('d/m/Y H:i')); ?></small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Ubah Password -->
                <div class="tab-pane fade" id="password">
                    <div class="card shadow">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('participant.settings.update-password')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" 
                                           class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="current_password" 
                                           name="current_password" 
                                           required
                                           placeholder="Masukkan password saat ini">
                                    <?php $__errorArgs = ['current_password'];
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
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" 
                                           class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="new_password" 
                                           name="new_password" 
                                           required
                                           placeholder="Masukkan password baru (minimal 6 karakter)">
                                    <?php $__errorArgs = ['new_password'];
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
                                
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           required
                                           placeholder="Masukkan kembali password baru">
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Saat ini anda login menggunakan password NIM/NISN
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Foto Profil -->
                <div class="tab-pane fade" id="photo">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-camera me-2"></i>Foto Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="mb-4">
                                        <img src="<?php echo e($participant->gambar_url); ?>" 
                                             alt="<?php echo e($participant->name); ?>" 
                                             class="rounded-circle img-thumbnail" 
                                             style="width: 200px; height: 200px; object-fit: cover;">
                                        <div class="mt-3">
                                            <small class="text-muted">Foto Profil Saat Ini</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <form method="POST" action="<?php echo e(route('participant.settings.update-photo')); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Pilih Foto Baru</label>
                                            <input type="file" 
                                                   class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="photo" 
                                                   name="photo" 
                                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <?php $__errorArgs = ['photo'];
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
                                                Format yang didukung: JPG, PNG, GIF. Maksimal ukuran: 2MB.
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Perhatian:</strong> Foto akan ditampilkan di dashboard dan ID card.
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <small class="text-muted">Rekomendasi: foto persegi 1:1 untuk hasil terbaik</small>
                                            </div>
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-upload me-2"></i>Upload Foto
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image sebelum upload
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.img-thumbnail');
                    if (img) {
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Tab activation
    const url = new URL(window.location.href);
    const hash = url.hash;
    if (hash) {
        const tabTrigger = document.querySelector(`[href="${hash}"]`);
        if (tabTrigger) {
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.list-group-item {
    border: none;
    padding: 1rem 1.25rem;
    font-weight: 500;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.tab-pane {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.img-thumbnail {
    border: 3px solid #dee2e6;
    transition: border-color 0.3s ease;
}

.img-thumbnail:hover {
    border-color: #0d6efd;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views/participant/settings/index.blade.php ENDPATH**/ ?>