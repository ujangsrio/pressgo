

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-gear me-2"></i>
                        Pengaturan Sistem
                    </h1>
                    <p class="text-muted mb-0">Kelola pengaturan brand, desain ID Card, lokasi absensi, dan sistem</p>
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

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Settings Form -->
    <div class="row">
        <div class="col-12">
            <!-- Main Settings Form -->
            <form action="<?php echo e(route('settings.update')); ?>" method="POST" id="settingsForm">
                <?php echo csrf_field(); ?>
                
                <div class="card card-custom mb-4">
                    <div class="card-header bg-white py-3">
                        <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="brand-tab" data-bs-toggle="tab" data-bs-target="#brand" type="button">
                                    <i class="bi bi-building me-2"></i>Brand
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                                    <i class="bi bi-telephone me-2"></i>Kontak
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button">
                                    <i class="bi bi-geo-alt me-2"></i>Lokasi Absensi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button">
                                    <i class="bi bi-palette me-2"></i>Desain ID Card
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button">
                                    <i class="bi bi-cpu me-2"></i>Sistem
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content" id="settingsTabsContent">
                            <!-- Brand Settings Tab -->
                            <div class="tab-pane fade show active" id="brand" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="brand_name" class="form-label fw-semibold">Nama Brand</label>
                                        <input type="text" class="form-control" id="brand_name" name="settings[brand_name]" 
                                               value="<?php echo e(App\Models\Setting::getValue('brand_name', 'BRAND NAME')); ?>">
                                        <div class="form-text">Nama brand yang ditampilkan di ID Card</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="brand_subtitle" class="form-label fw-semibold">Subtitle Brand</label>
                                        <input type="text" class="form-control" id="brand_subtitle" name="settings[brand_subtitle]" 
                                               value="<?php echo e(App\Models\Setting::getValue('brand_subtitle', 'INTERNSHIP PROGRAM')); ?>">
                                        <div class="form-text">Subtitle di bawah nama brand</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="company_name" class="form-label fw-semibold">Nama Perusahaan Lengkap</label>
                                        <input type="text" class="form-control" id="company_name" name="settings[company_name]" 
                                               value="<?php echo e(App\Models\Setting::getValue('company_name', 'Company Name Inc.')); ?>">
                                        <div class="form-text">Nama legal perusahaan</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Settings Tab -->
                            <div class="tab-pane fade" id="contact" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="contact_phone" class="form-label fw-semibold">Telepon</label>
                                        <input type="text" class="form-control" id="contact_phone" name="settings[contact_phone]" 
                                               value="<?php echo e(App\Models\Setting::getValue('contact_phone', '+62 812-3456-7890')); ?>">
                                        <div class="form-text">Nomor telepon perusahaan</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="contact_email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="contact_email" name="settings[contact_email]" 
                                               value="<?php echo e(App\Models\Setting::getValue('contact_email', 'info@brandname.com')); ?>">
                                        <div class="form-text">Email perusahaan</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="contact_website" class="form-label fw-semibold">Website</label>
                                        <input type="text" class="form-control" id="contact_website" name="settings[contact_website]" 
                                               value="<?php echo e(App\Models\Setting::getValue('contact_website', 'www.brandname.com')); ?>">
                                        <div class="form-text">Website perusahaan</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="contact_address" class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control" id="contact_address" name="settings[contact_address]" rows="3"><?php echo e(App\Models\Setting::getValue('contact_address', 'Jl. Contoh Alamat No. 123, Jakarta, Indonesia')); ?></textarea>
                                        <div class="form-text">Alamat lengkap perusahaan</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Settings Tab -->
                            <div class="tab-pane fade" id="location" role="tabpanel">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Pengaturan ini mengontrol lokasi dimana peserta dapat melakukan absensi. 
                                    Peserta harus berada dalam radius yang ditentukan dari lokasi yang ditetapkan.
                                </div>

                                <form action="<?php echo e(route('settings.location.update')); ?>" method="POST" id="locationForm">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="location_name" class="form-label fw-semibold">Nama Lokasi</label>
                                            <input type="text" class="form-control" id="location_name" name="location_name" 
                                                   value="<?php echo e($locationSettings['location_name']); ?>" required>
                                            <div class="form-text">Nama lokasi absensi yang akan ditampilkan ke peserta</div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="latitude" class="form-label fw-semibold">Latitude</label>
                                            <input type="number" step="any" class="form-control" id="latitude" name="latitude" 
                                                   value="<?php echo e($locationSettings['latitude']); ?>" required>
                                            <div class="form-text">Koordinat latitude lokasi (-90 sampai 90)</div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="longitude" class="form-label fw-semibold">Longitude</label>
                                            <input type="number" step="any" class="form-control" id="longitude" name="longitude" 
                                                   value="<?php echo e($locationSettings['longitude']); ?>" required>
                                            <div class="form-text">Koordinat longitude lokasi (-180 sampai 180)</div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="radius" class="form-label fw-semibold">Radius (meter)</label>
                                            <input type="number" class="form-control" id="radius" name="radius" 
                                                   value="<?php echo e($locationSettings['radius']); ?>" min="10" max="1000" required>
                                            <div class="form-text">Jarak maksimum dari lokasi untuk melakukan absensi (10-1000 meter)</div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mt-4 pt-2">
                                                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" 
                                                       <?php echo e($locationSettings['enabled'] ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="enabled">
                                                    Aktifkan Pembatasan Lokasi
                                                </label>
                                            </div>
                                            <div class="form-text">Nonaktifkan untuk mengizinkan absensi dari mana saja</div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="fw-semibold mb-3">
                                                        <i class="bi bi-map me-2"></i>
                                                        Informasi Lokasi Saat Ini
                                                    </h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong>Lokasi:</strong> <?php echo e($locationSettings['location_name']); ?><br>
                                                            <strong>Koordinat:</strong> <?php echo e(number_format($locationSettings['latitude'], 6)); ?>, <?php echo e(number_format($locationSettings['longitude'], 6)); ?>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Radius:</strong> <?php echo e($locationSettings['radius']); ?> meter<br>
                                                            <strong>Status:</strong> 
                                                            <span class="badge <?php echo e($locationSettings['enabled'] ? 'bg-success' : 'bg-secondary'); ?>">
                                                                <?php echo e($locationSettings['enabled'] ? 'Aktif' : 'Nonaktif'); ?>

                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save me-2"></i>Simpan Pengaturan Lokasi
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <hr class="my-4">

                                <!-- Test Location Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="fw-semibold mb-3">
                                            <i class="bi bi-search me-2"></i>
                                            Test Lokasi
                                        </h6>
                                        <p class="text-muted">Test koordinat untuk memeriksa apakah berada dalam radius yang ditentukan</p>
                                        
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <input type="number" step="any" class="form-control" id="test_latitude" 
                                                       placeholder="Latitude" value="<?php echo e($locationSettings['latitude']); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" step="any" class="form-control" id="test_longitude" 
                                                       placeholder="Longitude" value="<?php echo e($locationSettings['longitude']); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-info w-100" onclick="testLocation()">
                                                    <i class="bi bi-search me-2"></i>Test Lokasi
                                                </button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-secondary w-100" onclick="getCurrentLocation()">
                                                    <i class="bi bi-crosshair me-2"></i>Lokasi Saya
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div id="testResult" class="mt-3" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Design Settings Tab -->
                            <div class="tab-pane fade" id="design" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="id_card_validity_months" class="form-label fw-semibold">Masa Berlaku (Bulan)</label>
                                        <input type="number" class="form-control" id="id_card_validity_months" name="settings[id_card_validity_months]" 
                                               value="<?php echo e(App\Models\Setting::getValue('id_card_validity_months', '12')); ?>" min="1" max="60">
                                        <div class="form-text">Masa berlaku ID Card dalam bulan</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="front_background" class="form-label fw-semibold">Background Depan</label>
                                        <input type="text" class="form-control" id="front_background" name="settings[front_background]" 
                                               value="<?php echo e(App\Models\Setting::getValue('front_background', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)')); ?>">
                                        <div class="form-text">CSS gradient/color untuk background depan</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="back_background" class="form-label fw-semibold">Background Belakang</label>
                                        <input type="text" class="form-control" id="back_background" name="settings[back_background]" 
                                               value="<?php echo e(App\Models\Setting::getValue('back_background', 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)')); ?>">
                                        <div class="form-text">CSS gradient/color untuk background belakang</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="terms_conditions" class="form-label fw-semibold">Syarat & Ketentuan</label>
                                        <textarea class="form-control" id="terms_conditions" name="settings[terms_conditions]" rows="4"><?php echo e(App\Models\Setting::getValue('terms_conditions', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis elit sapien, convallis vell enim sit amet. This card is property of Brand Name and must be returned upon termination of program. Loss or theft must be reported immediately.')); ?></textarea>
                                        <div class="form-text">Teks syarat dan ketentuan untuk belakang ID Card</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="show_barcode_front" name="settings[show_barcode_front]" value="1" 
                                                   <?php echo e(App\Models\Setting::getValue('show_barcode_front', '0') ? 'checked' : ''); ?>>
                                            <label class="form-check-label fw-semibold" for="show_barcode_front">
                                                Tampilkan Barcode di Sisi Depan
                                            </label>
                                        </div>
                                        <div class="form-text">Centang untuk menampilkan barcode di sisi depan ID Card</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="show_barcode_back" name="settings[show_barcode_back]" value="1" 
                                                   <?php echo e(App\Models\Setting::getValue('show_barcode_back', '1') ? 'checked' : ''); ?>>
                                            <label class="form-check-label fw-semibold" for="show_barcode_back">
                                                Tampilkan Barcode di Sisi Belakang
                                            </label>
                                        </div>
                                        <div class="form-text">Centang untuk menampilkan barcode di sisi belakang ID Card</div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Settings Tab -->
                            <div class="tab-pane fade" id="system" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="id_card_size_width" class="form-label fw-semibold">Lebar ID Card (px)</label>
                                        <input type="number" class="form-control" id="id_card_size_width" name="settings[id_card_size_width]" 
                                               value="<?php echo e(App\Models\Setting::getValue('id_card_size_width', '350')); ?>" min="200" max="800">
                                        <div class="form-text">Lebar ID Card dalam pixel</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="id_card_size_height" class="form-label fw-semibold">Tinggi ID Card (px)</label>
                                        <input type="number" class="form-control" id="id_card_size_height" name="settings[id_card_size_height]" 
                                               value="<?php echo e(App\Models\Setting::getValue('id_card_size_height', '500')); ?>" min="300" max="1000">
                                        <div class="form-text">Tinggi ID Card dalam pixel</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="auto_print_id_card" name="settings[auto_print_id_card]" value="1" 
                                                   <?php echo e(App\Models\Setting::getValue('auto_print_id_card', '0') ? 'checked' : ''); ?>>
                                            <label class="form-check-label fw-semibold" for="auto_print_id_card">
                                                Auto Print ID Card
                                            </label>
                                        </div>
                                        <div class="form-text">Otomatis print ID Card setelah generate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Pengaturan
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="resetToDefault()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset ke Default
                                </button>
                            </div>
                            <div class="text-muted">
                                <small>Perubahan akan berlaku untuk ID Card yang baru digenerate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-eye me-2"></i>
                        Preview ID Card
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Preview akan menampilkan perubahan sesuai pengaturan yang disimpan</p>
                    <a href="<?php echo e(route('participants.id-cards-all')); ?>" class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-person-badge me-2"></i>
                        Lihat Preview Semua ID Card
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function resetToDefault() {
    if (confirm('Apakah Anda yakin ingin mengembalikan semua pengaturan ke nilai default?')) {
        // You can implement AJAX reset here or redirect to reset route
        window.location.href = "<?php echo e(route('settings.reset')); ?>";
    }
}

// Handle checkbox values for unchecked state
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    const checkboxes = this.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (!checkbox.checked) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = checkbox.name;
            hiddenInput.value = '0';
            this.appendChild(hiddenInput);
        }
    });
});

