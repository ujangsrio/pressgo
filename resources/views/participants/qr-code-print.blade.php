<!DOCTYPE html>
<html>
<head>
    <title>QR Code - {{ $participant->name }}</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            padding: 0;
            margin: 0;
            background: white;
        }
        .qr-container { 
            border: 2px solid #333;
            padding: 25px;
            margin: 20px auto;
            max-width: 400px;
            background: white;
            page-break-inside: avoid;
        }
        .participant-info {
            margin: 15px 0;
            text-align: center;
        }
        .participant-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        .qr-text {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 15px 0;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px dashed #dee2e6;
        }
        .details {
            font-size: 12px;
            color: #666;
            margin-top: 15px;
            line-height: 1.4;
        }
        .qr-image {
            margin: 15px 0;
            padding: 10px;
            background: white;
            border-radius: 8px;
            display: inline-block;
        }
        @media print {
            body { padding: 0; margin: 0; }
            .qr-container { 
                border: 2px solid #000; 
                box-shadow: none; 
                margin: 0;
                padding: 20px;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <div class="participant-info">
            <div class="participant-name">{{ $participant->name }}</div>
            <div class="qr-text">{{ $participant->barcode_id }}</div>
        </div>
        
        <div class="qr-image">
            <img src="{{ $participant->qr_code_url }}" alt="QR Code {{ $participant->barcode_id }}" style="width: 250px; height: 250px;">
        </div>
        
        <div class="details">
            <div><strong>NIM:</strong> {{ $participant->nim }}</div>
            <div><strong>Institusi:</strong> {{ $participant->institution }}</div>
            <div><strong>Program:</strong> {{ $participant->program_type }}</div>
            <div><strong>Dibuat:</strong> {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            🖨️ Print QR Code
        </button>
        <button onclick="window.close()" style="padding: 12px 24px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Auto print setelah load (opsional)
        window.addEventListener('load', function() {
            // window.print(); // Uncomment untuk auto print
        });
    </script>
</body>
</html>