

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-person-gear me-2"></i>
                        Edit Data Peserta
                    </h1>
                    <p class="text-muted mb-0">Edit data peserta <?php echo e($participant->name); ?></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('participants.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
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
                        Form Edit Data Peserta
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

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

                    <form action="<?php echo e(route('participants.update', $participant->id)); ?>" method="POST" enctype="multipart/form-data" id="participantForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
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
                                       value="<?php echo e(old('name', $participant->name)); ?>" 
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
                                       value="<?php echo e(old('email', $participant->email)); ?>" 
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

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Nomor Telepon
                                </label>
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
                                       value="<?php echo e(old('phone', $participant->phone)); ?>" 
                                       placeholder="08123456789"
                                       maxlength="20">
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
                                       value="<?php echo e(old('nim', $participant->nim)); ?>" 
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
                                       value="<?php echo e(old('institution', $participant->institution)); ?>" 
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
                                    Tanggal Lahir
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
                                       value="<?php echo e(old('tanggal_lahir', $participant->tanggal_lahir)); ?>"
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
                                    Tanggal Bergabung
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
                                       value="<?php echo e(old('tanggal_bergabung', $participant->tanggal_bergabung)); ?>">
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

                            <!-- Username Preview (Sama seperti di create.blade.php) -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading mb-2">
                                        <i class="bi bi-key me-2"></i>
                                        Username Otomatis
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span id="usernamePreview" class="fw-bold text-dark">
                                                <?php echo e($participant->username ?? '-'); ?>

                                            </span>
                                            <small class="text-muted d-block mt-1">
                                                Format: 2 huruf pertama nama + DDMMYYYY tanggal lahir
                                            </small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-dark" onclick="copyUsername()">
                                            <i class="bi bi-clipboard me-1"></i>Salin
                                        </button>
                                    </div>
                                </div>
                                <!-- Hidden input untuk menyimpan username -->
                                <input type="hidden" 
                                       name="username" 
                                       id="username" 
                                       value="<?php echo e(old('username', $participant->username)); ?>">
                                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <label for="department" class="form-label fw-semibold">
                                    Department
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="department" 
                                       name="department" 
                                       value="<?php echo e(old('department', $participant->department)); ?>" 
                                       placeholder="Department/Divisi"
                                       maxlength="255">
                                <?php $__errorArgs = ['department'];
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
                                    <option value="Magang" <?php echo e(old('program_type', $participant->program_type) == 'Magang' ? 'selected' : ''); ?>>Magang</option>
                                    <option value="PKL" <?php echo e(old('program_type', $participant->program_type) == 'PKL' ? 'selected' : ''); ?>>PKL</option>
                                    <option value="Studi Independen" <?php echo e(old('program_type', $participant->program_type) == 'Studi Independen' ? 'selected' : ''); ?>>Studi Independen</option>
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

                            <!-- Start Date -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">
                                    Tanggal Mulai Program
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="<?php echo e(old('start_date', $participant->start_date)); ?>">
                                <?php $__errorArgs = ['start_date'];
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

                            <!-- End Date -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-semibold">
                                    Tanggal Selesai Program
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="<?php echo e(old('end_date', $participant->end_date)); ?>">
                                <?php $__errorArgs = ['end_date'];
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

                            <!-- Status Aktif -->
                            <div class="col-md-6">
                                <label for="is_active" class="form-label fw-semibold">
                                    Status
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           <?php echo e(old('is_active', $participant->is_active) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_active">
                                        Peserta Aktif
                                    </label>
                                </div>
                                <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Foto Peserta -->
                            <div class="col-12">
                                <label for="gambar" class="form-label fw-semibold">Foto Peserta</label>
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
                                       onchange="previewImage(this)">
                                <div class="form-text">
                                    Format: JPG, PNG, JPEG (Maksimal 2MB). Kosongkan jika tidak ingin mengubah foto.
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
                                
                                <!-- Current Image -->
                                <?php if($participant->gambar): ?>
                                    <div class="mt-3">
                                        <p class="mb-2 fw-semibold">Foto Saat Ini:</p>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?php echo e($participant->getGambarUrlAttribute()); ?>" 
                                                 alt="Foto <?php echo e($participant->name); ?>" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmRemoveImage()">
                                                    <i class="bi bi-trash me-1"></i>Hapus Foto
                                                </button>
                                                <div class="form-text mt-1">Foto akan diganti dengan default avatar</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Belum ada foto
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-2 text-center" style="display: none;">
                                    <p class="mb-2 fw-semibold">Preview Foto Baru:</p>
                                    <img id="preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">
                                            <i class="bi bi-trash me-1"></i>Hapus Preview
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Sistem -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Sistem
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Barcode ID:</strong> 
                                            <span class="badge bg-dark"><?php echo e($participant->barcode_id); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Username Saat Ini:</strong> 
                                            <span class="badge bg-secondary"><?php echo e($participant->username ?? 'Belum diatur'); ?></span>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">
                                        <small>
                                            <i class="bi bi-lock me-1"></i>
                                            Barcode ID tidak dapat diubah. Username akan digenerate otomatis berdasarkan nama dan tanggal lahir.
                                        </small>
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
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
                                        Update Peserta
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input untuk remove image -->
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remove Image Confirmation Modal -->
<div class="modal fade" id="removeImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus foto peserta <strong><?php echo e($participant->name); ?></strong>?</p>
                <p class="text-warning mb-0">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Foto akan diganti dengan avatar default. Tindakan ini tidak dapat dibatalkan.
                    </small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="removeCurrentImage()">
                    <i class="bi bi-trash me-1"></i>Hapus Foto
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Generate username preview (sama seperti di create.blade.php)
function generateUsernamePreview() {
    const name = document.getElementById('name').value;
    const tanggalLahir = document.getElementById('tanggal_lahir').value;
    const usernamePreview = document.getElementById('usernamePreview');
    const usernameInput = document.getElementById('username');
    
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
        usernameInput.value = username;
    } else {
        usernamePreview.textContent = '-';
        usernameInput.value = '';
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
        // Validasi ukuran file (max 2MB)
        const fileSize = input.files[0].size / 1024 / 1024; // dalam MB
        if (fileSize > 2) {
            showToast('error', 'Ukuran file maksimal 2MB');
            input.value = '';
            return;
        }

        // Validasi tipe file
        const fileType = input.files[0].type;
        if (!fileType.match('image/jpeg') && !fileType.match('image/jpg') && !fileType.match('image/png')) {
            showToast('error', 'Format file harus JPG, JPEG, atau PNG');
            input.value = '';
            return;
        }

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
    showToast('info', 'Preview foto dihapus');
}

// Konfirmasi hapus foto saat ini
function confirmRemoveImage() {
    new bootstrap.Modal(document.getElementById('removeImageModal')).show();
}

// Hapus foto saat ini
function removeCurrentImage() {
    // Set nilai remove_image menjadi 1
    document.getElementById('remove_image').value = '1';
    
    // Sembunyikan modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('removeImageModal'));
    if (modal) {
        modal.hide();
    }
    
    // Sembunyikan foto saat ini
    const currentImageContainer = document.querySelector('.mt-3'); // Container foto saat ini
    if (currentImageContainer) {
        currentImageContainer.style.display = 'none';
    }
    
    showToast('warning', 'Foto akan dihapus saat data disimpan.');
}

// Reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mengembalikan semua nilai ke semula?')) {
        // Reset remove_image value
        document.getElementById('remove_image').value = '0';
        
        // Reset file input
        removeImage();
        
        // Show current image container if it was hidden
        const currentImageContainer = document.querySelector('.mt-3');
        if (currentImageContainer) {
            currentImageContainer.style.display = 'block';
        }
        
        // Reload halaman untuk reset ke nilai awal
        window.location.reload();
    }
}

