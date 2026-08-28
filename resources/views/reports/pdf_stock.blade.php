<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok & Persediaan Barang</title>
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
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
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
        <h1>ASETRA - Laporan Stok & Persediaan Barang</h1>
        <p>Sistem Informasi Manajemen Aset & Inventaris Sekolah</p>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td><strong>Tanggal Cetak:</strong> {{ $date }}</td>
                <td style="text-align: right;"><strong>Format:</strong> PDF Landscape (A4)</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 12%;">Kode Barang</th>
                <th style="width: 25%;">Nama Barang</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;">Lokasi Ruangan</th>
                <th style="width: 12%;">Merk / Brand</th>
                <th style="width: 8%; text-align: right;">Stok</th>
                <th style="width: 9%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-size: 10px;">{{ $item->code }}</td>
                    <td style="font-weight: bold;">{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->location->name }}</td>
                    <td>{{ $item->brand ?: '-' }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ $item->stock }} {{ $item->unit }}</td>
                    <td>
                        @if($item->isStockLow())
                            <span class="badge badge-danger">Menipis</span>
                        @else
                            <span class="badge badge-success">Aman</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999;">Tidak ada data persediaan barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh ASETRA Asset Management System - Halaman 1 dari 1
    </div>
</body>
</html>
