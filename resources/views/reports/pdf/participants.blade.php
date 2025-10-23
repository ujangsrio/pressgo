<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peserta</title>
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
        .summary-card.magang {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        .summary-card.pkl {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        .summary-card.attendance {
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
        .program-magang {
            background-color: #d4edda;
            color: #155724;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
        }
        .program-pkl {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
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
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PESERTA</h1>
        <div class="company-info">
            <strong>SISTEM ABSENSI DIGITAL</strong><br>
            MisnTV - Mav Entertainment Corporation
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card total">
            <h3>{{ $stats['total_participants'] }}</h3>
            <p>Total Peserta</p>
        </div>
        <div class="summary-card magang">
            <h3>{{ $stats['magang_count'] }}</h3>
            <p>Mahasiswa Magang</p>
        </div>
        <div class="summary-card pkl">
            <h3>{{ $stats['pkl_count'] }}</h3>
            <p>Siswa PKL</p>
        </div>
        <div class="summary-card attendance">
            <h3>{{ $stats['total_attendance'] }}</h3>
            <p>Total Absensi</p>
        </div>
    </div>

    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        @if($filters['program_type'] && $filters['program_type'] !== 'all')
            <strong>Program:</strong> {{ $filters['program_type'] }}
        @else
            <strong>Program:</strong> Semua Program
        @endif
        @if($filters['institution'])
            | <strong>Institusi:</strong> {{ $filters['institution'] }}
        @else
            | <strong>Institusi:</strong> Semua Institusi
        @endif
        | <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">NO</th>
                <th>NAMA PESERTA</th>
                <th>EMAIL</th>
                <th style="width: 100px;">NIM</th>
                <th>INSTITUSI</th>
                <th style="width: 70px;">PROGRAM</th>
                <th style="width: 80px;">BARCODE ID</th>
                <th style="width: 50px;">TOTAL<br>ABSENSI</th>
                <th style="width: 50px;">TEPAT<br>WAKTU</th>
                <th style="width: 50px;">TERLAMBAT</th>
                <th style="width: 80px;">TANGGAL<br>DAFTAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $index => $participant)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-left">{{ $participant->name }}</td>
                <td class="text-left">{{ $participant->email }}</td>
                <td class="text-center">{{ $participant->nim }}</td>
                <td class="text-left">{{ $participant->institution }}</td>
                <td class="text-center">
                    @if($participant->program_type === 'Magang')
                        <span class="program-magang">MAGANG</span>
                    @else
                        <span class="program-pkl">PKL</span>
                    @endif
                </td>
                <td class="text-center">{{ $participant->barcode_id }}</td>
                <td class="text-center">{{ $participant->total_attendance }}</td>
                <td class="text-center" style="color: #28a745; font-weight: bold;">{{ $participant->present_count }}</td>
                <td class="text-center" style="color: #ffc107; font-weight: bold;">{{ $participant->late_count }}</td>
                <td class="text-center nowrap">{{ $participant->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>Dicetak oleh: Sistem Absensi Digital | {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>
    </div>
</body>
</html>