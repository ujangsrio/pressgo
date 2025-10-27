<!DOCTYPE html>
<html>
<head>
    <title>Barcode - {{ $participant->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            padding: 0;
            margin: 0;
            background: white;
        }
        .barcode-container { 
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
        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
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
        .barcode-svg {
            margin: 15px 0;
        }
        @media print {
            body { padding: 0; margin: 0; }
            .barcode-container { 
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
    <div class="barcode-container">
        <div class="participant-info">
            <div class="participant-name">{{ $participant->name }}</div>
            <div class="barcode-text">{{ $participant->barcode_id }}</div>
        </div>
        
        <svg class="barcode-svg" id="barcode"></svg>
        
        <div class="details">
            <div><strong>NIM / NISN:</strong> {{ $participant->nim }}</div>
            <div><strong>Institusi:</strong> {{ $participant->institution }}</div>
            <div><strong>Program:</strong> {{ $participant->program_type }}</div>
            <div><strong>Dibuat:</strong> {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            🖨️ Print Barcode
        </button>
        <button onclick="window.close()" style="padding: 12px 24px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Generate barcode
        JsBarcode("#barcode", "{{ $participant->barcode_id }}", {
            format: "CODE128",
            width: 2.5,
            height: 80,
            displayValue: false,
            background: "#ffffff",
            lineColor: "#000000",
            margin: 10
        });

        // Auto print setelah load
        window.addEventListener('load', function() {
            // window.print(); // Uncomment untuk auto print
        });
    </script>
</body>
</html>