<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Barang Keluar</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        .meta-info {
            margin-bottom: 15px;
            font-size: 10px;
        }
        .meta-info table {
            width: 100%;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            color: #1f2937;
        }
        table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 5px 8px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ASETRA - Laporan Transaksi Barang Keluar</h1>
        <p>Sistem Informasi Manajemen Aset & Inventaris Sekolah</p>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td>
                    <strong>Tanggal Cetak:</strong> {{ $date }}<br>
                    @if(isset($filter['start_date']) || isset($filter['end_date']))
                        <strong>Periode:</strong> {{ $filter['start_date'] ?: '-' }} s.d. {{ $filter['end_date'] ?: '-' }}
                    @endif
                </td>
                <td style="text-align: right; vertical-align: top;"><strong>Format:</strong> PDF Landscape (A4)</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 12%;">Kode Barang</th>
                <th style="width: 23%;">Nama Barang</th>
                <th style="width: 10%; text-align: right;">Qty Keluar</th>
                <th style="width: 18%;">Tujuan Distribusi</th>
                <th style="width: 13%;">Penanggung Jawab</th>
                <th style="width: 10%;">Operator</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @forelse($data as $index => $exit)
                @php $totalQty += $exit->quantity; @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($exit->date)) }}</td>
                    <td style="font-family: monospace; font-size: 10px;">{{ $exit->item->code }}</td>
                    <td style="font-weight: bold;">{{ $exit->item->name }}</td>
                    <td style="text-align: right; font-weight: bold; color: #dc2626;">-{{ $exit->quantity }} {{ $exit->item->unit }}</td>
                    <td>{{ $exit->destination }}</td>
                    <td>{{ $exit->pic }}</td>
                    <td>{{ $exit->creator->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999;">Tidak ada data pengeluaran barang.</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
            <tfoot>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" style="text-align: right; border-top: 2px solid #d1d5db; padding: 8px;">Total Barang Keluar:</td>
                    <td style="text-align: right; border-top: 2px solid #d1d5db; padding: 8px; color: #dc2626;">{{ $totalQty }} Item</td>
                    <td colspan="3" style="border-top: 2px solid #d1d5db;"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Dicetak otomatis oleh ASETRA Asset Management System - Halaman 1 dari 1
    </div>
</body>
</html>
