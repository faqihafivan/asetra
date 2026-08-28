<x-app-layout>
    @section('page_title', 'Dashboard')

    <div class="space-y-6">

        {{-- ================================================================== --}}
        {{-- HERO WELCOME BANNER --}}
        {{-- ================================================================== --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 p-6 md:p-8 shadow-xl shadow-blue-200/40 dark:shadow-blue-950/30">
            {{-- Background dots --}}
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 22px 22px;"></div>
            {{-- Blob deko --}}
            <div class="absolute -top-10 -right-10 w-56 h-56 bg-indigo-500/30 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-1/3 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                {{-- Teks Sambutan --}}
                <div class="text-white">
                    <p class="text-blue-200 text-sm font-medium mb-1">
                        {{ date('l, d F Y') }}
                    </p>
                    <h1 class="text-2xl md:text-3xl font-extrabold leading-tight mb-2 drop-shadow">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 text-sm max-w-md">
                        Berikut adalah ringkasan sistem manajemen aset &amp; inventaris ASETRA hari ini.
                    </p>
                    {{-- Quick Actions --}}
                    <div class="flex flex-wrap gap-2.5 mt-5">
                        <a href="{{ route('procurements.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-700 font-bold text-xs rounded-xl shadow hover:bg-blue-50 transition-all duration-150 active:scale-95">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Catat Pengadaan
                        </a>
                        <a href="{{ route('item_exits.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 border border-white/30 text-white font-bold text-xs rounded-xl hover:bg-white/25 transition-all duration-150 active:scale-95 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Catat Barang Keluar
                        </a>
                        <a href="{{ route('items.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 border border-white/30 text-white font-bold text-xs rounded-xl hover:bg-white/25 transition-all duration-150 active:scale-95 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Lihat Data Barang
                        </a>
                    </div>
                </div>

                {{-- SVG Ilustrasi --}}
                <div class="hidden md:flex shrink-0 items-center justify-center">
                    <svg viewBox="0 0 200 170" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-44 h-auto drop-shadow-xl opacity-90" style="animation: floating 5s ease-in-out infinite;">
                        <style>@keyframes floating{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}</style>
                        <!-- Box 1 (bawah kiri) -->
                        <rect x="15" y="105" width="54" height="48" rx="5" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.35)" stroke-width="1.5"/>
                        <line x1="42" y1="105" x2="42" y2="153" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <line x1="15" y1="120" x2="69" y2="120" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <!-- Box 2 (tengah bawah) -->
                        <rect x="78" y="98" width="48" height="55" rx="5" fill="rgba(255,255,255,0.18)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <line x1="102" y1="98" x2="102" y2="153" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <polyline points="78,110 102,103 126,110" stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none"/>
                        <!-- Box 3 (kanan bawah) -->
                        <rect x="135" y="112" width="50" height="41" rx="5" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.3)" stroke-width="1.5"/>
                        <line x1="160" y1="112" x2="160" y2="153" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <!-- Rak atas -->
                        <rect x="10" y="40" width="74" height="52" rx="4" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.25)" stroke-width="1.2"/>
                        <rect x="15" y="46" width="28" height="22" rx="3" fill="rgba(255,255,255,0.15)"/>
                        <rect x="50" y="46" width="28" height="22" rx="3" fill="rgba(255,255,255,0.15)"/>
                        <rect x="15" y="74" width="28" height="13" rx="2" fill="rgba(255,255,255,0.1)"/>
                        <rect x="50" y="74" width="28" height="13" rx="2" fill="rgba(255,255,255,0.1)"/>
                        <!-- Chart bar -->
                        <rect x="100" y="55" width="88" height="72" rx="5" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
                        <rect x="112" y="95" width="12" height="22" rx="2" fill="rgba(255,255,255,0.4)"/>
                        <rect x="130" y="82" width="12" height="35" rx="2" fill="rgba(255,255,255,0.6)"/>
                        <rect x="148" y="72" width="12" height="45" rx="2" fill="rgba(255,255,255,0.8)"/>
                        <rect x="166" y="88" width="12" height="29" rx="2" fill="rgba(255,255,255,0.5)"/>
                        <!-- Tanda centang floating -->
                        <circle cx="144" cy="24" r="18" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <path d="M136 24 l5 6 l10 -12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <!-- Lantai -->
                        <line x1="5" y1="153" x2="195" y2="153" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- STAT CARDS — 4 Gradient Cards --}}
        {{-- ================================================================== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card 1: Total Barang --}}
            <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-8 translate-x-8 transition-transform duration-300 group-hover:scale-125"></div>
                <div class="relative z-10">
                    <div class="inline-flex p-2.5 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Barang</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalItems }}</p>
                    <a href="{{ route('items.index') }}" class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline mt-1 inline-block">Lihat semua →</a>
                </div>
            </div>

            {{-- Card 2: Pengadaan --}}
            <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-full -translate-y-8 translate-x-8 transition-transform duration-300 group-hover:scale-125"></div>
                <div class="relative z-10">
                    <div class="inline-flex p-2.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Pengadaan</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalProcurements }}</p>
                    <a href="{{ route('procurements.index') }}" class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold hover:underline mt-1 inline-block">Lihat semua →</a>
                </div>
            </div>

            {{-- Card 3: Barang Keluar --}}
            <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 dark:bg-amber-900/20 rounded-full -translate-y-8 translate-x-8 transition-transform duration-300 group-hover:scale-125"></div>
                <div class="relative z-10">
                    <div class="inline-flex p-2.5 bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Barang Keluar</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalItemExits }}</p>
                    <a href="{{ route('item_exits.index') }}" class="text-xs text-amber-600 dark:text-amber-400 font-semibold hover:underline mt-1 inline-block">Lihat semua →</a>
                </div>
            </div>

            {{-- Card 4: Nilai Persediaan --}}
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-5 shadow-lg shadow-blue-200/50 dark:shadow-blue-900/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-8 translate-x-8 transition-transform duration-300 group-hover:scale-125"></div>
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 14px 14px;"></div>
                <div class="relative z-10">
                    <div class="inline-flex p-2.5 bg-white/20 text-white rounded-xl mb-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider mb-1">Nilai Persediaan</p>
                    <p class="text-xl font-extrabold text-white leading-tight">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-200 mt-1">Total nilai stok aktif</p>
                </div>
            </div>

        </div>

        {{-- ================================================================== --}}
        {{-- CHARTS --}}
        {{-- ================================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Chart Pengadaan --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Statistik Pengadaan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Nilai pengadaan per bulan (tahun ini)</p>
                    </div>
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="procurementChart"></canvas>
                </div>
            </div>

            {{-- Chart Barang Keluar --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Volume Barang Keluar</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Jumlah barang keluar per bulan</p>
                    </div>
                    <div class="p-2 bg-amber-50 dark:bg-amber-900/30 rounded-lg">
                        <svg class="h-4 w-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="exitsChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- LOW STOCK + AKTIVITAS TERBARU --}}
        {{-- ================================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Stok Kritis --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1.5 bg-rose-100 dark:bg-rose-900/30 rounded-lg">
                            <svg class="h-4 w-4 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Peringatan Stok Menipis</h3>
                        @if($lowStockItems->isNotEmpty())
                            <span class="px-2 py-0.5 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 text-xs font-bold rounded-full">{{ $lowStockItems->count() }}</span>
                        @endif
                    </div>
                    <a href="{{ route('items.index', ['low_stock' => 1]) }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50/80 dark:bg-gray-700/30">
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok / Min</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($lowStockItems as $item)
                                <tr class="hover:bg-rose-50/30 dark:hover:bg-rose-950/10 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('items.show', $item) }}" class="hover:text-blue-600 hover:underline">{{ $item->name }}</a>
                                            </p>
                                            <p class="text-xs font-mono text-gray-400 mt-0.5">{{ $item->code }}</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-gray-400">{{ $item->location->name }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-rose-600 dark:text-rose-400">{{ $item->stock }}</span>
                                            <span class="text-gray-400">/</span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $item->min_stock }} {{ $item->unit }}</span>
                                        </div>
                                        {{-- Mini progress bar --}}
                                        <div class="mt-1.5 w-24 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-rose-500 rounded-full" style="width: {{ $item->min_stock > 0 ? min(100, round(($item->stock / $item->min_stock) * 100)) : 0 }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 text-xs font-bold rounded-full">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-pulse inline-block"></span>
                                            Kritis
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            {{-- SVG empty state --}}
                                            <svg viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-24 h-auto">
                                                <circle cx="60" cy="50" r="42" fill="#d1fae5" class="dark:fill-emerald-900/20"/>
                                                <path d="M40 52 l14 16 l28 -30" stroke="#059669" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-bold text-emerald-700 dark:text-emerald-400">Stok Aman!</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Semua barang di atas batas stok minimal</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                        <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                </div>

                <div class="px-5 py-4 overflow-y-auto max-h-72">
                    @forelse($activities as $act)
                        <div class="flex gap-3 {{ !$loop->last ? 'mb-4 pb-4 border-b border-gray-100 dark:border-gray-700' : '' }}">
                            <div class="shrink-0 mt-0.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-full {{ $act['type'] == 'procurement' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
                                    @if($act['type'] == 'procurement')
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    @else
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $act['title'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{ $act['description'] }}</p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="text-xs font-medium text-gray-400">{{ $act['user'] }}</span>
                                    <span class="text-gray-300 dark:text-gray-600">·</span>
                                    <span class="text-xs text-gray-400">{{ $act['time']->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 gap-3">
                            <svg viewBox="0 0 100 90" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-20 h-auto opacity-60">
                                <rect x="15" y="20" width="70" height="55" rx="6" fill="#e5e7eb" class="dark:fill-gray-700"/>
                                <rect x="25" y="32" width="35" height="5" rx="2.5" fill="#d1d5db" class="dark:fill-gray-600"/>
                                <rect x="25" y="43" width="50" height="5" rx="2.5" fill="#d1d5db" class="dark:fill-gray-600"/>
                                <rect x="25" y="54" width="40" height="5" rx="2.5" fill="#d1d5db" class="dark:fill-gray-600"/>
                            </svg>
                            <p class="text-xs text-gray-400 text-center">Belum ada aktivitas terekam</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const months = @json($months);

            // Pengadaan Chart
            new Chart(document.getElementById('procurementChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Nilai Pengadaan',
                        data: @json($procurementValues),
                        backgroundColor: 'rgba(37,99,235,0.85)',
                        hoverBackgroundColor: '#1d4ed8',
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: {
                        backgroundColor: 'rgba(17,24,39,0.9)', titleColor: '#f9fafb', bodyColor: '#d1d5db',
                        padding: 10, cornerRadius: 8,
                        callbacks: { label: function(c) {
                            let v = c.parsed.y;
                            if (v >= 1e6) return 'Rp ' + (v/1e6).toFixed(1) + ' Juta';
                            if (v >= 1e3) return 'Rp ' + (v/1e3).toFixed(0) + ' Ribu';
                            return 'Rp ' + v;
                        }}
                    }},
                    scales: {
                        x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 10 } } },
                        y: { grid: { color: gridColor }, border: { display: false },
                            ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 10 },
                                callback: function(v) {
                                    if (v >= 1e6) return 'Rp '+(v/1e6).toFixed(0)+'M';
                                    if (v >= 1e3) return 'Rp '+(v/1e3).toFixed(0)+'K';
                                    return v === 0 ? '0' : 'Rp '+v;
                                }
                            }
                        }
                    }
                }
            });

            // Exits Chart
            new Chart(document.getElementById('exitsChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Volume Keluar',
                        data: @json($exitValues),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.08)',
                        borderWidth: 2.5, tension: 0.4, fill: true,
                        pointBackgroundColor: '#f59e0b', pointRadius: 4, pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: {
                        backgroundColor: 'rgba(17,24,39,0.9)', titleColor: '#f9fafb', bodyColor: '#d1d5db',
                        padding: 10, cornerRadius: 8,
                    }},
                    scales: {
                        x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 10 } } },
                        y: { grid: { color: gridColor }, border: { display: false },
                            ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 10 }, stepSize: 5 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
