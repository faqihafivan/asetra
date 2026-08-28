<x-app-layout>
    @section('page_title', 'Backup Database')

    <div class="max-w-md mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Utilitas / Backup</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Backup Database</h1>
        </div>

        <!-- Backup Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 text-center space-y-4">
                <!-- Database Icon -->
                <div class="mx-auto h-16 w-16 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>

                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Ekspor Salinan Database</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Unduh salinan data sistem ASETRA dalam format SQL secara instan untuk cadangan pengarsipan atau migrasi server.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/50 rounded-xl text-left text-xs text-amber-800 dark:text-amber-400 space-y-1.5">
                    <span class="font-bold flex items-center">
                        <svg class="h-4 w-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Perhatian:
                    </span>
                    <ul class="list-disc pl-4 space-y-1">
                        <li>Salinan ini mencakup data master, barang, data pengadaan, dan log barang keluar.</li>
                        <li>Format berkas yang dihasilkan adalah <strong>.sql</strong>.</li>
                        <li>Harap simpan berkas cadangan ini dengan aman untuk mencegah penyalahgunaan data.</li>
                    </ul>
                </div>

                <!-- Action Button -->
                <div class="pt-3">
                    <a href="{{ route('backup.download') }}" 
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-900 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="h-5 w-5 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Mulai Unduh Backup
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xxs text-gray-400">
                <span>Database: <strong>{{ config('database.connections.mysql.database') }}</strong></span>
                <span>Mesin: <strong>MySQL Engine</strong></span>
            </div>
        </div>
    </div>
</x-app-layout>
