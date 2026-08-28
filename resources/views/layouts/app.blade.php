<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ASETRA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200"
          x-data="{ 
              sidebarOpen: false, 
              sidebarCollapsed: $persist(false).as('asetra-sidebar-collapsed'),
              mobileSidebarOpen: false 
          }">
        
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- SIDEBAR: DESKTOP -->
            <aside class="hidden md:flex flex-col flex-shrink-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out"
                   :class="sidebarCollapsed ? 'w-20' : 'w-64'">
                <!-- Sidebar Header -->
                <div class="flex items-center border-b border-gray-200 dark:border-gray-700 transition-all duration-300"
                     :class="sidebarCollapsed ? 'h-24 flex-col justify-center p-2 space-y-2' : 'h-16 justify-between px-4'">
                    <a href="{{ route('dashboard') }}" class="flex items-center transition-all duration-300"
                       :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                        <div class="p-1 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shrink-0">
                            <img src="{{ asset('logo.png') }}" class="h-7 w-7 object-contain" width="28" height="28" alt="ASETRA">
                        </div>
                        <span class="font-bold text-xl tracking-wider text-blue-600 dark:text-blue-400 transition-opacity duration-300"
                              :class="sidebarCollapsed ? 'hidden w-0' : 'block'">ASETRA</span>
                    </a>
                    
                    <!-- Collapse Button -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-1 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-all duration-300" :class="sidebarCollapsed ? 'mx-auto' : ''">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            <path x-show="sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Navigation Links -->
                <div class="flex-1 flex flex-col justify-between overflow-y-auto px-3 py-4 space-y-6">
                    <nav class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Dashboard">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Dashboard</span>
                        </a>

                        <!-- Master Data (Admin Only) -->
                        @if(Auth::user()->isAdmin())
                        <div x-data="{ masterOpen: $persist(false).as('asetra-master-open') }">
                            <button @click="masterOpen = !masterOpen" 
                                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors duration-200"
                                    :class="sidebarCollapsed ? 'justify-center' : ''"
                                    title="Data Master">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    <span class="ml-3 text-left transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Data Master</span>
                                </div>
                                <svg class="h-4 w-4 transform transition-transform duration-200" :class="[masterOpen ? 'rotate-180' : '', sidebarCollapsed ? 'hidden' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="masterOpen && !sidebarCollapsed" class="pl-8 pr-2 mt-1 space-y-1" x-cloak>
                                <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('categories.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Kategori</a>
                                <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('suppliers.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Supplier</a>
                                <a href="{{ route('locations.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('locations.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Lokasi / Ruangan</a>
                                <a href="{{ route('funding_sources.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('funding_sources.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Sumber Dana</a>
                            </div>
                        </div>
                        @endif

                        <!-- Barang / Item -->
                        <!-- Placeholder Route for Item -->
                        <a href="{{ route('items.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('items.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Data Barang">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Data Barang</span>
                        </a>

                        <!-- Transaksi Pengadaan -->
                        <!-- Placeholder Route -->
                        <a href="{{ route('procurements.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('procurements.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Pengadaan Barang">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Pengadaan (Masuk)</span>
                        </a>

                        <!-- Barang Keluar -->
                        <!-- Placeholder Route -->
                        <a href="{{ route('item_exits.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('item_exits.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Barang Keluar">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Barang Keluar</span>
                        </a>

                        <!-- Laporan -->
                        <!-- Placeholder Route -->
                        <a href="{{ route('reports.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Laporan">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Laporan</span>
                        </a>
                    </nav>

                    <!-- Bottom Nav / Settings -->
                    <div class="space-y-1">
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('backup.index') }}" 
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('backup.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}"
                           :class="sidebarCollapsed ? 'justify-center' : ''"
                           title="Backup Database">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span class="ml-3 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden opacity-0' : 'opacity-100'">Backup Database</span>
                        </a>
                        @endif
                    </div>
                </div>
            </aside>

            <!-- SIDEBAR: MOBILE OFF-CANVAS -->
            <div x-show="mobileSidebarOpen" class="fixed inset-0 z-40 md:hidden flex" x-cloak>
                <!-- Backdrop -->
                <div @click="mobileSidebarOpen = false" x-show="mobileSidebarOpen"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

                <!-- Sidebar Body -->
                <div x-show="mobileSidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
                    
                    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <div class="p-1 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shrink-0">
                                <img src="{{ asset('logo.png') }}" class="h-7 w-7 object-contain" width="28" height="28" alt="ASETRA">
                            </div>
                            <span class="font-bold text-xl tracking-wider text-blue-600 dark:text-blue-400">ASETRA</span>
                        </a>
                        <button @click="mobileSidebarOpen = false" class="p-1 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
                        <nav class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>

                            @if(Auth::user()->isAdmin())
                            <div x-data="{ masterOpenMobile: true }">
                                <button @click="masterOpenMobile = !masterOpenMobile" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                                        </svg>
                                        <span class="ml-3 text-left">Data Master</span>
                                    </div>
                                    <svg class="h-4 w-4 transform transition-transform duration-200" :class="masterOpenMobile ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="masterOpenMobile" class="pl-8 pr-2 mt-1 space-y-1">
                                    <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('categories.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Kategori</a>
                                    <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('suppliers.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Supplier</a>
                                    <a href="{{ route('locations.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('locations.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Lokasi / Ruangan</a>
                                    <a href="{{ route('funding_sources.index') }}" class="block px-3 py-2 rounded-lg text-xs font-medium {{ request()->routeIs('funding_sources.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">Sumber Dana</a>
                                </div>
                            </div>
                            @endif

                            <a href="{{ route('items.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('items.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span class="ml-3">Data Barang</span>
                            </a>

                            <a href="{{ route('procurements.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('procurements.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-3">Pengadaan (Masuk)</span>
                            </a>

                            <a href="{{ route('item_exits.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('item_exits.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-3">Barang Keluar</span>
                            </a>

                            <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="ml-3">Laporan</span>
                            </a>
                            
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('backup.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('backup.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/50' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span class="ml-3">Backup Database</span>
                            </a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Topbar Header -->
                <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4">
                    
                    <!-- Sidebar Toggle (Mobile) & Header Info -->
                    <div class="flex items-center">
                        <button @click="mobileSidebarOpen = true" class="md:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 mr-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Page Title or Breadcrumb -->
                        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                            @yield('page_title', 'ASETRA')
                        </h2>
                    </div>

                    <!-- Topbar Actions & User Dropdown -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Dropdown -->
                        <div x-data="{ notificationsOpen: false }" class="relative">
                            <button @click="notificationsOpen = !notificationsOpen" class="p-1.5 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none relative">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                
                                <!-- Active Notification Dot -->
                                @php
                                    $lowStockItemsCount = \App\Models\Item::whereColumn('stock', '<=', 'min_stock')->count();
                                @endphp
                                @if($lowStockItemsCount > 0)
                                    <span class="absolute top-0.5 right-0.5 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"></span>
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="notificationsOpen" @click.outside="notificationsOpen = false"
                                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50"
                                 x-cloak>
                                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-bold text-sm">Notifikasi</span>
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    @if($lowStockItemsCount > 0)
                                        <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-start space-x-3">
                                            <div class="p-1.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg shrink-0">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Stok Menipis!</p>
                                                <p class="text-xxs text-gray-500 mt-0.5">Ada {{ $lowStockItemsCount }} barang dengan stok di bawah batas minimal.</p>
                                                <!-- Link to view low stock items (Dashboard filter or items list) -->
                                                <a href="#" class="text-xxs text-blue-600 hover:underline mt-1 block">Tinjau Barang</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="px-4 py-6 text-center text-xs text-gray-500">
                                            Tidak ada notifikasi baru
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none dark:text-gray-300">
                                    <div class="h-8 w-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden sm:inline-block">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="block text-xs text-gray-500">Nama Akun</span>
                                    <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-xxs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">
                                    Profil Saya
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        Keluar Aplikasi
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Header (Optional / breadcrumb container) -->
                @isset($header)
                    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4 px-6">
                        {{ $header }}
                    </div>
                @endisset

                <!-- Main Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6">
                    
                    <!-- ALERT NOTIFICATION SYSTEM -->
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-4 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg shadow-sm text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-400" role="alert">
                            <svg class="h-5 w-5 shrink-0 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto p-1 rounded hover:bg-emerald-100 dark:hover:bg-emerald-900/40">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-4 flex items-center p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg shadow-sm text-rose-800 dark:bg-rose-950/20 dark:text-rose-400" role="alert">
                            <svg class="h-5 w-5 shrink-0 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                            <button @click="show = false" class="ml-auto p-1 rounded hover:bg-rose-100 dark:hover:bg-rose-900/40">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- MAIN SLOT -->
                    {{ $slot }}
                </main>
            </div>
        </div>

    </body>
</html>
