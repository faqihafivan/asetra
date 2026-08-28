<x-app-layout>
    @section('page_title', 'Data Barang / Aset')

    <div class="space-y-6">
        <!-- Breadcrumbs & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Gudang / Barang</p>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Daftar Barang & Inventaris</h1>
            </div>
            <div>
                <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('items.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Cari Barang</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode, nama, merk..." class="block w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Kategori</label>
                        <select name="category_id" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Lokasi Penyimpanan</label>
                        <select name="location_id" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock Alerts & Actions -->
                    <div class="flex items-end space-x-2">
                        <!-- Low Stock Toggle -->
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Filter Stok</label>
                            <label class="relative inline-flex items-center cursor-pointer py-1.5 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 select-none w-full justify-between">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Stok Menipis</span>
                                <input type="checkbox" name="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[6px] after:right-[16px] peer-checked:after:right-[6px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit and Reset Buttons -->
                <div class="flex justify-end items-center space-x-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                    @if(request()->anyFilled(['search', 'category_id', 'location_id', 'low_stock']))
                        <a href="{{ route('items.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24">Foto</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Barang</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Merk</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors {{ $item->isStockLow() ? 'bg-red-50/20 dark:bg-red-950/5' : '' }}">
                                <!-- Photo -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->photo_path)
                                        <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="h-10 w-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600 shadow-sm">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                            <!-- Heroicon: Photograph -->
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <!-- Code -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600 dark:text-gray-400">
                                    {{ $item->code }}
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('items.show', $item) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $item->category->name }}
                                </td>

                                <!-- Brand -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $item->brand ?: '-' }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="font-bold {{ $item->isStockLow() ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                            {{ $item->stock }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $item->unit }}
                                        </span>
                                        
                                        @if($item->isStockLow())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400" title="Minimal stok: {{ $item->min_stock }}">
                                                Stok Limit
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $item->location->name }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2">
                                        <a href="{{ route('items.show', $item) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors" title="Detail">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('items.print-label', $item) }}" target="_blank" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 p-1.5 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition-colors" title="Cetak KIR (Stiker)">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('items.edit', $item) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-colors" title="Ubah">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors" title="Hapus">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-40 h-auto opacity-70">
                                            <rect x="40" y="55" width="120" height="85" rx="8" fill="#eff6ff" class="dark:fill-blue-950/30"/>
                                            <rect x="40" y="55" width="120" height="85" rx="8" stroke="#bfdbfe" stroke-width="1.5" class="dark:stroke-blue-800/50"/>
                                            <rect x="55" y="75" width="40" height="30" rx="4" fill="#dbeafe" class="dark:fill-blue-900/40"/>
                                            <rect x="105" y="75" width="40" height="30" rx="4" fill="#dbeafe" class="dark:fill-blue-900/40"/>
                                            <rect x="55" y="115" width="90" height="10" rx="3" fill="#bfdbfe" class="dark:fill-blue-800/40"/>
                                            <circle cx="100" cy="35" r="20" fill="#dbeafe" class="dark:fill-blue-900/50"/>
                                            <path d="M92 35 l5 6 l12 -12" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                            <circle cx="148" cy="115" r="28" fill="#fee2e2" class="dark:fill-rose-950/40"/>
                                            <path d="M141 108 l14 14 M155 108 l-14 14" stroke="#ef4444" stroke-width="3" stroke-linecap="round" fill="none"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum Ada Barang</p>
                                            <p class="text-xs text-gray-400 mt-1">Tambahkan barang baru untuk mulai mengelola inventaris Anda</p>
                                        </div>
                                        <a href="{{ route('items.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Barang Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($items->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
