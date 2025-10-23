<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-people me-2"></i>
                        Manajemen Peserta
                    </h1>
                    <p class="text-muted mb-0">Kelola data mahasiswa magang dan PKL</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('participants.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Peserta
                    </a>
                    <a href="<?php echo e(route('participants.id-cards-all')); ?>" class="btn btn-success" target="_blank">
                        <i class="bi bi-person-badge me-2"></i>
                        Generate All ID Cards
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?php echo e($stats['total'] ?? 0); ?></h2>
                            <p class="mb-0 opacity-75">Total Peserta</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?php echo e($stats['magang'] ?? 0); ?></h2>
                            <p class="mb-0 opacity-75">Mahasiswa Magang</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?php echo e($stats['pkl'] ?? 0); ?></h2>
                            <p class="mb-0 opacity-75">Siswa PKL</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-custom bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?php echo e($stats['total'] ?? 0); ?></h2>
                            <p class="mb-0 opacity-75">Barcode Aktif</p>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-upc-scan"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-check me-2"></i>
                        Daftar Peserta
                    </h5>
                </div>
                <div class="card-body p-0">
                    <!-- Search and Filter -->
                    <div class="p-3 bg-light border-bottom">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Cari peserta..." id="searchInput">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="programFilter">
                                    <option value="">Semua Program</option>
                                    <option value="Magang">Magang</option>
                                    <option value="PKL">PKL</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="participantsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="80">
                                        <i class="bi bi-image me-2"></i>
                                        Foto
                                    </th>
                                    <th>
                                        <i class="bi bi-person me-2"></i>
                                        Nama Peserta
                                    </th>
                                    <th>
                                        <i class="bi bi-person-circle me-2"></i>
                                        Username
                                    </th>
                                    <th>
                                        <i class="bi bi-calendar-event me-2"></i>
                                        Tgl Lahir
                                    </th>
                                    <th>
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Tgl Bergabung
                                    </th>
                                    <th>
                                        <i class="bi bi-id-card me-2"></i>
                                        NIM / ID
                                    </th>
                                    <th>
                                        <i class="bi bi-envelope me-2"></i>
                                        Email
                                    </th>
                                    <th>
                                        <i class="bi bi-building me-2"></i>
                                        Institusi
                                    </th>
                                    <th>
                                        <i class="bi bi-tag me-2"></i>
                                        Program
                                    </th>
                                    <th>
                                        <i class="bi bi-upc-scan me-2"></i>
                                        Barcode ID
                                    </th>
                                    <th class="text-center" width="180">
                                        <i class="bi bi-activity me-2"></i>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="participant-photo-container">
                                            <?php if($participant->gambar): ?>
                                                <img src="<?php echo e($participant->getGambarUrlAttribute()); ?>" 
                                                     alt="Foto <?php echo e($participant->nim); ?>"
                                                     class="participant-photo"
                                                     data-bs-toggle="tooltip"
                                                     title="Lihat foto <?php echo e($participant->nim); ?>"
                                                     onclick="showPhotoModal('<?php echo e($participant->getGambarUrlAttribute()); ?>', '<?php echo e($participant->name); ?>')">
                                            <?php else: ?>
                                                <div class="no-photo-placeholder">
                                                    <i class="bi bi-person-circle"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0 fw-semibold"><?php echo e($participant->name); ?></h6>
                                                <small class="text-muted">Terdaftar: <?php echo e($participant->created_at->format('d/m/Y')); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-person-circle me-1"></i>
                                            <?php echo e($participant->username); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($participant->tanggal_lahir_formatted); ?><br>
                                            <?php if($participant->umur): ?>
                                                <span class="badge bg-light text-dark">(<?php echo e($participant->umur); ?> thn)</span>
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($participant->tanggal_bergabung_formatted); ?></small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold"><?php echo e($participant->nim); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-break"><?php echo e($participant->email); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-break"><?php echo e($participant->institution); ?></span>
                                    </td>
                                    <td>
                                        <?php if($participant->program_type === 'Magang'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-briefcase me-1"></i>
                                                Magang
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-info">
                                                <i class="bi bi-mortarboard me-1"></i>
                                                PKL
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-dark me-2">
                                                <i class="bi bi-upc-scan me-1"></i>
                                                <?php echo e($participant->barcode_id); ?>

                                            </span>
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    onclick="copyBarcode('<?php echo e($participant->barcode_id); ?>')"
                                                    data-bs-toggle="tooltip" 
                                                    title="Salin Barcode ID">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('participants.edit', $participant)); ?>" 
                                            class="btn btn-outline-primary"
                                            data-bs-toggle="tooltip" 
                                            title="Edit Peserta">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-outline-info"
                                                    onclick="showQrCodeModal(
                                                        '<?php echo e($participant->barcode_id); ?>', 
                                                        '<?php echo e($participant->name); ?>',
                                                        '<?php echo e($participant->nim); ?>',
                                                        '<?php echo e($participant->institution); ?>'
                                                    )"
                                                    data-bs-toggle="tooltip" 
                                                    title="Lihat QR Code">
                                                <i class="bi bi-qr-code"></i>
                                            </button>
                                            <a href="<?php echo e(route('participants.id-card', $participant)); ?>" 
                                                class="btn btn-outline-warning"
                                                data-bs-toggle="tooltip" 
                                                title="ID Card"
                                                target="_blank">
                                                 <i class="bi bi-person-badge"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" 
                                                    onclick="confirmDelete(<?php echo e($participant->id); ?>, '<?php echo e($participant->name); ?>')"
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Peserta">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <!-- PERBAIKAN: colspan diubah dari 8 menjadi 11 -->
                                    <td colspan="11" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-people display-4 d-block mb-3"></i>
                                            <h5>Belum ada peserta terdaftar</h5>
                                            <p class="mb-0">Tambahkan peserta baru untuk memulai sistem absensi.</p>
                                            <a href="<?php echo e(route('participants.create')); ?>" class="btn btn-primary mt-3">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                Tambah Peserta Pertama
                                            </a>
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
                <p>Apakah Anda yakin ingin menghapus peserta <strong id="deleteParticipantName"></strong>?</p>
                <p class="text-danger mb-0">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Barcode Modal -->
