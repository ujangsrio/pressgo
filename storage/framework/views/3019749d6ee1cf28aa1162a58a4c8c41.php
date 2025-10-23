<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - <?php echo e($participant->name); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            flex-direction: column;
        }

        .id-card-container {
            display: flex;
            gap: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .id-card {
            width: 340px;
            height: 480px;
            perspective: 1000px;
        }

        .id-card-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s;
            cursor: pointer;
        }

        .id-card:hover .id-card-inner {
            transform: rotateY(180deg);
        }

        .id-card-front,
        .id-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .id-card-front {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .id-card-back {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            transform: rotateY(180deg);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 12px;
            opacity: 0.9;
            line-height: 1.2;
        }

        .photo-section {
            text-align: center;
            margin: 15px 0;
        }

        .photo-placeholder {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
            overflow: hidden;
        }

        .participant-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .photo-placeholder i {
            font-size: 32px;
            opacity: 0.7;
        }

        .participant-name {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .participant-id {
            text-align: center;
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .info-section {
            flex-grow: 1;
            margin-bottom: 10px;
        }

        .info-item {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }

        .info-item i {
            width: 18px;
            margin-right: 8px;
            opacity: 0.8;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
            min-width: 0; /* Important for text truncation */
        }

        .info-label {
            font-size: 10px;
            opacity: 0.8;
            margin-bottom: 1px;
            line-height: 1.2;
        }

        .info-value {
            font-size: 12px;
            font-weight: 500;
            word-break: break-word;
            line-height: 1.3;
            overflow-wrap: break-word;
        }

        .barcode-section {
            text-align: center;
            margin-top: auto;
        }

        .barcode-container {
            background: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .validity {
            text-align: center;
            font-size: 10px;
            opacity: 0.8;
            line-height: 1.2;
        }

        .validity-front {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            opacity: 0.8;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            line-height: 1.2;
        }

        .terms-section {
            margin-top: 15px;
            flex: 1;
        }

        .terms-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            line-height: 1.2;
        }

        .terms-content {
            font-size: 9px;
            line-height: 1.3;
            opacity: 0.9;
            text-align: justify;
            max-height: 80px;
            overflow: hidden;
        }

        .contact-info {
            margin-top: auto;
            text-align: center;
            padding-top: 10px;
        }

        .contact-item {
            margin-bottom: 6px;
            font-size: 10px;
            line-height: 1.2;
        }

        .contact-item i {
            margin-right: 4px;
        }

        .action-buttons {
            margin-top: 25px;
            text-align: center;
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #1e7e34;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        /* Print Optimization */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            
            body {
                margin: 0;
                padding: 15px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: white;
            }
            
            .id-card-container {
                box-shadow: none;
            }
            
            .id-card {
                page-break-inside: avoid;
            }
            
            .action-buttons {
                display: none;
            }

            .id-card-inner {
                transform: rotateY(0deg) !important;
            }

            .id-card-front,
            .id-card-back {
                position: relative;
                transform: none;
                backface-visibility: visible;
                box-shadow: none;
                margin-bottom: 15px;
            }

            .id-card {
                perspective: none;
                height: auto;
            }

            .id-card-inner {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Additional print styles for better output */
        @media print and (color) {
            .id-card-front,
            .id-card-back {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media print and (monochrome) {
            .id-card-front {
                background: #666 !important;
                color: #000 !important;
            }
            
            .id-card-back {
                background: #888 !important;
                color: #000 !important;
            }
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 480px) {
            .id-card-container {
                flex-direction: column;
                gap: 20px;
            }
            
            .id-card {
                width: 320px;
                height: 450px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 200px;
                justify-content: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="id-card-container">
        <div class="id-card">
            <div class="id-card-inner">
                <!-- Front Side -->
                <div class="id-card-front">
                    <div class="brand-header">
                        <div class="brand-name">MisnTV</div>
                        <div class="brand-subtitle">Nav Entertainment Corporation</div>
                    </div>

                    <div class="photo-section">
                        <div class="photo-placeholder">
                            <?php if($participant->gambar): ?>
                                <img src="<?php echo e($participant->getGambarUrlAttribute()); ?>" alt="Foto <?php echo e($participant->name); ?>" class="participant-photo">
                            <?php else: ?>
                                <i class="bi bi-person-fill"></i>
                            <?php endif; ?>
                        </div>
                        <div class="participant-name"><?php echo e($participant->name); ?></div>
                        <div class="participant-id">ID: <?php echo e($participant->barcode_id); ?></div>
                    </div>

                    <div class="info-section">
                        <div class="info-item">
                            <i class="bi bi-person-badge"></i>
                            <div class="info-content">
                                <div class="info-label">NIM / NISN</div>
                                <div class="info-value"><?php echo e($participant->nim); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-building"></i>
                            <div class="info-content">
                                <div class="info-label">Institution</div>
                                <div class="info-value"><?php echo e($participant->institution); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-tag"></i>
                            <div class="info-content">
                                <div class="info-label">Program</div>
                                <div class="info-value"><?php echo e($participant->program_type); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-envelope"></i>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value"><?php echo e($participant->email); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="validity-front">
                        VALID THRU <?php echo e(date('m/y', strtotime('+12 months'))); ?>

                    </div>
                </div>

                <!-- Back Side -->
                <div class="id-card-back">
                    <div class="brand-header">
                       <div class="brand-name">MisnTV</div>
                        <div class="brand-subtitle">TERMS & CONDITIONS</div>
                    </div>

                    <div class="terms-section">
                        <div class="terms-title">ID: <?php echo e($participant->barcode_id); ?></div>
                        <div class="terms-content">
                            This ID card is the property of MisnTV - Nav Entertainment Corporation and must be presented upon request. 
                            Loss or theft must be reported immediately. This card is non-transferable and must be returned upon termination.
                        </div>
                    </div>

                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            +62 812-3456-7890
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            info@misntv.com
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-globe"></i>
                            www.misntv.com
                        </div>
                    </div>

                    <div class="barcode-section">
                        <div class="barcode-container">
                            <?php if($participant->qr_code_url): ?>
                                <img src="<?php echo e($participant->qr_code_url); ?>" alt="QR Code <?php echo e($participant->barcode_id); ?>" style="width: 100px; height: 100px;">
                            <?php else: ?>
                                <svg id="barcode-back"></svg>
                            <?php endif; ?>
                        </div>
                        <div class="validity">ISSUED: <?php echo e(date('m/y')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Print ID Card
        </button>
        <a href="<?php echo e(route('participants.id-card', $participant)); ?>" class="btn btn-success">
            <i class="bi bi-arrow-left"></i> Back to Flip View
        </a>
        <a href="<?php echo e(route('participants.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-list-ul"></i> Back to List
        </a>
    </div>

    <script>
        // Generate barcode untuk back side jika QR code tidak tersedia
        <?php if(!$participant->qr_code_url): ?>
        JsBarcode("#barcode-back", "<?php echo e($participant->barcode_id); ?>", {
            format: "CODE128",
            width: 1.8,
            height: 60,
            displayValue: true,
            text: "<?php echo e($participant->barcode_id); ?>",
            fontOptions: "bold",
            font: "Arial",
            textAlign: "center",
            textMargin: 4,
            fontSize: 12,
            background: "#ffffff",
            lineColor: "#333333",
            margin: 8
        });
        <?php endif; ?>

        // Auto-print when page loads (optional)
        window.addEventListener('load', function() {
            // Uncomment the line below to auto-print when page loads
            // window.print();
        });

        // Add keyboard shortcut for printing (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\participants\id-card.blade.php ENDPATH**/ ?>