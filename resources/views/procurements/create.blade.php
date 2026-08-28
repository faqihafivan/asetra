<x-app-layout>
    @section('page_title', 'Catat Pengadaan Baru')

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Transaksi / Pengadaan / Baru</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Catat Pengadaan Barang</h1>
        </div>

        <!-- Form container -->
        <form action="{{ route('procurements.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="{
                  rows: [
                      { item_id: '', quantity: 1, unit_price: 0, photoName: null, photoPreview: null }
                  ],
                  itemsList: {{ $items->toJson() }},
                  addRow() {
                      this.rows.push({ item_id: '', quantity: 1, unit_price: 0, photoName: null, photoPreview: null });
                  },
                  removeRow(index) {
                      if (this.rows.length !== 1) {
                          this.rows.splice(index, 1);
                      }
                  },
                  getSubtotal(row) {
                      return (parseInt(row.quantity) || 0) * (parseFloat(row.unit_price) || 0);
                  },
                  getTotal() {
                      let self = this;
                      return this.rows.reduce(function(sum, row) {
                          return sum + self.getSubtotal(row);
                      }, 0);
                  },
                  formatCurrency(val) {
                      return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                  }
              }"
              class="space-y-6">
            @csrf

            <!-- SECTION 1: HEADER INFO -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Informasi Nota / Pengadaan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Pengadaan -->
                    <div>
                        <label for="date" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Pengadaan <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('date') border-red-500 @enderror" required>
                        @error('date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Nota -->
                    <div>
                        <label for="invoice_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nomor Nota / Kwitansi <span class="text-red-500">*</span></label>
                        <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}" placeholder="Contoh: INV/2026/07/0012" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white @error('invoice_number') border-red-500 @enderror" required>
                        @error('invoice_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label for="supplier_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Supplier <span class="text-red-500">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('supplier_id') border-red-500 @enderror" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sumber Dana -->
                    <div>
                        <label for="funding_source_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Sumber Dana <span class="text-red-500">*</span></label>
                        <select name="funding_source_id" id="funding_source_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('funding_source_id') border-red-500 @enderror" required>
                            <option value="">Pilih Sumber Dana</option>
                            @foreach($fundingSources as $fs)
                                <option value="{{ $fs->id }}" {{ old('funding_source_id') == $fs->id ? 'selected' : '' }}>{{ $fs->name }}</option>
                            @endforeach
                        </select>
                        @error('funding_source_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan / Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Catatan Tambahan</label>
                        <textarea name="description" id="description" rows="2" placeholder="Catatan opsional mengenai pembelian ini..." class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                    </div>

                    <!-- Upload Foto Nota (Alpine.js Multi-Preview) -->
                    <div class="md:col-span-2" x-data="{ 
                        files: [], 
                        previews: [],
                        handleFiles(event) {
                            const selectedFiles = Array.from(event.target.files);
                            this.files = selectedFiles.map(f => f.name);
                            this.previews = [];
                            selectedFiles.forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.previews.push(e.target.result);
                                };
                                reader.readAsDataURL(file);
                            });
                        }
                    }">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Nota / Bukti Pembelian (Bisa lebih dari 1) <span class="text-red-500">*</span></label>
                        <input type="file" name="invoice_photos[]" id="invoice_photos" class="hidden" accept="image/*"
                               x-ref="invoicePhotosInput"
                               @change="handleFiles($event)" multiple required>
                        
                        <div class="mt-3 flex flex-col space-y-3">
                            <div class="flex items-center space-x-3">
                                <button type="button" @click="$refs.invoicePhotosInput.click()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Pilih Foto Nota / Bukti
                                </button>
                                <span class="text-xxs text-gray-500">Maksimal ukuran file per foto 2MB.</span>
                            </div>

                            <!-- Previews List -->
                            <div class="flex flex-wrap gap-3">
                                <template x-if="previews.length === 0">
                                    <div class="h-20 w-20 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center border border-dashed border-gray-300 dark:border-gray-600 text-gray-400">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </template>
                                <template x-for="(src, idx) in previews" :key="idx">
                                    <div class="relative h-20 w-20 group">
                                        <img :src="src" class="h-20 w-20 object-cover rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                    </div>
                                </template>
                            </div>

                            <!-- List of filenames -->
                            <template x-if="files.length > 0">
                                <div class="text-xxs space-y-1 bg-gray-50 dark:bg-gray-700/30 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <p class="font-bold text-gray-500">Berkas Terpilih:</p>
                                    <ul class="list-decimal pl-4 space-y-0.5 text-blue-600 dark:text-blue-400">
                                        <template x-for="name in files" :key="name">
                                            <li x-text="name"></li>
                                        </template>
                                    </ul>
                                </div>
                            </template>
                        </div>
                        @error('invoice_photos')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('invoice_photos.*')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DYNAMIC ITEMS -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Daftar Barang Belanjaan</h2>
                    <button type="button" @click="addRow()" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 rounded-lg text-xs font-bold transition">
                        <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Baris
                    </button>
                </div>

                <!-- Dynamic Rows Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Barang <span class="text-red-500">*</span></th>
                                <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-28">Jumlah <span class="text-red-500">*</span></th>
                                <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-44">Harga Satuan <span class="text-red-500">*</span></th>
                                <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-44">Subtotal</th>
                                <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-48">Foto Barang (Opsional)</th>
                                <th scope="col" class="px-4 py-2.5 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase w-16">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            <template x-for="(row, index) in rows" :key="index">
                                <tr>
                                    <!-- Select Item -->
                                    <td class="px-3 py-3.5">
                                        <select :name="'items[' + index + '][item_id]'" x-model="row.item_id" 
                                                class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="">Pilih Barang...</option>
                                            <template x-for="item in itemsList" :key="item.id">
                                                <option :value="item.id" x-text="item.name + ' (' + item.unit + ')'"></option>
                                            </template>
                                        </select>
                                    </td>

                                    <!-- Quantity -->
                                    <td class="px-3 py-3.5">
                                        <input type="number" :name="'items[' + index + '][quantity]'" x-model.number="row.quantity" min="1" 
                                               class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                                    </td>

                                    <!-- Unit Price -->
                                    <td class="px-3 py-3.5">
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 text-xs">Rp</div>
                                            <input type="number" :name="'items[' + index + '][unit_price]'" x-model.number="row.unit_price" min="0" placeholder="0" 
                                                   class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                    </td>

                                    <!-- Subtotal (Calculated) -->
                                    <td class="px-3 py-3.5 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-300" 
                                        x-text="formatCurrency(getSubtotal(row))">
                                    </td>

                                    <!-- Optional Item Photo -->
                                    <td class="px-3 py-3.5" x-data="{ rowPhotoName: null, rowPhotoPreview: null }">
                                        <div class="flex items-center space-x-2">
                                            <input type="file" :name="'items[' + index + '][photo]'" class="hidden" accept="image/*"
                                                   :id="'row-photo-' + index"
                                                   @change="
                                                        rowPhotoName = $event.target.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            rowPhotoPreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($event.target.files[0]);
                                                   ">
                                            
                                            <!-- Mini Preview -->
                                            <div class="shrink-0">
                                                <template x-if="!rowPhotoPreview">
                                                    <button type="button" @click="document.getElementById('row-photo-' + index).click()"
                                                            class="h-9 w-9 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 rounded-lg flex items-center justify-center border border-gray-300 dark:border-gray-600 text-gray-400">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 1 4 3h-8c0-2 2.667-3 4-3zm14-4a2 2 0 11-4 0 2 2 0 014 0zm-2 4c1.333 0 4 1 4 3h-8c0-2 2.667-3 4-3z" />
                                                        </svg>
                                                    </button>
                                                </template>
                                                <template x-if="rowPhotoPreview">
                                                    <img :src="rowPhotoPreview" @click="document.getElementById('row-photo-' + index).click()"
                                                         class="h-9 w-9 object-cover rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer">
                                                </template>
                                            </div>

                                            <span class="text-xxs text-gray-500 truncate max-w-[100px]" x-text="rowPhotoName || 'Pilih foto'"></span>
                                        </div>
                                    </td>

                                    <!-- Delete Row Button -->
                                    <td class="px-3 py-3.5 text-center">
                                        <button type="button" @click="removeRow(index)" :disabled="rows.length === 1"
                                                class="text-red-500 hover:text-red-700 disabled:opacity-30 disabled:cursor-not-allowed">
                                            <svg class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700/30 text-sm font-semibold text-gray-900 dark:text-white">
                            <tr>
                                <td colspan="3" class="px-4 py-3.5 text-right">Estimasi Total Harga:</td>
                                <td colspan="3" class="px-4 py-3.5 font-bold text-lg text-blue-600 dark:text-blue-400" x-text="formatCurrency(getTotal())"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($errors->any())
                    <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-800 text-xs space-y-1">
                        <p class="font-bold">Silakan perbaiki kesalahan berikut:</p>
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- FORM ACTIONS -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('procurements.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-lg font-bold text-sm text-white shadow-sm transition">
                    Catat Transaksi Pengadaan
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