<div class="modal fade" id="barcodeModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-upc-scan me-2"></i>
                    Barcode Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h6 id="barcodeParticipantName" class="mb-3 fw-bold"></h6>
                
                <!-- Barcode Container -->
                <div class="barcode-card p-4 bg-white rounded-3 border mb-3">
                    <svg id="barcode-svg" class="barcode-svg"></svg>
                </div>
                
                <div class="barcode-info mb-3">
                    <code id="barcodeText" class="bg-light p-2 rounded d-inline-block"></code>
                </div>
                
                <div class="participant-info text-muted small">
                    <div class="row">
                        <div class="col-6">
                            <i class="bi bi-id-card me-1"></i>
                            <span id="barcodeNIM"></span>
                        </div>
                        <div class="col-6">
                            <i class="bi bi-building me-1"></i>
                            <span id="barcodeInstitution"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="printBarcode()">
                    <i class="bi bi-printer me-2"></i>
                    Print Barcode
                </button>
                <button type="button" class="btn btn-success" onclick="downloadBarcode()">
                    <i class="bi bi-download me-2"></i>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-qr-code me-2"></i>
                    QR Code Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h6 id="qrCodeParticipantName" class="mb-3 fw-bold"></h6>
                
                <!-- QR Code Container -->
                <div class="qr-code-card p-4 bg-white rounded-3 border mb-3">
                    <div id="qr-code-container" class="qr-code-container"></div>
                </div>
                
                <div class="qr-code-info mb-3">
                    <code id="qrCodeText" class="bg-light p-2 rounded d-inline-block"></code>
                </div>
                
                <div class="participant-info text-muted small">
                    <div class="row">
                        <div class="col-6">
                            <i class="bi bi-id-card me-1"></i>
                            <span id="qrCodeNIM"></span>
                        </div>
                        <div class="col-6">
                            <i class="bi bi-building me-1"></i>
                            <span id="qrCodeInstitution"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="printQrCode()">
                    <i class="bi bi-printer me-2"></i>
                    Print
                </button>
                <button type="button" class="btn btn-success" onclick="downloadQrCode()">
                    <i class="bi bi-download me-2"></i>
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalTitle">
                    <i class="bi bi-image me-2"></i>
                    Foto Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" alt="" class="img-fluid rounded" style="max-height: 500px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="downloadPhoto()">
                    <i class="bi bi-download me-2"></i>
                    Download Foto
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
// Search and Filter functionality
document.getElementById('searchInput').addEventListener('input', function() {
    filterParticipants();
});

