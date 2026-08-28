<x-app-layout>
    @section('page_title', 'Tambah Sumber Dana')

    <div class="max-w-xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Master Data / Sumber Dana / Tambah</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Tambah Sumber Dana</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('funding_sources.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Sumber Dana -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Sumber Dana <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Dana BOS, Komite" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" placeholder="Keterangan singkat mengenai peruntukan atau asal dana..." class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('funding_sources.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
