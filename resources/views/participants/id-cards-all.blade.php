<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All ID Cards</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            padding: 20px;
        }

        .id-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .id-card-dual {
            display: flex;
            gap: 10px;
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        .id-card-side {
            width: 350px;
            height: 500px;
            border-radius: 20px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .id-card-front {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .id-card-back {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
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
            text-align: center;
            margin: 30px 0;
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
            background: #007bff;
            color: white;
        }

        @media print {
            body {
                padding: 0;
            }
            
            .action-buttons {
                display: none;
            }
            
            .id-card-dual {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="action-buttons">
        <button class="btn" onclick="window.print()">
            <i class="bi bi-printer"></i> Print All ID Cards
        </button>
        <a href="{{ route('participants.index') }}" class="btn" style="background: #6c757d;">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="id-cards-grid">
        @foreach($participants as $participant)
        <div class="id-card-dual">
            <!-- Front Side -->
            <div class="id-card-side id-card-front">
                <div class="brand-header">
                    <div class="brand-name">BRAND NAME</div>
                    <div class="brand-subtitle">INTERNSHIP PROGRAM</div>
                </div>

                <div class="photo-section">
                    <div class="photo-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="participant-name">{{ $participant->name }}</div>
                    <div class="participant-id">ID: {{ $participant->barcode_id }}</div>
                </div>

                <div class="info-section">
                    <div class="info-item">
                        <i class="bi bi-person-badge"></i>
                        <div>
                            <div class="info-label">NIM / ID</div>
                            <div class="info-value">{{ $participant->nim }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-building"></i>
                        <div>
                            <div class="info-label">Institution</div>
                            <div class="info-value">{{ $participant->institution }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-tag"></i>
                        <div>
                            <div class="info-label">Program</div>
                            <div class="info-value">{{ $participant->program_type }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $participant->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="barcode-section">
                    <div class="barcode-container">
                        <svg class="barcode" data-barcode="{{ $participant->barcode_id }}"></svg>
                    </div>
                    <div class="validity">VALID THRU {{ date('m/y', strtotime('+1 year')) }}</div>
                </div>
            </div>

            <!-- Back Side -->
            <div class="id-card-side id-card-back">
                <div class="brand-header">
                    <div class="brand-name">BRAND NAME</div>
                    <div class="brand-subtitle">TERMS & CONDITIONS</div>
                </div>

                <div class="terms-section">
                    <div class="terms-title">ID: {{ $participant->barcode_id }}</div>
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
                        <svg class="barcode" data-barcode="{{ $participant->barcode_id }}"></svg>
                    </div>
                    <div class="validity">ISSUED: {{ date('m/y') }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        // Generate barcodes for all cards
        document.querySelectorAll('.barcode').forEach(barcodeElement => {
            const barcodeValue = barcodeElement.getAttribute('data-barcode');
            JsBarcode(barcodeElement, barcodeValue, {
                format: "CODE128",
                width: 2,
                height: 50,
                displayValue: false,
                background: "#ffffff",
                lineColor: "#333333"
            });
        });

        // Auto-print if needed
        // window.addEventListener('load', function() {
        //     window.print();
        // });
    </script>
</body>
</html>