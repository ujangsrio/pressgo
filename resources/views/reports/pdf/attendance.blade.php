<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        @page {
            margin: 20px;
            size: A4 landscape;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #007bff;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 15px;
            color: #555;
        }
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        .summary-card {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }
        .summary-card.total {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .summary-card.present {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        .summary-card.late {
            background: linear-gradient(135deg, #ffc107, #e0a800);
        }
        .summary-card h3 {
            margin: 0;
            font-size: 20px;
        }
        .summary-card p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .filter-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #0056b3;
            font-size: 11px;
            font-family: Arial, sans-serif;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-present {
            background-color: #d4edda;
            color: #155724;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }
        .status-late {
            background-color: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA ABSENSI</h1>
        <div class="company-info">
            <strong>SISTEM ABSENSI DIGITAL</strong><br>
            MisnTV - Mav Entertainment Corporation
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card total">
            <h3>{{ $stats['total_records'] }}</h3>
            <p>Total Absensi</p>
        </div>
        <div class="summary-card present">
            <h3>{{ $stats['present_count'] }}</h3>
            <p>Tepat Waktu</p>
        </div>
        <div class="summary-card late">
            <h3>{{ $stats['late_count'] }}</h3>
            <p>Terlambat</p>
        </div>
    </div>

    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        <strong>Periode:</strong> {{ $stats['date_range'] }}
        @if($filters['participant_id'])
            | <strong>Peserta:</strong> {{ \App\Models\Participant::find($filters['participant_id'])->name ?? 'Semua' }}
        @endif
        @if($filters['status'] && $filters['status'] !== 'all')
            | <strong>Status:</strong> {{ $filters['status'] == 'present' ? 'Tepat Waktu' : 'Terlambat' }}
        @endif
        | <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">NO</th>
                <th style="width: 80px;">TANGGAL</th>
                <th>NAMA PESERTA</th>
                <th style="width: 100px;">NIM</th>
                <th>INSTITUSI</th>
                <th style="width: 70px;">PROGRAM</th>
                <th style="width: 70px;">CHECK IN</th>
                <th style="width: 70px;">CHECK OUT</th>
                <th style="width: 80px;">STATUS</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $attendance)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center nowrap">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                <td class="text-left">{{ $attendance->participant->name }}</td>
                <td class="text-center">{{ $attendance->participant->nim }}</td>
                <td class="text-left">{{ $attendance->participant->institution }}</td>
                <td class="text-center">{{ $attendance->participant->program_type }}</td>
                <td class="text-center nowrap">{{ $attendance->check_in }}</td>
                <td class="text-center nowrap">{{ $attendance->check_out ?? '-' }}</td>
                <td class="text-center">
                    @if($attendance->status === 'present')
                        <span class="status-present">TEPAT WAKTU</span>
                    @else
                        <span class="status-late">TERLAMBAT</span>
                    @endif
                </td>
                <td class="text-left">{{ $attendance->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>Dicetak oleh: Sistem Absensi Digital | {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>
    </div>
</body>
</html>