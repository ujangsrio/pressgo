@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-qr-code-scan me-2"></i>
                        Scan QR Code Absensi
                    </h1>
                    <p class="text-muted mb-0">Arahkan kamera ke QR code mahasiswa untuk melakukan absensi</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Data Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Scanner Section -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-camera-video me-2"></i>
                        Scanner Kamera
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Camera Container -->
                            <div class="camera-container mb-3">
                                <div id="reader"></div>
                                <div class="camera-placeholder" id="cameraPlaceholder">
                                    <i class="bi bi-camera-video display-1 text-muted"></i>
                                    <p class="mt-2 mb-0">Kamera belum diaktifkan</p>
                                    <small class="text-muted">Klik "Start Scanner" untuk mengaktifkan kamera</small>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="startScanner" class="btn btn-success me-2">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Start Scanner
                                </button>
                                <button id="stopScanner" class="btn btn-secondary" disabled>
                                    <i class="bi bi-stop-circle me-2"></i>
                                    Stop Scanner
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted" id="cameraInfo">Kamera belum diaktifkan</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-3">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Petunjuk Penggunaan:
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Izinkan akses kamera ketika diminta
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Arahkan kamera ke QR code peserta
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Pastikan pencahayaan cukup
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Jaga jarak optimal 20-50 cm
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Scanner Status -->
                            <div class="mt-4 p-3 bg-light rounded-3">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-activity me-2"></i>
                                    Status Scanner:
                                </h6>
                                <div id="scannerStatus" class="d-flex align-items-center">
                                    <div class="spinner-border spinner-border-sm text-warning me-2 d-none" role="status" id="scannerLoading">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span id="statusText">Scanner belum diaktifkan</span>
                                </div>
                            </div>

                            <!-- Camera Settings -->
                            <div class="mt-3 p-3 bg-light rounded-3">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-gear me-2"></i>
                                    Pengaturan Kamera:
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

        <div class="col-lg-4">
            <!-- Manual Input Section -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-keyboard me-2"></i>
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
                            <i class="bi bi-send-check me-2"></i>
                            Submit Absensi
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="clearManualInput()">
                            <i class="bi bi-x-circle me-2"></i>
                            Hapus Input
                        </button>
                    </div>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Informasi Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold text-success mb-2">
                            <i class="bi bi-check-circle me-2"></i>
                            Masuk Tepat Waktu
                        </h6>
                        <p class="mb-0 text-muted">Sebelum jam 08:00</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-warning mb-2">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Masuk Terlambat
                        </h6>
                        <p class="mb-0 text-muted">Setelah jam 08:00</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-info mb-2">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Keluar
                        </h6>
                        <p class="mb-0 text-muted">Pulang kerja</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card card-custom">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        Statistik Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <h4 class="fw-bold text-primary mb-1" id="todayCheckins">0</h4>
                                <small class="text-muted">Masuk</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <h4 class="fw-bold text-info mb-1" id="todayCheckouts">0</h4>
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
@endsection

@section('scripts')
<!-- SweetAlert2 untuk notifikasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Deklarasi variabel global
let scanner = null;
let scannerActive = false;
let todayStats = { checkins: 0, checkouts: 0 };

// Fungsi helper untuk alert
function showAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
}

