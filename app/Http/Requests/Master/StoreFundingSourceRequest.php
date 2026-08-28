<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreFundingSourceRequest extends FormRequest
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
        $fundingSourceId = $this->route('funding_source') ? ($this->route('funding_source')->id ?? $this->route('funding_source')) : null;

        return [
            'name' => 'required|string|max:255|unique:funding_sources,name,' . $fundingSourceId,
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama sumber dana wajib diisi.',
            'name.unique' => 'Nama sumber dana sudah digunakan.',
            'name.max' => 'Nama sumber dana tidak boleh lebih dari 255 karakter.',
        ];
    }
}
