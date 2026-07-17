<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
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
            'toko_id' => 'required|exists:tokos,id',
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'harga_pokok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0|gte:harga_pokok',
            'stok' => 'required|integer|min:0',
            'berat' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }
}
