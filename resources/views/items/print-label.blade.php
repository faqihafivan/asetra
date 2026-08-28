<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Stiker Label KIR - {{ $item->code }}</title>
    <style>
        @page {
            size: auto;
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 15px;
            background-color: #fff;
            color: #000;
        }
        .print-btn-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .btn {
            background-color: #2563eb;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-secondary {
            background-color: #4b5563;
        }
        .sticker-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .sticker {
            width: 80mm;
            height: 40mm;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 6px;
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            align-items: center;
            font-size: 11px;
            background-color: #fff;
            page-break-inside: avoid;
        }
        .qr-section {
            width: 26mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 1px dashed #000;
            padding-right: 6px;
            height: 100%;
            box-sizing: border-box;
        }
        .qr-image {
            width: 65px;
            height: 65px;
        }
        .app-title {
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
        .info-section {
            flex: 1;
            padding-left: 8px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-sizing: border-box;
        }
        .school-title {
            font-size: 9px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .item-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.2;
        }
        .item-code {
            font-size: 9px;
            font-family: monospace;
            background-color: #000;
            color: #fff;
            padding: 1px 4px;
            border-radius: 2px;
            display: inline-block;
            font-weight: bold;
        }
        .meta-text {
            font-size: 8px;
            color: #333;
            margin-top: auto;
            line-height: 1.3;
        }
        @media print {
            .print-btn-container {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="print-btn-container">
        <button class="btn" onclick="window.print()">Cetak Stiker</button>
        <button class="btn btn-secondary" onclick="window.close()">Tutup Halaman</button>
    </div>

    <div class="sticker-container">
        @for ($i = 0; $i < $quantity; $i++)
            <div class="sticker">
                <div class="qr-section">
                    <img class="qr-image" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('items.show', $item->id)) }}" alt="QR Code">
                    <div class="app-title">ASETRA</div>
                </div>
                <div class="info-section">
                    <div class="school-title">INVENTARIS SEKOLAH</div>
                    <div class="item-name">{{ $item->name }}</div>
                    <div>
                        <span class="item-code">{{ $item->code }}</span>
                    </div>
                    <div class="meta-text">
                        Kat: {{ $item->category->name }}<br>
                        Lok: {{ $item->location->name }}
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <script>
        // Auto-trigger browser print dialog on load after assets load
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 600);
        }
    </script>
</body>
</html>
