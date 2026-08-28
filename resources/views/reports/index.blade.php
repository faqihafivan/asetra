<x-app-layout>
    @section('page_title', 'Laporan & Ekspor')

    <div class="space-y-6">
        <!-- Header -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Analitik / Laporan</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Laporan & Ekspor Data</h1>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <a href="{{ route('reports.index', ['type' => 'stock']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm {{ $type === 'stock' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                    Stok & Persediaan Barang
                </a>
                <a href="{{ route('reports.index', ['type' => 'procurement']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm {{ $type === 'procurement' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                    Transaksi Pengadaan (Masuk)
                </a>
                <a href="{{ route('reports.index', ['type' => 'exit']) }}" 
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm {{ $type === 'exit' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                    Transaksi Barang Keluar
                </a>
            </nav>
        </div>

        <!-- Filter Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
            <form id="filterForm" method="GET" action="{{ route('reports.index') }}" class="space-y-4">
                <input type="hidden" name="type" value="{{ $type }}">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- DATE RANGE (For Procurement and Exit only) -->
                    @if($type === 'procurement' || $type === 'exit')
                        <div>
                            <label for="start_date" class="block text-xs font-semibold text-gray-500 uppercase">Mulai Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="end_date" class="block text-xs font-semibold text-gray-500 uppercase">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    @endif

                    <!-- CATEGORY FILTER (For Stock and Exit) -->
                    @if($type === 'stock' || $type === 'exit')
                        <div>
                            <label for="category_id" class="block text-xs font-semibold text-gray-500 uppercase">Kategori</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- LOCATION FILTER (For Stock and Exit) -->
                    @if($type === 'stock' || $type === 'exit')
                        <div>
                            <label for="location_id" class="block text-xs font-semibold text-gray-500 uppercase">Lokasi Ruangan</label>
                            <select name="location_id" id="location_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- SUPPLIER FILTER (For Procurement only) -->
                    @if($type === 'procurement')
                        <div>
                            <label for="supplier_id" class="block text-xs font-semibold text-gray-500 uppercase">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Supplier</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- FUNDING SOURCE FILTER (For Procurement only) -->
                    @if($type === 'procurement')
                        <div>
                            <label for="funding_source_id" class="block text-xs font-semibold text-gray-500 uppercase">Sumber Dana</label>
                            <select name="funding_source_id" id="funding_source_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Sumber Dana</option>
                                @foreach($fundingSources as $fs)
                                    <option value="{{ $fs->id }}" {{ request('funding_source_id') == $fs->id ? 'selected' : '' }}>{{ $fs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- OPERATOR FILTER (For Procurement and Exit) -->
                    @if($type === 'procurement' || $type === 'exit')
                        <div>
                            <label for="operator_id" class="block text-xs font-semibold text-gray-500 uppercase">Operator / Pencatat</label>
                            <select name="operator_id" id="operator_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Operator</option>
                                @foreach($operators as $op)
                                    <option value="{{ $op->id }}" {{ request('operator_id') == $op->id ? 'selected' : '' }}>{{ $op->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Form Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <span class="text-xs text-gray-400">Total data ditemukan: <strong class="text-gray-700 dark:text-gray-300">{{ count($data) }} data</strong></span>
                    
                    <div class="flex items-center space-x-2 self-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                            Filter
                        </button>
                        <button type="button" onclick="exportData('excel')" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Excel
                        </button>
                        <button type="button" onclick="exportData('pdf')" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Table Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">Pratinjau Hasil Laporan</h3>
            </div>

            <!-- Conditional Table Preview -->
            <div class="overflow-x-auto">
                @if($type === 'stock')
                    <!-- STOCKS PREVIEW -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Barang</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Merk / Brand</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-6 py-3 class text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse($data as $item)
                                <tr class="text-sm">
                                    <td class="px-6 py-3 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">{{ $item->code }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">{{ $item->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $item->category->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $item->location->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $item->brand ?: '-' }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap font-bold text-gray-900 dark:text-white">{{ $item->stock }} {{ $item->unit }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $item->isStockLow() ? 'bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400' }}">
                                            {{ $item->isStockLow() ? 'Menipis' : 'Aman' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                @elseif($type === 'procurement')
                    <!-- PROCUREMENT PREVIEW -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No Pengadaan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Supplier</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No Nota</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sumber Dana</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Belanja</th>
                                <th scope="col" class="px-6 py-3 class text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Operator</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse($data as $proc)
                                <tr class="text-sm">
                                    <td class="px-6 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">{{ $proc->number }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-750 dark:text-gray-300">{{ date('d/m/Y', strtotime($proc->date)) }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $proc->supplier->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $proc->invoice_number }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $proc->fundingSource->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap font-bold text-gray-900 dark:text-white">Rp {{ number_format($proc->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $proc->creator->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                @else
                    <!-- EXITS PREVIEW -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang / Aset</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Keluar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tujuan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">PJ (PIC)</th>
                                <th scope="col" class="px-6 py-3 class text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Operator</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse($data as $exit)
                                <tr class="text-sm">
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-750 dark:text-gray-300">{{ date('d/m/Y', strtotime($exit->date)) }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                        {{ $exit->item->name }}
                                        <span class="block text-xxs font-mono text-gray-400">{{ $exit->item->code }}</span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $exit->item->category->name }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap font-bold text-red-600 dark:text-red-400">-{{ $exit->quantity }} {{ $exit->item->unit }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $exit->destination }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $exit->pic }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $exit->creator->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Action Helper Script -->
    <script>
        function exportData(format) {
            const form = document.getElementById('filterForm');
            const originalAction = form.action;
            
            if (format === 'pdf') {
                form.action = "{{ route('reports.export.pdf') }}";
            } else {
                form.action = "{{ route('reports.export.excel') }}";
            }
            
            form.submit();
            
            // Restore form target action for normal filtering
            form.action = originalAction;
        }
    </script>
</x-app-layout>
