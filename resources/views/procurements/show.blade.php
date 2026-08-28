<x-app-layout>
    @section('page_title', 'Detail Pengadaan: ' . $procurement->number)

    <div class="space-y-6">
        <!-- Breadcrumbs & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Transaksi / Pengadaan / Detail</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Transaksi: {{ $procurement->number }}</h1>
            </div>
            <div>
                <a href="{{ route('procurements.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Kembali Ke Daftar
                </a>
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- LEFT COLUMN: HEADER INFO & INVOICE PHOTO -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Header Info Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase border-b border-gray-100 dark:border-gray-700 pb-2">Informasi Pengadaan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="block text-xs text-gray-400">Total Pembelian</span>
                            <span class="font-bold text-xl text-blue-600 dark:text-blue-400">Rp {{ number_format($procurement->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Tanggal Pengadaan</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ date('d M Y', strtotime($procurement->date)) }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Supplier</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $procurement->supplier->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Nomor Nota</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $procurement->invoice_number }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Sumber Dana</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $procurement->fundingSource->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Pencatat Transaksi (Operator)</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $procurement->creator->name }}</span>
                        </div>
                    </div>

                    @if($procurement->description)
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-3 text-sm">
                            <span class="block text-xs text-gray-400">Keterangan / Catatan</span>
                            <p class="text-gray-700 dark:text-gray-300 mt-1 whitespace-pre-line">{{ $procurement->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Invoice Photo Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Foto Nota / Bukti Pembelian</h3>
                    @if($procurement->invoice_photos && count($procurement->invoice_photos) > 0)
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($procurement->invoice_photos as $photo)
                                <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-750 flex items-center justify-center relative group">
                                    <a href="{{ asset($photo) }}" target="_blank" title="Klik untuk memperbesar" class="w-full">
                                        <img src="{{ asset($photo) }}" alt="Nota {{ $procurement->number }}" class="w-full h-32 object-cover hover:scale-105 transition-transform duration-200">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-750 flex items-center justify-center">
                            <div class="text-center p-8 text-gray-400">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="block text-xs mt-2">Tidak ada foto nota</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN: ITEMS TABLE (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items List Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Daftar Barang Yang Dibeli</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">Foto</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Barang</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-20">Qty</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga Satuan</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-32">Stiker KIR</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($procurement->items as $itemTrx)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors text-sm">
                                        <!-- Item Photo -->
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($itemTrx->photo_path)
                                                <img src="{{ asset($itemTrx->photo_path) }}" alt="{{ $itemTrx->item->name }}" class="h-10 w-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                            @elseif($itemTrx->item->photo_path)
                                                <img src="{{ asset($itemTrx->item->photo_path) }}" alt="{{ $itemTrx->item->name }}" class="h-10 w-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600 opacity-60" title="Foto Utama Barang">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Item Code -->
                                        <td class="px-4 py-3 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                                            {{ $itemTrx->item->code }}
                                        </td>

                                        <!-- Item Name -->
                                        <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('items.show', $itemTrx->item) }}" class="hover:text-blue-600 hover:underline">
                                                {{ $itemTrx->item->name }}
                                            </a>
                                        </td>

                                        <!-- Qty -->
                                        <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-800 dark:text-gray-200">
                                            {{ $itemTrx->quantity }} <span class="text-xs font-normal text-gray-500">{{ $itemTrx->item->unit }}</span>
                                        </td>

                                        <!-- Unit Price -->
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            Rp {{ number_format($itemTrx->unit_price, 0, ',', '.') }}
                                        </td>

                                        <!-- Subtotal -->
                                        <td class="px-4 py-3 whitespace-nowrap text-right font-bold text-gray-900 dark:text-white">
                                            Rp {{ number_format($itemTrx->subtotal, 0, ',', '.') }}
                                        </td>

                                        <!-- Print Sticker KIR -->
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <a href="{{ route('items.print-label', $itemTrx->item) }}?qty={{ $itemTrx->quantity }}" target="_blank" 
                                               class="inline-flex items-center px-2 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:hover:bg-emerald-950/60 dark:text-emerald-400 rounded-lg text-xs font-bold transition-colors"
                                               title="Cetak {{ $itemTrx->quantity }} Stiker Label KIR">
                                                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Cetak ({{ $itemTrx->quantity }})
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700/30 font-semibold text-gray-900 dark:text-white text-sm">
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-right">Total Belanja:</td>
                                    <td class="px-4 py-3 text-right font-bold text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($procurement->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
