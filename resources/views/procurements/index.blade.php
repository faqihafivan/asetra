<x-app-layout>
    @section('page_title', 'Pengadaan Barang')

    <div class="space-y-6">
        <!-- Breadcrumbs & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Transaksi / Pengadaan</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Daftar Pengadaan Barang</h1>
            </div>
            <div>
                <a href="{{ route('procurements.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Catat Pengadaan Baru
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Search & Filters -->
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <form action="{{ route('procurements.index') }}" method="GET" class="flex items-center">
                    <div class="relative w-full max-w-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="No pengadaan, nota, supplier..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('procurements.index') }}" class="ml-2 px-3 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Reset</a>
                    @endif
                    <button type="submit" class="ml-2 inline-flex items-center px-3.5 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">No</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No Pengadaan</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Supplier</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No Nota</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sumber Dana</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Belanja</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pencatat</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($procurements as $index => $proc)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $procurements->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('procurements.show', $proc) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $proc->number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ date('d M Y', strtotime($proc->date)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $proc->supplier->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $proc->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $proc->fundingSource->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($proc->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $proc->creator->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center">
                                        <a href="{{ route('procurements.show', $proc) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors" title="Detail">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-40 h-auto opacity-70">
                                            <rect x="30" y="60" width="140" height="80" rx="8" fill="#ecfdf5" class="dark:fill-emerald-950/30"/>
                                            <rect x="30" y="60" width="140" height="80" rx="8" stroke="#a7f3d0" stroke-width="1.5" class="dark:stroke-emerald-800/50"/>
                                            <rect x="45" y="78" width="110" height="8" rx="4" fill="#a7f3d0" class="dark:fill-emerald-800/40"/>
                                            <rect x="45" y="93" width="80" height="8" rx="4" fill="#d1fae5" class="dark:fill-emerald-900/40"/>
                                            <rect x="45" y="108" width="95" height="8" rx="4" fill="#d1fae5" class="dark:fill-emerald-900/40"/>
                                            <circle cx="100" cy="32" r="22" fill="#d1fae5" class="dark:fill-emerald-900/50"/>
                                            <path d="M89 32 l7 8 l16 -16" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum Ada Pengadaan</p>
                                            <p class="text-xs text-gray-400 mt-1">Catat transaksi pengadaan barang pertama Anda</p>
                                        </div>
                                        <a href="{{ route('procurements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Catat Pengadaan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($procurements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $procurements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