function showLoading(text) {
    Swal.fire({
        title: text,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function hideLoading() {
    Swal.close();
}

// Cek ketersediaan library HTML5 QR Code
function loadQrCodeLibrary() {
    return new Promise((resolve, reject) => {
        // Cek jika library sudah dimuat
        if (window.Html5Qrcode) {
            resolve();
            return;
        }

        // Coba load dari berbagai CDN
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

// Initialize scanner
async function initScanner() {
    try {
        updateScannerStatus('Memuat scanner...', 'warning');
        
        // Load library terlebih dahulu
        await loadQrCodeLibrary();
        
        // Cek ketersediaan library setelah load
        if (typeof Html5Qrcode === 'undefined') {
            throw new Error('QR Code scanner library tidak tersedia');
        }

        // Hide placeholder
        document.getElementById('cameraPlaceholder').style.display = 'none';
        
        // Get available cameras
        const cameras = await Html5Qrcode.getCameras();
        if (!cameras || cameras.length === 0) {
            throw new Error('Tidak ditemukan kamera yang tersedia');
        }

        // Create scanner
        scanner = new Html5Qrcode("reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        // Use first camera
        const cameraId = cameras[0].id;

        // Start scanner
        await scanner.start(
            cameraId, 
            config,
            onScanSuccess,
            onScanFailure
        );

        scannerActive = true;
        updateScannerButtons();
        updateScannerStatus('Scanner aktif - Arahkan ke QR code', 'success');
        updateCameraInfo(cameras[0].label || 'Kamera');
        
        if (document.getElementById('enableSound').checked) {
            playSuccessSound();
        }

    } catch (error) {
        console.error('Scanner initialization error:', error);
        handleCameraError(error);
    }
}

function onScanSuccess(decodedText, decodedResult) {
    if (scannerActive) {
        console.log('QR Code detected:', decodedText);
        
        // Stop scanner temporarily to prevent multiple scans
        stopScanner();
        updateScannerStatus('Memproses QR code...', 'warning');
        
        // Process the scanned code
        processBarcode(decodedText);
    }
}

function onScanFailure(error) {
    // Expected errors, no need to handle
}

async function startScanner() {
    if (!scannerActive) {
        await initScanner();
    }
}

async function stopScanner() {
    if (scanner && scannerActive) {
        try {
            await scanner.stop();
            scannerActive = false;
            updateScannerButtons();
            updateScannerStatus('Scanner dihentikan', 'secondary');
            showCameraPlaceholder();
        } catch (error) {
            console.error('Error stopping scanner:', error);
        }
    }
}

function updateScannerButtons() {
    const startBtn = document.getElementById('startScanner');
    const stopBtn = document.getElementById('stopScanner');
    
    if (scannerActive) {
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
    statusText.className = '';
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
    showAlert('error', 'Error Kamera', errorMessage);
    
    // Show manual input as fallback
    document.getElementById('manual-barcode').focus();
}

// Audio functions
function playSuccessSound() {
    try {
        // Simple beep using Web Audio API
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

// Process barcode functions
function processBarcode(barcode) {
    showLoading('Memproses QR code...');
    
    fetch('{{ route("attendance.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            barcode_id: barcode
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        showResult(data);
        updateTodayStats(data);
        
        // Auto-restart scanner after 2 seconds
        setTimeout(() => {
            if (!scannerActive) {
                startScanner();
            }
        }, 2000);
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showAlert('error', 'Error', 'Terjadi kesalahan saat memproses QR code');
        // Restart scanner on error too
        setTimeout(() => {
            if (!scannerActive) {
                startScanner();
            }
        }, 2000);
    });
}

function processManualInput() {
    const barcodeInput = document.getElementById('manual-barcode');
    const barcode = barcodeInput.value.trim();
    
    if (!barcode) {
        showAlert('warning', 'Peringatan', 'Silakan masukkan kode QR/barcode');
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
        resultDiv.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show">
                <h4>✅ ${data.message}</h4>
                <p><strong>Nama:</strong> ${data.participant.name}</p>
                <p><strong>NIM:</strong> ${data.participant.nim}</p>
                <p><strong>Status:</strong> ${data.type === 'check_in' ? 'Check In' : 'Check Out'}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        if (document.getElementById('enableSound').checked) {
            playSuccessSound();
        }
    } else {
        resultDiv.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show">
                <h4>❌ ${data.message}</h4>
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
            todayStats.checkins++;
        } else {
            todayStats.checkouts++;
        }
        
        document.getElementById('todayCheckins').textContent = todayStats.checkins;
        document.getElementById('todayCheckouts').textContent = todayStats.checkouts;
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
});

// Handle page visibility change
document.addEventListener('visibilitychange', function() {
    if (document.hidden && scannerActive) {
        stopScanner();
    }
});

// Clean up when page is unloaded
window.addEventListener('beforeunload', function() {
    if (scanner && scannerActive) {
        scanner.stop().catch(error => {
            console.log('Error stopping scanner on unload:', error);
        });
    }
});
</script>

<style>
/* Camera Container */
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

.result-container {
    margin-top: 1rem;
}

.alert {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

#scannerStatus {
    font-size: 0.9rem;
}

.spinner-border {
    width: 1rem;
    height: 1rem;
}

.btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .camera-container {
        max-width: 100%;
        height: 250px;
    }
    
    .btn {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
}
</style>
@endsection