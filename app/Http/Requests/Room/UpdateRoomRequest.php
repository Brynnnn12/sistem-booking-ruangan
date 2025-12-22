<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'name')->ignore($this->route('room')),
            ],
            'location' => 'sometimes|required|string|max:500',
            'capacity' => 'sometimes|required|integer|min:1',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
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
