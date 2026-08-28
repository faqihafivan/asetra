<table>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Tanggal Pengeluaran</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Kode Barang</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Nama Barang</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Kategori</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Lokasi Asal</th>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: right;">Jumlah Keluar</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Satuan</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Tujuan Distribusi</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Penanggung Jawab (PIC)</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Operator Pencatat</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($exits as $index => $exit)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ date('Y-m-d', strtotime($exit->date)) }}</td>
                <td>{{ $exit->item->code }}</td>
                <td>{{ $exit->item->name }}</td>
                <td>{{ $exit->item->category->name }}</td>
                <td>{{ $exit->item->location->name }}</td>
                <td style="text-align: right;">{{ $exit->quantity }}</td>
                <td>{{ $exit->item->unit }}</td>
                <td>{{ $exit->destination }}</td>
                <td>{{ $exit->pic }}</td>
                <td>{{ $exit->creator->name }}</td>
                <td>{{ $exit->description ?: '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
