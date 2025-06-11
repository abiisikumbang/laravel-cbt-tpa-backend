<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'pickup_date' => 'required|date_format:Y-m-d| after_or_equal:today',
            'wastes' => 'required|array|min:1',
            'wastes.*.waste_id' => 'required|exists:wastes,id',
            'wastes.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom error messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'address.required' => 'Alamat harus diisi.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'pickup_date.required' => 'Tanggal penjemputan harus diisi.',
            'pickup_date.date_format' => 'Format tanggal penjemputan tidak valid. Gunakan format YYYY-MM-DD.',
            'pickup_date.after_or_equal' => 'Tanggal penjemputan tidak boleh sebelum hari ini.',
            'wastes.required' => 'Daftar sampah harus diisi.',
            'wastes.array' => 'Daftar sampah harus berupa array.',
            'wastes.min' => 'Harus ada setidaknya satu jenis sampah.',
            'wastes.*.waste_id.required' => 'ID sampah harus diisi untuk setiap jenis sampah.',
            'wastes.*.waste_id.exists' => 'ID sampah yang dipilih tidak valid.',
            'wastes.*.quantity.required' => 'Jumlah sampah harus diisi untuk setiap jenis sampah.',
            'wastes.*.quantity.integer' => 'Jumlah sampah harus berupa angka bulat.',
            'wastes.*.quantity.min' => 'Jumlah sampah tidak boleh kurang dari 1.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $wasteIds = array_column($this->wastes, 'waste_id');
            if (count($wasteIds) !== count(array_unique($wasteIds))) {
                $validator->errors()->add('wastes', 'Terdapat ID sampah yang dikirim dua kali.');
            }
        });
    }
}
