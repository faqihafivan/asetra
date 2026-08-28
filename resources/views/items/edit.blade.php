<x-app-layout>
    @section('page_title', 'Ubah Barang')

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Gudang / Barang / Ubah</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Ubah Barang: {{ $item->code }}</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Nama Barang -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Barang / Aset <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi Penyimpanan -->
                    <div>
                        <label for="location_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                        <select name="location_id" id="location_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('location_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ old('location_id', $item->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Merk / Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Merk / Pabrikan</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $item->brand) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('brand')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan Barang -->
                    <div>
                        <label for="unit" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Satuan Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit', $item->unit) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('unit') border-red-500 @enderror" required>
                        @error('unit')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batas Minimal Stok -->
                    <div>
                        <label for="min_stock" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Minimal Stok (Alert) <span class="text-red-500">*</span></label>
                        <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', $item->min_stock) }}" min="0" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('min_stock') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                        @error('min_stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Spesifikasi Teknis -->
                    <div class="md:col-span-2">
                        <label for="specification" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Spesifikasi Lengkap</label>
                        <textarea name="specification" id="specification" rows="3" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('specification', $item->specification) }}</textarea>
                        @error('specification')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan Lainnya -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Keterangan Tambahan</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Barang (Alpine.js Preview) -->
                    <div class="md:col-span-2" x-data="{ photoName: null, photoPreview: '{{ $item->photo_path ? asset($item->photo_path) : '' }}' }">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Barang</label>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                               x-ref="photo"
                               @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">
                        
                        <div class="mt-2 flex items-center space-x-5">
                            <!-- Image Placeholder or Preview -->
                            <div class="shrink-0">
                                <template x-if="!photoPreview">
                                    <div class="h-24 w-24 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center border border-dashed border-gray-300 dark:border-gray-600 text-gray-400">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="h-24 w-24 object-cover rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                </template>
                            </div>

                            <!-- Upload Button -->
                            <div>
                                <button type="button" @click="$refs.photo.click()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Pilih Gambar Baru
                                </button>
                                <p class="text-xxs text-gray-500 mt-2">Format JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>
                                <template x-if="photoName">
                                    <p class="text-xxs text-blue-600 mt-1 font-semibold" x-text="photoName"></p>
                                </template>
                            </div>
                        </div>
                        @error('photo')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                        Perbarui Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