// Location testing functions
function testLocation() {
    const latitude = document.getElementById('test_latitude').value;
    const longitude = document.getElementById('test_longitude').value;
    
    if (!latitude || !longitude) {
        alert('Silakan masukkan latitude dan longitude untuk test');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Testing...';
    button.disabled = true;

    fetch('<?php echo e(route("settings.location.test")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            test_latitude: latitude,
            test_longitude: longitude
        })
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('testResult');
        if (data.valid) {
            resultDiv.innerHTML = `
                <div class="alert alert-success">
                    <h6><i class="bi bi-check-circle me-2"></i>Lokasi Valid</h6>
                    <p class="mb-1">${data.message}</p>
                    <p class="mb-0"><strong>Jarak:</strong> ${data.distance}m (Maksimal: ${data.max_distance}m)</p>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <h6><i class="bi bi-x-circle me-2"></i>Lokasi Tidak Valid</h6>
                    <p class="mb-1">${data.message}</p>
                    <p class="mb-0"><strong>Jarak:</strong> ${data.distance}m (Maksimal: ${data.max_distance}m)</p>
                </div>
            `;
        }
        resultDiv.style.display = 'block';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat testing lokasi');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Geolocation tidak didukung oleh browser ini');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mendeteksi...';
    button.disabled = true;

    navigator.geolocation.getCurrentPosition(
        position => {
            document.getElementById('test_latitude').value = position.coords.latitude;
            document.getElementById('test_longitude').value = position.coords.longitude;
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Auto test the location
            setTimeout(() => testLocation(), 500);
        },
        error => {
            let message = 'Gagal mendapatkan lokasi: ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message += 'Izin lokasi ditolak';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message += 'Informasi lokasi tidak tersedia';
                    break;
                case error.TIMEOUT:
                    message += 'Timeout mendapatkan lokasi';
                    break;
                default:
                    message += 'Error tidak diketahui';
            }
            alert(message);
            button.innerHTML = originalText;
            button.disabled = false;
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

// Color picker for backgrounds (simple implementation)
document.getElementById('front_background').addEventListener('focus', function() {
    this.title = 'Contoh: linear-gradient(135deg, #667eea 0%, #764ba2 100%) atau #3498db';
});

document.getElementById('back_background').addEventListener('focus', function() {
    this.title = 'Contoh: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) atau #e74c3c';
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\PressGO\resources\views/settings/index.blade.php ENDPATH**/ ?>