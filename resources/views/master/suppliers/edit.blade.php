<x-app-layout>
    @section('page_title', 'Ubah Supplier')

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Master Data / Supplier / Ubah</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Ubah Supplier</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Supplier -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Supplier <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Kontak -->
                    <div>
                        <label for="contact_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Kontak (Sales/PIC)</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('contact_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Email Supplier</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
