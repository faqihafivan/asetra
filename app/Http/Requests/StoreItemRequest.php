<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'specification' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'min_stock' => 'required|integer|min:0',
            'location_id' => 'required|exists:locations,id',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama barang wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'unit.required' => 'Satuan barang wajib diisi.',
            'min_stock.required' => 'Batas stok minimal wajib diisi.',
            'min_stock.integer' => 'Batas stok minimal harus berupa angka.',
            'min_stock.min' => 'Batas stok minimal tidak boleh negatif.',
            'location_id.required' => 'Lokasi penyimpanan wajib dipilih.',
            'location_id.exists' => 'Lokasi yang dipilih tidak valid.',
            'photo.image' => 'File yang diupload harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}
