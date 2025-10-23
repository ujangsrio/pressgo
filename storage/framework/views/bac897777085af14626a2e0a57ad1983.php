<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-person-plus me-2"></i>
                        Tambah Peserta Baru
                    </h1>
                    <p class="text-muted mb-0">Tambahkan data mahasiswa magang atau PKL baru</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('participants.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card card-custom">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-badge me-2"></i>
                        Form Data Peserta
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Terdapat kesalahan dalam pengisian form:
                            </h6>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('participants.store')); ?>" method="POST" enctype="multipart/form-data" id="participantForm">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
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
                                       value="<?php echo e(old('name')); ?>" 
                                       placeholder="Masukkan nama lengkap"
                                       required
                                       maxlength="255"
                                       oninput="generateUsernamePreview()">
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

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
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
                                       value="<?php echo e(old('email')); ?>" 
                                       placeholder="email@example.com"
                                       required
                                       maxlength="255">
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

                            <!-- NIM / NISN -->
                            <div class="col-md-6">
                                <label for="nim" class="form-label fw-semibold">
                                    NIM / NISN <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="nim" 
                                       name="nim" 
                                       value="<?php echo e(old('nim')); ?>" 
                                       placeholder="Masukkan NIM atau ID"
                                       required
                                       maxlength="50">
                                <?php $__errorArgs = ['nim'];
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

                            <!-- Institusi -->
                            <div class="col-md-6">
                                <label for="institution" class="form-label fw-semibold">
                                    Institusi <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['institution'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="institution" 
                                       name="institution" 
                                       value="<?php echo e(old('institution')); ?>" 
                                       placeholder="Nama universitas/sekolah"
                                       required
                                       maxlength="255">
                                <?php $__errorArgs = ['institution'];
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

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">
                                    Tanggal Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir" 
                                       value="<?php echo e(old('tanggal_lahir')); ?>"
                                       required
                                       onchange="generateUsernamePreview()">
                                <?php $__errorArgs = ['tanggal_lahir'];
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

                            <!-- Tanggal Bergabung -->
                            <div class="col-md-6">
                                <label for="tanggal_bergabung" class="form-label fw-semibold">
                                    Tanggal Bergabung <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['tanggal_bergabung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="tanggal_bergabung" 
                                       name="tanggal_bergabung" 
                                       value="<?php echo e(old('tanggal_bergabung', date('Y-m-d'))); ?>"
                                       required>
                                <?php $__errorArgs = ['tanggal_bergabung'];
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

                            <!-- Username Preview -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading mb-2">
                                        <i class="bi bi-key me-2"></i>
                                        Username Otomatis
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span id="usernamePreview" class="fw-bold text-dark">-</span>
                                            <small class="text-muted d-block mt-1">
                                                Format: 2 huruf pertama nama + DDMMYYYY tanggal lahir
                                            </small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-dark" onclick="copyUsername()">
                                            <i class="bi bi-clipboard me-1"></i>Salin
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Program -->
                            <div class="col-md-6">
                                <label for="program_type" class="form-label fw-semibold">
                                    Jenis Program <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['program_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="program_type" 
                                        name="program_type"
                                        required>
                                    <option value="">Pilih Jenis Program</option>
                                    <option value="Magang" <?php echo e(old('program_type') == 'Magang' ? 'selected' : ''); ?>>Magang</option>
                                    <option value="PKL" <?php echo e(old('program_type') == 'PKL' ? 'selected' : ''); ?>>PKL</option>
                                </select>
                                <?php $__errorArgs = ['program_type'];
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

                            <!-- Foto Peserta -->
                            <div class="col-md-6">
                                <label for="gambar" class="form-label fw-semibold">
                                    Foto Peserta <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="gambar" 
                                       name="gambar"
                                       accept="image/jpg,image/png,image/jpeg"
                                       required
                                       onchange="previewImage(this)">
                                <div class="form-text">
                                    Format: JPG, PNG, JPEG (Maksimal 2MB). Ukuran disarankan: 300x300px
                                </div>
                                <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-2 text-center" style="display: none;">
                                    <img id="preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">
                                            <i class="bi bi-trash me-1"></i>Hapus Preview
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Barcode -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Barcode & QR Code
                                    </h6>
                                    <p class="mb-0">
                                        Barcode ID dan Username akan otomatis digenerate oleh sistem setelah data disimpan.
                                        Keduanya akan digunakan untuk proses absensi dan identifikasi peserta.
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Reset Form
                                    </button>
                                    <a href="<?php echo e(route('participants.index')); ?>" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="bi bi-save me-2"></i>
                                        Simpan Peserta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Generate username preview
function generateUsernamePreview() {
    const name = document.getElementById('name').value;
    const tanggalLahir = document.getElementById('tanggal_lahir').value;
    const usernamePreview = document.getElementById('usernamePreview');
    
    if (name && tanggalLahir) {
        // Ambil 2 huruf pertama dari nama (uppercase, hanya huruf)
        const namaPart = name.replace(/[^a-zA-Z]/g, '').substring(0, 2).toUpperCase();
        
        // Format tanggal: DDMMYYYY
        const date = new Date(tanggalLahir);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const tanggalPart = day + month + year;
        
        const username = namaPart + tanggalPart;
        usernamePreview.textContent = username;
    } else {
        usernamePreview.textContent = '-';
    }
}

// Copy username to clipboard
function copyUsername() {
    const username = document.getElementById('usernamePreview').textContent;
    if (username !== '-') {
        navigator.clipboard.writeText(username).then(() => {
            showToast('success', 'Username berhasil disalin!');
        });
    }
}

// Preview image sebelum upload
function previewImage(input) {
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Hapus preview image
function removeImage() {
    const input = document.getElementById('gambar');
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    input.value = '';
    preview.src = '';
    imagePreview.style.display = 'none';
}

// Reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mengosongkan semua field?')) {
        document.getElementById('participantForm').reset();
        removeImage();
        generateUsernamePreview();
    }
}

// Validasi form sebelum submit
document.getElementById('participantForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
});

// Toast notification
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Initialize username preview on page load
document.addEventListener('DOMContentLoaded', function() {
    generateUsernamePreview();
});
</script>

<style>
.card-custom {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.75rem;
}

.form-label {
    font-size: 0.9rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
    padding: 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.alert {
    border-radius: 0.5rem;
    border: none;
}

.btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

#usernamePreview {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    background: #fff3cd;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views/participants/create.blade.php ENDPATH**/ ?>