<x-app-layout>
    @section('page_title', 'Detail Barang: ' . $item->code)

    <div class="space-y-6">
        <!-- Breadcrumbs & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Gudang / Barang / Detail</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $item->name }}</h1>
                <div class="flex items-center space-x-2 mt-2">
                    <span class="font-mono text-sm px-2.5 py-0.5 bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 rounded font-semibold">{{ $item->code }}</span>
                    <span class="px-2.5 py-0.5 rounded text-xs font-semibold {{ $item->isStockLow() ? 'bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400' }}">
                        {{ $item->isStockLow() ? 'Stok Menipis' : 'Stok Aman' }}
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Kembali
                </a>
                <a href="{{ route('items.print-label', $item) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-sm">
                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Label KIR
                </a>
                <a href="{{ route('items.edit', $item) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                    Ubah Barang
                </a>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- LEFT COLUMN: PHOTO & INFO (1/3 width) -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Photo Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Foto Barang</h3>
                    <div class="aspect-video w-full rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                        @if($item->photo_path)
                            <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center gap-2 p-6 text-gray-300 dark:text-gray-600">
                                <svg viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-20 h-auto">
                                    <rect x="10" y="20" width="100" height="70" rx="8" fill="currentColor" opacity="0.15"/>
                                    <rect x="10" y="20" width="100" height="70" rx="8" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                                    <circle cx="38" cy="42" r="8" fill="currentColor" opacity="0.4"/>
                                    <path d="M10 72 l25 -22 a4 4 0 0 1 5.5 0 l18 16 a4 4 0 0 0 5.5 0 l12 -10 l24 26" fill="currentColor" opacity="0.25"/>
                                    <circle cx="88" cy="35" r="10" fill="currentColor" opacity="0.15" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 2" opacity="0.4"/>
                                    <path d="M83 35 l4 5 l9 -9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.4" fill="none"/>
                                </svg>
                                <span class="text-xs font-medium opacity-60">Belum ada foto barang</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase border-b border-gray-100 dark:border-gray-700 pb-2">Informasi Barang</h3>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-xs text-gray-400">Stok Saat Ini</span>
                            <span class="font-bold text-lg text-gray-900 dark:text-white">{{ $item->stock }} {{ $item->unit }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Minimal Stok</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->min_stock }} {{ $item->unit }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Kategori</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->category->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Lokasi Penyimpanan</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->location->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Merk / Brand</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->brand ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Terdaftar Pada</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3 text-sm">
                        <span class="block text-xs text-gray-400">Spesifikasi</span>
                        <p class="text-gray-700 dark:text-gray-300 mt-1 whitespace-pre-line">{{ $item->specification ?: 'Tidak ada spesifikasi khusus.' }}</p>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3 text-sm">
                        <span class="block text-xs text-gray-400">Keterangan</span>
                        <p class="text-gray-700 dark:text-gray-300 mt-1 whitespace-pre-line">{{ $item->description ?: 'Tidak ada keterangan tambahan.' }}</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: CHART & HISTORY (2/3 width) -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Stock Graph Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Grafik Trend Pergerakan Stok</h3>
                    <div class="h-64 w-full relative">
                        <canvas id="stockHistoryChart"></canvas>
                    </div>
                </div>

                <!-- Purchase History Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Riwayat Pembelian / Pengadaan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Tgl Pengadaan</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">No. Pengadaan</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Supplier</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Sumber Dana</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse($purchaseHistory as $pi)
                                    <tr class="text-sm">
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ date('d/m/Y', strtotime($pi->procurement->date)) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                            {{ $pi->procurement->number }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $pi->procurement->supplier->name }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $pi->procurement->fundingSource->name }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-900 dark:text-white">
                                            +{{ $pi->quantity }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            Rp {{ number_format($pi->unit_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 text-xs">
                                            Belum ada riwayat pembelian untuk barang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $purchaseHistory->links() }}
                    </div>
                </div>

                <!-- Exit History Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Riwayat Barang Keluar / Distribusi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Tgl Keluar</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Tujuan</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Penanggung Jawab</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse($exitHistory as $eh)
                                    <tr class="text-sm">
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ date('d/m/Y', strtotime($eh->date)) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                            {{ $eh->destination }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $eh->pic }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap font-bold text-red-600 dark:text-red-400">
                                            -{{ $eh->quantity }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ $eh->description ?: '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 text-xs">
                                            Belum ada riwayat pengeluaran untuk barang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $exitHistory->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js Script Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('stockHistoryChart').getContext('2d');
            
            // Fetch chronological data passed from Controller
            const labels = @json($chartLabels);
            const values = @json($chartValues);

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
            const textColor = isDark ? '#9ca3af' : '#4b5563';

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Barang',
                        data: values,
                        borderColor: '#2563eb', // Blue-600
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#2563eb',
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Stok: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 10
                                },
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
