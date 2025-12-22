<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:rooms,name',
            'location' => 'required|string|max:500',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        //pakai bahasa indonesia
        return [
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.string' => 'Nama ruangan harus berupa teks.',
            'name.max' => 'Nama ruangan maksimal :max karakter.',
            'name.unique' => 'Nama ruangan sudah digunakan.',
            'location.required' => 'Lokasi ruangan wajib diisi.',
            'location.string' => 'Lokasi ruangan harus berupa teks.',
            'location.max' => 'Lokasi ruangan maksimal :max karakter.',
            'capacity.required' => 'Kapasitas ruangan wajib diisi.',
            'capacity.integer' => 'Kapasitas ruangan harus berupa angka.',
            'capacity.min' => 'Kapasitas ruangan minimal :min.',
            'is_active.boolean' => 'Status aktif harus berupa nilai benar atau salah.',
        ];
    }
}
