<table>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #dbeafe;">No Pengadaan</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Tanggal</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Supplier</th>
            <th style="font-weight: bold; background-color: #dbeafe;">No Nota / Kwitansi</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Sumber Dana</th>
            <th style="font-weight: bold; background-color: #dbeafe; text-align: right;">Total Belanja (Rp)</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Pencatat / Operator</th>
            <th style="font-weight: bold; background-color: #dbeafe;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procurements as $index => $proc)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $proc->number }}</td>
                <td>{{ date('Y-m-d', strtotime($proc->date)) }}</td>
                <td>{{ $proc->supplier->name }}</td>
                <td>{{ $proc->invoice_number }}</td>
                <td>{{ $proc->fundingSource->name }}</td>
                <td style="text-align: right;">{{ $proc->total_price }}</td>
                <td>{{ $proc->creator->name }}</td>
                <td>{{ $proc->description ?: '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
