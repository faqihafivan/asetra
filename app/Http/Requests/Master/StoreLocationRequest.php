<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
        $locationId = $this->route('location') ? ($this->route('location')->id ?? $this->route('location')) : null;

        return [
            'name' => 'required|string|max:255|unique:locations,name,' . $locationId,
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lokasi/ruangan wajib diisi.',
            'name.unique' => 'Nama lokasi/ruangan sudah digunakan.',
            'name.max' => 'Nama lokasi/ruangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
