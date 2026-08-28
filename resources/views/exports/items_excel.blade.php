<table>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Kode Barang</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Nama Barang</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Kategori</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Lokasi Ruangan</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Merk / Brand</th>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: right;">Stok</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Satuan</th>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: right;">Minimal Stok</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Status</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Spesifikasi</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->location->name }}</td>
                <td>{{ $item->brand ?: '-' }}</td>
                <td style="text-align: right;">{{ $item->stock }}</td>
                <td>{{ $item->unit }}</td>
                <td style="text-align: right;">{{ $item->min_stock }}</td>
                <td style="color: {{ $item->isStockLow() ? '#dc2626' : '#16a34a' }}; font-weight: bold;">
                    {{ $item->isStockLow() ? 'Stok Menipis' : 'Stok Aman' }}
                </td>
                <td>{{ $item->specification ?: '-' }}</td>
                <td>{{ $item->description ?: '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