// Validasi form sebelum submit
document.getElementById('participantForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    
    // Validasi email format
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        showToast('error', 'Format email tidak valid');
        return;
    }

    // Validasi tanggal
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (end < start) {
            e.preventDefault();
            showToast('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai');
            return;
        }
    }

    // Disable button dan show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memperbarui...';
    
    // Biarkan form submit
});

// Toast notification
function showToast(type, message) {
    // Hapus toast sebelumnya jika ada
    const existingToasts = document.querySelectorAll('.custom-toast');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `custom-toast alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-exclamation-circle' : type === 'warning' ? 'bi-exclamation-triangle' : 'bi-info-circle'} me-2"></i>
            <span>${message}</span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    // Auto remove setelah 5 detik
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

// Initialize form validation
document.addEventListener('DOMContentLoaded', function() {
    // Generate username preview pertama kali
    generateUsernamePreview();
    
    // Add real-time validation
    const inputs = document.querySelectorAll('input[required], select[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
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
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control[readonly] {
    background-color: #f8f9fa !important;
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

.img-thumbnail {
    border-radius: 0.5rem;
    border: 2px solid #dee2e6;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.custom-toast {
    animation: slideInRight 0.3s ease-out;
}

#usernamePreview {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    background: #fff3cd;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\PressGO\resources\views/participants/edit.blade.php ENDPATH**/ ?>