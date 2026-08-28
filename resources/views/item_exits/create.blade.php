<x-app-layout>
    @section('page_title', 'Catat Barang Keluar')

    <div class="max-w-xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Transaksi / Barang Keluar / Baru</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Catat Barang Keluar</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700"
             x-data="{
                 selectedItemId: '{{ old('item_id') }}',
                 itemsList: {{ $items->toJson() }},
                 getCurrentStock() {
                     const selected = this.itemsList.find(i => i.id == this.selectedItemId);
                     return selected ? selected.stock + ' ' + selected.unit : 'Tidak ada (Pilih barang)';
                 },
                 getMaxQty() {
                     const selected = this.itemsList.find(i => i.id == this.selectedItemId);
                     return selected ? selected.stock : 999999;
                 }
             }">
            <form action="{{ route('item_exits.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Tanggal Keluar -->
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Pengeluaran <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('date') border-red-500 @enderror" required>
                    @error('date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Barang & Info Stok -->
                <div class="space-y-2">
                    <label for="item_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Pilih Barang <span class="text-red-500">*</span></label>
                    <select name="item_id" id="item_id" x-model="selectedItemId" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('item_id') border-red-500 @enderror" required>
                        <option value="">Pilih Barang...</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->code }})</option>
                        @endforeach
                    </select>
                    
                    <!-- Live Stock Alert Box -->
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg flex items-center justify-between text-xs">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Stok Tersedia Saat Ini:</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400" x-text="getCurrentStock()"></span>
                    </div>

                    @error('item_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Keluar -->
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Jumlah Keluar <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" :max="getMaxQty()" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('quantity') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" required>
                    @error('quantity')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tujuan Pendistribusian -->
                <div>
                    <label for="destination" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Tujuan Distribusi <span class="text-red-500">*</span></label>
                    <input type="text" name="destination" id="destination" value="{{ old('destination') }}" placeholder="Contoh: Lab Komputer, Kelas X-A, Ruang Guru" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('destination') border-red-500 @enderror" required>
                    @error('destination')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penanggung Jawab (PIC) -->
                <div>
                    <label for="pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                    <input type="text" name="pic" id="pic" value="{{ old('pic') }}" placeholder="Contoh: Dra. Sri Wahyuni, Hermawan, S.Kom" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('pic') border-red-500 @enderror" required>
                    @error('pic')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan / Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Keterangan / Catatan</label>
                    <textarea name="description" id="description" rows="3" placeholder="Alasan pengeluaran barang atau detail lainnya..." class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('item_exits.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                        Simpan Barang Keluar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
