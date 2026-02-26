<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Tentukan siapa yang boleh pakai request ini.
     */
    public function authorize(): bool
    {
        // false artinya semua request **tidak otomatis diizinkan**
        return true;
    }

    /**
     * Rules untuk validasi input.
     */
    public function rules(): array
    {
        // Cek apakah ini request update berdasarkan route parameter
        $isUpdate = $this->route('product') !== null;

        return [
            'name' => ($isUpdate ? 'sometimes|' : '') . 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => ($isUpdate ? 'sometimes|' : '') . 'required|numeric',
            'stock' => ($isUpdate ? 'sometimes|' : '') . 'required|integer|min:0',
            'image' => ($isUpdate ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}