document.getElementById('programFilter').addEventListener('change', function() {
    filterParticipants();
});

function filterParticipants() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const programFilter = document.getElementById('programFilter').value;
    const rows = document.querySelectorAll('#participantsTable tbody tr');
    
    rows.forEach(row => {
        // PERBAIKAN: Index kolom disesuaikan dengan struktur baru
        const name = row.cells[1].textContent.toLowerCase();
        const username = row.cells[2].textContent.toLowerCase();
        const nim = row.cells[5].textContent.toLowerCase();
        const email = row.cells[6].textContent.toLowerCase();
        const institution = row.cells[7].textContent.toLowerCase();
        const program = row.cells[8].textContent;
        
        const matchesSearch = name.includes(searchTerm) || 
                            username.includes(searchTerm) || 
                            nim.includes(searchTerm) || 
                            email.includes(searchTerm) ||
                            institution.includes(searchTerm);
        const matchesProgram = !programFilter || program.includes(programFilter);
        
        row.style.display = matchesSearch && matchesProgram ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('programFilter').value = '';
    filterParticipants();
}

// Delete confirmation
function confirmDelete(id, name) {
    document.getElementById('deleteParticipantName').textContent = name;
    document.getElementById('deleteForm').action = `/participants/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Barcode functions
function copyBarcode(barcode) {
    navigator.clipboard.writeText(barcode).then(() => {
        showToast('success', 'Barcode ID berhasil disalin!');
    });
}

function showBarcode(barcodeId, name, nim, institution) {
    document.getElementById('barcodeParticipantName').textContent = name;
    document.getElementById('barcodeText').textContent = barcodeId;
    document.getElementById('barcodeNIM').textContent = nim;
    document.getElementById('barcodeInstitution').textContent = institution;
    
    generateBarcode(barcodeId, name);
    new bootstrap.Modal(document.getElementById('barcodeModal')).show();
}

function generateBarcode(barcode, name) {
    const svg = document.getElementById('barcode-svg');
    
    // Clear previous barcode
    svg.innerHTML = '';
    
    // Generate barcode dengan berbagai opsi untuk hasil yang bagus
    JsBarcode(svg, barcode, {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: true,
        text: barcode,
        fontOptions: "bold",
        font: "Arial",
        textAlign: "center",
        textMargin: 5,
        fontSize: 16,
        background: "#ffffff",
        lineColor: "#2c3e50",
        margin: 10,
        marginTop: 15,
        marginBottom: 15,
        valid: function(valid) {
            if (!valid) {
                console.error('Barcode tidak valid:', barcode);
            }
        }
    });
    
    // Tambahkan styling tambahan untuk barcode
    const barcodeText = svg.querySelector('text');
    if (barcodeText) {
        barcodeText.setAttribute('font-weight', 'bold');
        barcodeText.setAttribute('fill', '#2c3e50');
    }
}

function printBarcode() {
    const barcodeContent = document.querySelector('.barcode-card').cloneNode(true);
    const participantName = document.getElementById('barcodeParticipantName').textContent;
    const barcodeText = document.getElementById('barcodeText').textContent;
    const nim = document.getElementById('barcodeNIM').textContent;
    const institution = document.getElementById('barcodeInstitution').textContent;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Barcode - ${participantName}</title>
            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
            <style>
                body { 
                    font-family: 'Arial', sans-serif; 
                    text-align: center; 
                    padding: 20px; 
                    margin: 0;
                    background: white;
                }
                .barcode-container { 
                    border: 2px solid #333;
                    padding: 20px;
                    margin: 10px auto;
                    max-width: 400px;
                    background: white;
                }
                .participant-info {
                    margin: 15px 0;
                    text-align: center;
                }
                .participant-name {
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 5px;
                    color: #2c3e50;
                }
                .barcode-text {
                    font-family: 'Courier New', monospace;
                    font-size: 14px;
                    font-weight: bold;
                    letter-spacing: 2px;
                    margin: 10px 0;
                    padding: 5px;
                    background: #f8f9fa;
                    border-radius: 4px;
                }
                .details {
                    font-size: 12px;
                    color: #666;
                    margin-top: 10px;
                }
                @media print {
                    body { padding: 0; }
                    .barcode-container { border: none; box-shadow: none; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="barcode-container">
                <div class="participant-info">
                    <div class="participant-name">${participantName}</div>
                    <div class="barcode-text">${barcodeText}</div>
                </div>
                <svg id="print-barcode" style="width: 100%; height: 80px;"></svg>
                <div class="details">
                    <div>NIM: ${nim}</div>
                    <div>Institusi: ${institution}</div>
                    <div>Tanggal: ${new Date().toLocaleDateString('id-ID')}</div>
                </div>
            </div>
            <div class="no-print" style="margin-top: 20px;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Print Barcode
                </button>
                <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                    Tutup
                </button>
            </div>
            
            <script>
                // Generate barcode untuk print
                JsBarcode("#print-barcode", "${barcodeText}", {
                    format: "CODE128",
                    width: 2,
                    height: 60,
                    displayValue: false,
                    background: "#ffffff",
                    lineColor: "#000000",
                    margin: 0
                });
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

function downloadBarcode() {
    const svg = document.getElementById('barcode-svg');
    const participantName = document.getElementById('barcodeParticipantName').textContent;
    const barcodeText = document.getElementById('barcodeText').textContent;
    
    // Convert SVG to canvas then to PNG
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const svgData = new XMLSerializer().serializeToString(svg);
    const img = new Image();
    
    const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
    const url = URL.createObjectURL(svgBlob);
    
    img.onload = function() {
        canvas.width = img.width;
        canvas.height = img.height + 40;
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
        
        // Add text below barcode
        ctx.fillStyle = '#2c3e50';
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(participantName, canvas.width / 2, canvas.height - 25);
        ctx.font = '12px Arial';
        ctx.fillText(barcodeText, canvas.width / 2, canvas.height - 10);
        
        // Create download link
        const pngUrl = canvas.toDataURL('image/png');
        const downloadLink = document.createElement('a');
        downloadLink.href = pngUrl;
        downloadLink.download = `barcode-${barcodeText}-${participantName}.png`;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
        
        URL.revokeObjectURL(url);
    };
    
    img.src = url;
}

// QR Code functions
function showQrCodeModal(qrCodeId, name, nim, institution) {
    document.getElementById('qrCodeParticipantName').textContent = name;
    document.getElementById('qrCodeText').textContent = qrCodeId;
    document.getElementById('qrCodeNIM').textContent = nim;
    document.getElementById('qrCodeInstitution').textContent = institution;
    
    // Generate QR Code
    const qrContainer = document.getElementById('qr-code-container');
    qrContainer.innerHTML = '';
    
    // Buat elemen img untuk QR Code
    const qrImg = document.createElement('img');
    qrImg.src = `/qr-code/${qrCodeId}`;
    qrImg.alt = `QR Code ${name}`;
    qrImg.className = 'qr-code-img';
    qrImg.style.width = '200px';
    qrImg.style.height = '200px';
    qrImg.style.borderRadius = '8px';
    
    qrContainer.appendChild(qrImg);
    
    new bootstrap.Modal(document.getElementById('qrCodeModal')).show();
}

function printQrCode() {
    const participantName = document.getElementById('qrCodeParticipantName').textContent;
    const qrCodeText = document.getElementById('qrCodeText').textContent;
    const nim = document.getElementById('qrCodeNIM').textContent;
    const institution = document.getElementById('qrCodeInstitution').textContent;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>QR Code - ${participantName}</title>
            <style>
                body { 
                    font-family: 'Arial', sans-serif; 
                    text-align: center; 
                    padding: 20px; 
                    margin: 0;
                    background: white;
                }
                .qr-code-container { 
                    border: 2px solid #333;
                    padding: 20px;
                    margin: 10px auto;
                    max-width: 300px;
                    background: white;
                }
                .participant-info {
                    margin: 15px 0;
                    text-align: center;
                }
                .participant-name {
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 5px;
                    color: #2c3e50;
                }
                .qr-code-text {
                    font-family: 'Courier New', monospace;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 10px 0;
                    padding: 5px;
                    background: #f8f9fa;
                    border-radius: 4px;
                }
                .details {
                    font-size: 12px;
                    color: #666;
                    margin-top: 10px;
                }
                .qr-code-img {
                    width: 200px;
                    height: 200px;
                    border-radius: 8px;
                }
                @media print {
                    body { padding: 0; }
                    .qr-code-container { border: none; box-shadow: none; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="qr-code-container">
                <div class="participant-info">
                    <div class="participant-name">${participantName}</div>
                    <div class="qr-code-text">${qrCodeText}</div>
                </div>
                <img src="/qr-code/${qrCodeText}" alt="QR Code ${participantName}" class="qr-code-img">
                <div class="details">
                    <div>NIM: ${nim}</div>
                    <div>Institusi: ${institution}</div>
                    <div>Tanggal: ${new Date().toLocaleDateString('id-ID')}</div>
                </div>
            </div>
            <div class="no-print" style="margin-top: 20px;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Print QR Code
                </button>
                <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                    Tutup
                </button>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}

function downloadQrCode() {
    const qrImg = document.querySelector('.qr-code-img');
    const participantName = document.getElementById('qrCodeParticipantName').textContent;
    const qrCodeText = document.getElementById('qrCodeText').textContent;
    
    // Create download link
    const downloadLink = document.createElement('a');
    downloadLink.href = qrImg.src;
    downloadLink.download = `qrcode-${qrCodeText}-${participantName}.png`;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Photo Modal functions
function showPhotoModal(photoUrl, participantName) {
    document.getElementById('modalPhoto').src = photoUrl;
    document.getElementById('modalPhoto').alt = `Foto ${participantName}`;
    document.getElementById('photoModalTitle').innerHTML = `<i class="bi bi-image me-2"></i>Foto ${participantName}`;
    
    new bootstrap.Modal(document.getElementById('photoModal')).show();
}

function downloadPhoto() {
    const photoUrl = document.getElementById('modalPhoto').src;
    const participantName = document.getElementById('photoModalTitle').textContent.replace('Foto ', '');
    
    const downloadLink = document.createElement('a');
    downloadLink.href = photoUrl;
    downloadLink.download = `foto-${participantName}.jpg`;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

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

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<style>
.participant-photo-container {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s;
}

.participant-photo-container:hover {
    transform: scale(1.05);
}

.participant-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.no-photo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.5rem;
    border: 2px dashed #dee2e6;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
    transform: translateY(-1px);
    transition: all 0.2s;
}

.qr-code-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 200px;
}

.qr-code-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.qr-code-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.barcode-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .participant-photo-container {
        width: 40px;
        height: 40px;
    }
    
    .no-photo-placeholder {
        font-size: 1.2rem;
    }
    
    .qr-code-img {
        width: 150px;
        height: 150px;
    }
    
    /* Hide some columns on mobile for better readability */
    .table th:nth-child(4), /* Tgl Lahir */
    .table td:nth-child(4),
    .table th:nth-child(5), /* Tgl Bergabung */
    .table td:nth-child(5),
    .table th:nth-child(7), /* Email */
    .table td:nth-child(7),
    .table th:nth-child(9), /* Program */
    .table td:nth-child(9) {
        display: none;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\participants\index.blade.php ENDPATH**/ ?>