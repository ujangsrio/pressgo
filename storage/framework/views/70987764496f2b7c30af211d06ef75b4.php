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
        }

        .id-card-container {
            display: flex;
            gap: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .id-card {
            width: 350px;
            height: 500px;
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
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 25px;
            display: flex;
            flex-direction: column;
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
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .brand-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .photo-section {
            text-align: center;
            margin: 20px 0;
        }

        .photo-placeholder {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
        }

        .photo-placeholder i {
            font-size: 40px;
            opacity: 0.7;
        }

        .participant-name {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .participant-id {
            text-align: center;
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .info-section {
            flex-grow: 1;
        }

        .info-item {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .info-item i {
            width: 20px;
            margin-right: 10px;
            opacity: 0.8;
        }

        .info-label {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
        }

        .barcode-section {
            text-align: center;
            margin-top: auto;
        }

        .barcode-container {
            background: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .validity {
            text-align: center;
            font-size: 12px;
            opacity: 0.8;
        }

        .terms-section {
            margin-top: 20px;
        }

        .terms-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .terms-content {
            font-size: 10px;
            line-height: 1.4;
            opacity: 0.9;
            text-align: justify;
        }

        .contact-info {
            margin-top: auto;
            text-align: center;
        }

        .contact-item {
            margin-bottom: 8px;
            font-size: 12px;
        }

        .contact-item i {
            margin-right: 5px;
        }

        .action-buttons {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin: 0 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        /* Print Optimization */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            
            body {
                margin: 0;
                padding: 20px;
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
                margin-bottom: 20px;
            }

            .id-card {
                perspective: none;
                height: auto;
            }

            .id-card-inner {
                display: flex;
                flex-direction: column;
                gap: 20px;
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
                        <div class="brand-name">BRAND NAME</div>
                        <div class="brand-subtitle">INTERNSHIP PROGRAM</div>
                    </div>

                    <div class="photo-section">
                        <div class="photo-placeholder">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="participant-name"><?php echo e($participant->name); ?></div>
                        <div class="participant-id">ID: <?php echo e($participant->barcode_id); ?></div>
                    </div>

                    <div class="info-section">
                        <div class="info-item">
                            <i class="bi bi-person-badge"></i>
                            <div>
                                <div class="info-label">NIM / ID</div>
                                <div class="info-value"><?php echo e($participant->nim); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-building"></i>
                            <div>
                                <div class="info-label">Institution</div>
                                <div class="info-value"><?php echo e($participant->institution); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-tag"></i>
                            <div>
                                <div class="info-label">Program</div>
                                <div class="info-value"><?php echo e($participant->program_type); ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <div class="info-label">Email</div>
                                <div class="info-value"><?php echo e($participant->email); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="barcode-section">
                        <div class="barcode-container">
                            <svg id="barcode-front"></svg>
                        </div>
                        <div class="validity">VALID THRU <?php echo e(date('m/y', strtotime('+1 year'))); ?></div>
                    </div>
                </div>

                <!-- Back Side -->
                <div class="id-card-back">
                    <div class="brand-header">
                        <div class="brand-name">BRAND NAME</div>
                        <div class="brand-subtitle">TERMS & CONDITIONS</div>
                    </div>

                    <div class="terms-section">
                        <div class="terms-title">ID: <?php echo e($participant->barcode_id); ?></div>
                        <div class="terms-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis elit sapien, 
                            convallis vell enim sit amet. This card is property of Brand Name and must 
                            be returned upon termination of program. Loss or theft must be reported 
                            immediately.
                        </div>
                    </div>

                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            Phone: +62 812-3456-7890
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            Email: info@brandname.com
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-globe"></i>
                            Website: www.brandname.com
                        </div>
                    </div>

                    <div class="barcode-section">
                        <div class="barcode-container">
                            <img src="<?php echo e($participant->qr_code_url); ?>" alt="QR Code <?php echo e($participant->barcode_id); ?>" style="width: 120px; height: 120px;">
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
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <script>
        // Generate barcode for front side
        JsBarcode("#barcode-front", "<?php echo e($participant->barcode_id); ?>", {
            format: "CODE128",
            width: 2,
            height: 50,
            displayValue: false,
            background: "#ffffff",
            lineColor: "#333333"
        });

        // Generate barcode for back side
        JsBarcode("#barcode-back", "<?php echo e($participant->barcode_id); ?>", {
            format: "CODE128",
            width: 2,
            height: 40,
            displayValue: false,
            background: "#ffffff",
            lineColor: "#333333"
        });

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
</html><?php /**PATH C:\Users\ASVS\Desktop\lisa-absensi\absensi-digital\resources\views\participants\id-card-print.blade.php ENDPATH**/ ?>