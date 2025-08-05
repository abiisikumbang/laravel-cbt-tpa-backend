<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWasteRequest extends FormRequest
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
            'point_value' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama sampah tidak boleh kosong, Bos.',
            'point_value.required' => 'Nilai poin wajib diisi. Jangan males.',
            'point_value.integer' => 'Nilai poin harus berupa angka. Bukan kode rahasia.',
            'satuan.required' => 'Satuan tidak boleh kosong. Kilogram, liter, up to you.',
            'image.required' => 'Gambar sampah harus ada. Jangan ngirim angin.',
            'image.image' => 'File yang dikirim bukan gambar. Ngapain coba?',
            'image.mimes' => 'Format gambar harus jpeg/png/jpg/gif/svg. Gak bisa PDF, oke?',
            'image.max' => 'Ukuran gambar terlalu besar. 2MB itu udah maksimal.',
        ];
    }
}
