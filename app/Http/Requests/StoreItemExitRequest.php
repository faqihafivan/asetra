<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemExitRequest extends FormRequest
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
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'destination' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal pengeluaran wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'item_id.required' => 'Barang wajib dipilih.',
            'item_id.exists' => 'Barang yang dipilih tidak valid.',
            'quantity.required' => 'Jumlah barang wajib diisi.',
            'quantity.integer' => 'Jumlah barang harus berupa angka.',
            'quantity.min' => 'Jumlah barang minimal adalah 1.',
            'destination.required' => 'Tujuan pendistribusian wajib diisi.',
            'destination.max' => 'Nama tujuan terlalu panjang (maksimal 255 karakter).',
            'pic.required' => 'Penanggung jawab wajib diisi.',
            'pic.max' => 'Nama penanggung jawab terlalu panjang (maksimal 255 karakter).',
        ];
    }
}
