<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Absensi - PressGO</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --border-radius: 1rem;
        }
        
        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Navigation Styles */
        .navbar-nav .nav-link.active {
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }
        
        /* Card Styles */
        .card-custom {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Camera Styles */
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            height: 300px;
            margin: 0 auto;
            border: 2px solid #dee2e6;
            border-radius: 0.75rem;
            background: #000;
            overflow: hidden;
        }
        
        #reader {
            width: 100% !important;
            height: 100% !important;
        }
        
        #reader__dashboard_section {
            display: none !important;
        }
        
        #reader__scan_region {
            width: 100% !important;
            height: 100% !important;
        }
        
        #reader__scan_region video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        
        .camera-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #6c757d;
            background: #000;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
        }
        
        /* User Info */
        .user-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            padding: 1rem;
            color: white;
        }
        
        /* Status & Results */
        .status-indicator {
            font-size: 0.9rem;
        }
        
        .result-container {
            margin-top: 1rem;
        }
        
        .alert {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Stats Cards */
        .stat-card {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.75rem;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        
        /* Button Styles */
        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        /* Utility Classes */
        .text-small {
            font-size: 0.875rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .camera-container {
                max-width: 100%;
                height: 250px;
            }
            
            .btn {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }
            
            .user-info {
                text-align: center;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo e(route('participant.dashboard')); ?>">
                <i class="fas fa-qrcode me-2"></i>PressGO
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('participant.dashboard') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('participant.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('participant.attendance.scan') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('participant.attendance.scan')); ?>">
                            <i class="fas fa-qrcode me-1"></i>Scan Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('participant.attendance.index') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('participant.attendance.index')); ?>">
                            <i class="fas fa-history me-1"></i>Riwayat Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('participant.settings.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('participant.settings.index')); ?>">
                            <i class="fas fa-cog me-1"></i>Pengaturan
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?php echo e(auth()->guard('participant')->user()->gambar_url); ?>" 
                                 alt="<?php echo e(auth()->guard('participant')->user()->name); ?>" 
                                 class="user-avatar">
                            <span><?php echo e(auth()->guard('participant')->user()->name); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('participant.dashboard')); ?>">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('participant.attendance.scan')); ?>">
                                    <i class="fas fa-qrcode me-1"></i>Scan Absensi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('participant.settings.index')); ?>">
                                    <i class="fas fa-cog me-1"></i>Pengaturan Akun
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-id-card me-1"></i><?php echo e(auth()->guard('participant')->user()->nim); ?>

                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-graduation-cap me-1"></i><?php echo e(auth()->guard('participant')->user()->program_type); ?>

                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('participant.logout')); ?>" id="participant-logout-form">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-white">
                            <i class="fas fa-qr-code me-2"></i>
                            Scan QR Code Absensi
                        </h1>
                        <p class="text-white-50 mb-0">Arahkan kamera ke QR code untuk melakukan absensi</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('participant.dashboard')); ?>" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="user-info">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1"><?php echo e(auth()->guard('participant')->user()->name); ?></h5>
                            <p class="mb-1"><?php echo e(auth()->guard('participant')->user()->nim); ?> • <?php echo e(auth()->guard('participant')->user()->program_type); ?></p>
                            <p class="mb-0"><?php echo e(auth()->guard('participant')->user()->institution); ?></p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>
                                Status: Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Scanner Section -->
            <div class="col-lg-8">
                <!-- Scanner Card -->
                <div class="card card-custom">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-camera me-2"></i>
                            Scanner Kamera
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Camera Section -->
                            <div class="col-md-6">
                                <div class="camera-container mb-3">
                                    <div id="reader"></div>
                                    <div class="camera-placeholder" id="cameraPlaceholder">
                                        <i class="fas fa-camera display-1 text-muted"></i>
                                        <p class="mt-2 mb-0 text-white">Kamera belum diaktifkan</p>
                                        <small class="text-muted">Klik "Start Scanner" untuk mengaktifkan kamera</small>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button id="startScanner" class="btn btn-success me-2">
                                        <i class="fas fa-play-circle me-2"></i>
                                        Start Scanner
                                    </button>
                                    <button id="stopScanner" class="btn btn-secondary" disabled>
                                        <i class="fas fa-stop-circle me-2"></i>
                                        Stop Scanner
                                    </button>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-white" id="cameraInfo">Kamera belum diaktifkan</small>
                                </div>
                            </div>
                            
                            <!-- Instructions & Settings -->
                            <div class="col-md-6">
                                <!-- Instructions -->
                                <div class="p-3 bg-light rounded-3 mb-3">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Petunjuk Penggunaan
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Izinkan akses kamera ketika diminta
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Arahkan kamera ke QR code peserta
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Pastikan pencahayaan cukup
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Jaga jarak optimal 20-50 cm
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Scanner Status -->
                                <div class="p-3 bg-light rounded-3 mb-3">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Status Scanner
                                    </h6>
                                    <div id="scannerStatus" class="d-flex align-items-center">
                                        <div class="spinner-border spinner-border-sm text-warning me-2 d-none" role="status" id="scannerLoading">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span id="statusText" class="status-indicator">Scanner belum diaktifkan</span>
                                    </div>
                                </div>

                                <!-- Camera Settings -->
                                <div class="p-3 bg-light rounded-3">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-cog me-2"></i>
                                        Pengaturan Kamera
                                    </h6>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="autoStart" checked>
                                        <label class="form-check-label" for="autoStart">Auto start scanner</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enableSound" checked>
                                        <label class="form-check-label" for="enableSound">Suara notifikasi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Cards -->
            <div class="col-lg-4">
                <!-- Manual Input Card -->
                <div class="card card-custom">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-keyboard me-2"></i>
                            Input Manual
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="manual-barcode" class="form-label fw-semibold">Kode QR/Barcode</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="manual-barcode" 
                                   placeholder="Masukkan kode QR/barcode..."
                                   autocomplete="off"
                                   maxlength="20">
                            <div class="form-text">Tekan Enter untuk submit</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary py-2" onclick="processManualInput()" id="submitManual">
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Absensi
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="clearManualInput()">
                                <i class="fas fa-times-circle me-2"></i>
                                Hapus Input
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Location Information Card -->
                <div class="card card-custom">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Informasi Lokasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-building me-2"></i>
                                Lokasi Absensi
                            </h6>
                            <p class="mb-1 text-small"><?php echo e($locationSettings['location_name'] ?? 'MISNTV | Mav Entertainment Corporation'); ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-crosshairs me-2"></i>
                                Radius Diperbolehkan
                            </h6>
                            <p class="mb-1 text-small"><?php echo e($locationSettings['radius'] ?? 100); ?> meter</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-map-marked-alt me-2"></i>
                                Koordinat
                            </h6>
                            <p class="mb-1 text-small">
                                Lat: <?php echo e(number_format($locationSettings['latitude'] ?? -8.224409, 6)); ?><br>
                                Long: <?php echo e(number_format($locationSettings['longitude'] ?? 114.372973, 6)); ?>

                            </p>
                        </div>
                        
                        <?php if($locationSettings['enabled'] ?? true): ?>
                            <div class="alert alert-warning py-2 mb-0">
                                <small>
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Absensi hanya dapat dilakukan di lokasi yang ditentukan
                                </small>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success py-2 mb-0">
                                <small>
                                    <i class="fas fa-check-circle me-1"></i>
                                    Pembatasan lokasi tidak aktif
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Attendance Information Card -->
                <div class="card card-custom">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Informasi Absensi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-success mb-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Masuk Tepat Waktu
                            </h6>
                            <p class="mb-0 text-muted text-small">Sebelum jam 08:00</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold text-warning mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Masuk Terlambat
                            </h6>
                            <p class="mb-0 text-muted text-small">Setelah jam 08:00</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold text-info mb-2">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Keluar
                            </h6>
                            <p class="mb-0 text-muted text-small">Pulang kerja</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Card -->
                <div class="card card-custom">
                    <div class="card-header bg-secondary text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Hari Ini
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-number text-primary" id="todayCheckins">0</div>
                                    <small class="text-muted">Masuk</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-number text-info" id="todayCheckouts">0</div>
                                    <small class="text-muted">Keluar</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div id="result" class="result-container" style="display: none;"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Global Variables
    const App = {
        scanner: null,
        scannerActive: false,
        todayStats: { checkins: 0, checkouts: 0 },
        
        // Utility Functions
        showAlert: function(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        },
        
        showLoading: function(text) {
            Swal.fire({
                title: text,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        
        hideLoading: function() {
            Swal.close();
        },
        
        playSuccessSound: function() {
            try {
                const context = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = context.createOscillator();
                const gainNode = context.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(context.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, context.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, context.currentTime + 0.3);
                
                oscillator.start(context.currentTime);
                oscillator.stop(context.currentTime + 0.3);
            } catch (e) {
                console.log('Audio play failed:', e);
            }
        }
    };

    // Geolocation Functions
    function getLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocation tidak didukung oleh browser ini'));
                return;
            }

            const options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            };

            navigator.geolocation.getCurrentPosition(
                position => resolve(position),
                error => reject(error),
                options
            );
        });
    }

    function handleLocationError(error) {
        let message = '';
        
        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = 'Izin akses lokasi ditolak. Silakan berikan izin lokasi untuk melakukan absensi.';
                break;
            case error.POSITION_UNAVAILABLE:
                message = 'Informasi lokasi tidak tersedia. Pastikan GPS aktif.';
                break;
            case error.TIMEOUT:
                message = 'Permintaan lokasi timeout. Coba lagi.';
                break;
            default:
                message = 'Error tidak diketahui saat mengambil lokasi.';
        }
        
        return message;
    }

    // QR Code Scanner Functions
    async function loadQrCodeLibrary() {
        return new Promise((resolve, reject) => {
            if (window.Html5Qrcode) {
                resolve();
                return;
            }

            const cdns = [
                'https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/minified/html5-qrcode.min.js',
                'https://unpkg.com/html5-qrcode@2.3.8/minified/html5-qrcode.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js'
            ];

            function tryLoad(index) {
                if (index >= cdns.length) {
                    reject(new Error('Semua CDN gagal dimuat'));
                    return;
                }

                const script = document.createElement('script');
                script.src = cdns[index];
                script.onload = () => {
                    console.log('Library berhasil dimuat dari:', cdns[index]);
                    resolve();
                };
                script.onerror = () => {
                    console.warn('Gagal memuat dari:', cdns[index]);
                    tryLoad(index + 1);
                };
                document.head.appendChild(script);
            }

            tryLoad(0);
        });
    }

    async function initScanner() {
        try {
            updateScannerStatus('Memuat scanner...', 'warning');
            
            await loadQrCodeLibrary();
            
            if (typeof Html5Qrcode === 'undefined') {
                throw new Error('QR Code scanner library tidak tersedia');
            }

            document.getElementById('cameraPlaceholder').style.display = 'none';
            
            const cameras = await Html5Qrcode.getCameras();
            if (!cameras || cameras.length === 0) {
                throw new Error('Tidak ditemukan kamera yang tersedia');
            }

            App.scanner = new Html5Qrcode("reader");
            
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            const cameraId = cameras[0].id;

            await App.scanner.start(
                cameraId, 
                config,
                onScanSuccess,
                onScanFailure
            );

            App.scannerActive = true;
            updateScannerButtons();
            updateScannerStatus('Scanner aktif - Arahkan ke QR code', 'success');
            updateCameraInfo(cameras[0].label || 'Kamera');
            
            if (document.getElementById('enableSound').checked) {
                App.playSuccessSound();
            }

        } catch (error) {
            console.error('Scanner initialization error:', error);
            handleCameraError(error);
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (App.scannerActive) {
            console.log('QR Code detected:', decodedText);
            
            stopScanner();
            updateScannerStatus('Memproses QR code...', 'warning');
            
            processBarcode(decodedText);
        }
    }

    function onScanFailure(error) {
        // Expected errors, no need to handle
    }

    async function startScanner() {
        if (!App.scannerActive) {
            await initScanner();
        }
    }

    async function stopScanner() {
        if (App.scanner && App.scannerActive) {
            try {
                await App.scanner.stop();
                App.scannerActive = false;
                updateScannerButtons();
                updateScannerStatus('Scanner dihentikan', 'secondary');
                showCameraPlaceholder();
            } catch (error) {
                console.error('Error stopping scanner:', error);
            }
        }
    }

    // UI Update Functions
    function updateScannerButtons() {
        const startBtn = document.getElementById('startScanner');
        const stopBtn = document.getElementById('stopScanner');
        
        if (App.scannerActive) {
            startBtn.disabled = true;
            stopBtn.disabled = false;
            startBtn.classList.remove('btn-success');
            startBtn.classList.add('btn-secondary');
        } else {
            startBtn.disabled = false;
            stopBtn.disabled = true;
            startBtn.classList.remove('btn-secondary');
            startBtn.classList.add('btn-success');
        }
    }

    function updateScannerStatus(message, type) {
        const statusText = document.getElementById('statusText');
        const scannerLoading = document.getElementById('scannerLoading');
        
        statusText.textContent = message;
        
        // Reset classes
        statusText.className = 'status-indicator';
        scannerLoading.className = 'spinner-border spinner-border-sm me-2';
        
        switch(type) {
            case 'success':
                statusText.classList.add('text-success', 'fw-semibold');
                scannerLoading.classList.add('d-none');
                break;
            case 'warning':
                statusText.classList.add('text-warning');
                scannerLoading.classList.remove('d-none');
                break;
            case 'danger':
                statusText.classList.add('text-danger');
                scannerLoading.classList.add('d-none');
                break;
            case 'secondary':
                statusText.classList.add('text-secondary');
                scannerLoading.classList.add('d-none');
                break;
            default:
                statusText.classList.add('text-muted');
                scannerLoading.classList.remove('d-none');
        }
    }

    function updateCameraInfo(cameraName) {
        const cameraInfo = document.getElementById('cameraInfo');
        cameraInfo.textContent = cameraName || 'Kamera';
        cameraInfo.className = 'text-success fw-semibold';
    }

    function showCameraPlaceholder() {
        const placeholder = document.getElementById('cameraPlaceholder');
        if (placeholder) {
            placeholder.style.display = 'flex';
        }
        const cameraInfo = document.getElementById('cameraInfo');
        cameraInfo.textContent = 'Kamera belum diaktifkan';
        cameraInfo.className = 'text-muted';
    }

    function handleCameraError(error) {
        console.error('Camera error:', error);
        let errorMessage = 'Tidak dapat mengakses kamera. ';
        
        if (error.name === 'NotAllowedError') {
            errorMessage += 'Izin akses kamera ditolak. Silakan berikan izin akses kamera di pengaturan browser Anda.';
        } else if (error.name === 'NotFoundError') {
            errorMessage += 'Tidak ditemukan kamera yang tersedia.';
        } else if (error.name === 'NotSupportedError') {
            errorMessage += 'Browser Anda tidak mendukung akses kamera.';
        } else if (error.name === 'NotReadableError') {
            errorMessage += 'Kamera sedang digunakan oleh aplikasi lain.';
        } else {
            errorMessage += 'Error: ' + error.message;
        }
        
        updateScannerStatus('Error kamera', 'danger');
        App.showAlert('error', 'Error Kamera', errorMessage);
        
        // Show manual input as fallback
        document.getElementById('manual-barcode').focus();
    }

    // Attendance Processing Functions
    function processBarcode(barcode) {
        App.showLoading('Mendeteksi lokasi...');
        
        getLocation()
            .then(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                
                App.showLoading('Memproses QR code...');
                
                fetch('<?php echo e(route("participant.attendance.process")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        barcode_id: barcode,
                        latitude: latitude,
                        longitude: longitude
                    })
                })
                .then(response => response.json())
                .then(data => {
                    App.hideLoading();
                    showResult(data);
                    updateTodayStats(data);
                    
                    // Auto-restart scanner after 2 seconds
                    setTimeout(() => {
                        if (!App.scannerActive) {
                            startScanner();
                        }
                    }, 2000);
                })
                .catch(error => {
                    App.hideLoading();
                    console.error('Error:', error);
                    App.showAlert('error', 'Error', 'Terjadi kesalahan saat memproses QR code');
                    setTimeout(() => {
                        if (!App.scannerActive) {
                            startScanner();
                        }
                    }, 2000);
                });
            })
            .catch(error => {
                App.hideLoading();
                const errorMessage = handleLocationError(error);
                App.showAlert('error', 'Error Lokasi', errorMessage);
                
                // Tampilkan opsi untuk coba lagi
                Swal.fire({
                    title: 'Error Lokasi',
                    text: errorMessage,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Coba Lagi',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        processBarcode(barcode);
                    } else {
                        // Restart scanner jika batal
                        setTimeout(() => {
                            if (!App.scannerActive) {
                                startScanner();
                            }
                        }, 1000);
                    }
                });
            });
    }

    function processManualInput() {
        const barcodeInput = document.getElementById('manual-barcode');
        const barcode = barcodeInput.value.trim();
        
        if (!barcode) {
            App.showAlert('warning', 'Peringatan', 'Silakan masukkan kode QR/barcode');
            return;
        }
        
        processBarcode(barcode);
        barcodeInput.value = '';
    }

    function clearManualInput() {
        document.getElementById('manual-barcode').value = '';
    }

    function showResult(data) {
        const resultDiv = document.getElementById('result');
        
        if (data.success) {
            let locationHtml = '';
            if (data.location_info) {
                locationHtml = `<p class="mb-1"><strong>Lokasi:</strong> ${data.location_info}</p>`;
            }
            
            resultDiv.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show">
                    <h4>✅ ${data.message}</h4>
                    <p><strong>Nama:</strong> ${data.participant.name}</p>
                    <p><strong>NIM:</strong> ${data.participant.nim}</p>
                    <p><strong>Status:</strong> ${data.type === 'check_in' ? 'Check In' : 'Check Out'}</p>
                    ${locationHtml}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            if (document.getElementById('enableSound').checked) {
                App.playSuccessSound();
            }
        } else {
            let errorHtml = `<h4>❌ ${data.message}</h4>`;
            if (data.location_error) {
                errorHtml += `<p class="mt-2"><i class="fas fa-map-marker-alt me-1"></i>${data.message}</p>`;
            }
            
            resultDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show">
                    ${errorHtml}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
        
        resultDiv.style.display = 'block';
        
        // Auto hide result after 5 seconds
        setTimeout(() => {
            resultDiv.style.display = 'none';
        }, 5000);
    }

    function updateTodayStats(data) {
        if (data.success) {
            if (data.type === 'check_in') {
                App.todayStats.checkins++;
            } else {
                App.todayStats.checkouts++;
            }
            
            document.getElementById('todayCheckins').textContent = App.todayStats.checkins;
            document.getElementById('todayCheckouts').textContent = App.todayStats.checkouts;
        }
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize scanner buttons
        document.getElementById('startScanner').addEventListener('click', startScanner);
        document.getElementById('stopScanner').addEventListener('click', stopScanner);
        
        // Enter key untuk manual input
        document.getElementById('manual-barcode').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                processManualInput();
            }
        });

        // Auto-start scanner jika setting enabled
        const autoStartCheckbox = document.getElementById('autoStart');
        if (autoStartCheckbox && autoStartCheckbox.checked) {
            setTimeout(() => {
                startScanner();
            }, 1000);
        }

        // Handle logout confirmation
        const logoutForm = document.getElementById('participant-logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
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
                        const button = this.querySelector('button[type="submit"]');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Logging out...';
                        button.disabled = true;
                        
                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            });
        }
    });

    // Handle page visibility change
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && App.scannerActive) {
            stopScanner();
        }
    });

    // Clean up when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (App.scanner && App.scannerActive) {
            App.scanner.stop().catch(error => {
                console.log('Error stopping scanner on unload:', error);
            });
        }
    });
    </script>
</body>
</html><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\PressGO\resources\views/participant/attendance/scan.blade.php ENDPATH**/ ?>