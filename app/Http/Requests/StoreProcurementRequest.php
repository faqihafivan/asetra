<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|string|max:255',
            'funding_source_id' => 'required|exists:funding_sources,id',
            'description' => 'nullable|string',
            'invoice_photos' => 'required|array|min:1',
            'invoice_photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Nested items validation
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal pengadaan wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
            'invoice_number.required' => 'Nomor nota wajib diisi.',
            'funding_source_id.required' => 'Sumber dana wajib dipilih.',
            'funding_source_id.exists' => 'Sumber dana yang dipilih tidak valid.',
            'invoice_photos.required' => 'Foto bukti nota wajib diupload minimal 1 foto.',
            'invoice_photos.array' => 'Format bukti harus berupa array.',
            'invoice_photos.min' => 'Wajib mengunggah minimal 1 foto bukti nota.',
            'invoice_photos.*.required' => 'Berkas foto bukti wajib dilampirkan.',
            'invoice_photos.*.image' => 'Setiap berkas bukti harus berupa gambar.',
            'invoice_photos.*.max' => 'Ukuran foto bukti tidak boleh lebih dari 2MB.',
            
            'items.required' => 'Daftar item pengadaan minimal harus berisi 1 barang.',
            'items.min' => 'Daftar item pengadaan minimal harus berisi 1 barang.',
            'items.*.item_id.required' => 'Item barang wajib dipilih.',
            'items.*.item_id.exists' => 'Item barang yang dipilih tidak valid.',
            'items.*.quantity.required' => 'Jumlah barang wajib diisi.',
            'items.*.quantity.integer' => 'Jumlah barang harus berupa angka.',
            'items.*.quantity.min' => 'Jumlah barang minimal adalah 1.',
            'items.*.unit_price.required' => 'Harga satuan wajib diisi.',
            'items.*.unit_price.numeric' => 'Harga satuan harus berupa angka.',
            'items.*.unit_price.min' => 'Harga satuan tidak boleh kurang dari 0.',
            'items.*.photo.image' => 'Foto barang harus berupa gambar.',
            'items.*.photo.max' => 'Ukuran foto barang tidak boleh lebih dari 2MB.',
        ];
    }
}
