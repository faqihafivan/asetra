<x-app-layout>
    @section('page_title', 'Barang Keluar')

    <div class="space-y-6">
        <!-- Breadcrumbs & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Transaksi / Barang Keluar</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Daftar Pengeluaran Barang</h1>
            </div>
            <div>
                <a href="{{ route('item_exits.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Catat Barang Keluar
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Search & Filters -->
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <form action="{{ route('item_exits.index') }}" method="GET" class="flex items-center">
                    <div class="relative w-full max-w-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tujuan, PJ, nama barang..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('item_exits.index') }}" class="ml-2 px-3 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Reset</a>
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
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang / Aset</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Keluar</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tujuan Distribusi</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penanggung Jawab</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pencatat (Operator)</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($itemExits as $index => $exit)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $itemExits->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ date('d M Y', strtotime($exit->date)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('items.show', $exit->item) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $exit->item->name }}
                                    </a>
                                    <span class="block text-xxs font-mono text-gray-400 mt-0.5">{{ $exit->item->code }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 dark:text-red-400">
                                    -{{ $exit->quantity }} <span class="text-xs font-normal text-gray-500">{{ $exit->item->unit }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $exit->destination }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $exit->pic }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $exit->creator->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $exit->description ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-40 h-auto opacity-70">
                                            <rect x="35" y="55" width="130" height="85" rx="8" fill="#fffbeb" class="dark:fill-amber-950/30"/>
                                            <rect x="35" y="55" width="130" height="85" rx="8" stroke="#fde68a" stroke-width="1.5" class="dark:stroke-amber-700/50"/>
                                            <rect x="52" y="73" width="60" height="8" rx="4" fill="#fde68a" class="dark:fill-amber-700/40"/>
                                            <rect x="52" y="88" width="96" height="8" rx="4" fill="#fef3c7" class="dark:fill-amber-900/40"/>
                                            <rect x="52" y="103" width="75" height="8" rx="4" fill="#fef3c7" class="dark:fill-amber-900/40"/>
                                            <circle cx="100" cy="30" r="20" fill="#fef3c7" class="dark:fill-amber-900/50"/>
                                            <path d="M94 30 l6 6 l13 -13" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                            <path d="M150 130 l20 -10 M150 120 l20 10" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.5"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum Ada Barang Keluar</p>
                                            <p class="text-xs text-gray-400 mt-1">Catat distribusi atau pengeluaran barang pertama Anda</p>
                                        </div>
                                        <a href="{{ route('item_exits.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Catat Barang Keluar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($itemExits->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $itemExits->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
