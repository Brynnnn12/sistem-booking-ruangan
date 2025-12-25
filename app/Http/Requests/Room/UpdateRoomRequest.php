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
                'regex:/^[^<>\"\';]*$/', // Prevent XSS
                Rule::unique('rooms', 'name')->ignore($this->route('room')),
            ],
            'location' => ['sometimes', 'required', 'string', 'max:500', 'regex:/^[^<>\"\';]*$/'], // Prevent XSS
            'capacity' => ['sometimes', 'required', 'integer', 'min:1', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.string' => 'Nama ruangan harus berupa teks.',
            'name.max' => 'Nama ruangan maksimal :max karakter.',
            'name.unique' => 'Nama ruangan sudah digunakan.',
            'name.regex' => 'Nama ruangan mengandung karakter yang tidak diizinkan.',
            'location.required' => 'Lokasi ruangan wajib diisi.',
            'location.string' => 'Lokasi ruangan harus berupa teks.',
            'location.max' => 'Lokasi ruangan maksimal :max karakter.',
            'location.regex' => 'Lokasi ruangan mengandung karakter yang tidak diizinkan.',
            'capacity.required' => 'Kapasitas ruangan wajib diisi.',
            'capacity.integer' => 'Kapasitas ruangan harus berupa angka.',
            'capacity.min' => 'Kapasitas ruangan minimal :min.',
            'capacity.max' => 'Kapasitas ruangan maksimal :max.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'image.dimensions' => 'Dimensi gambar harus antara 100x100 hingga 2000x2000 piksel.',
            'is_active.boolean' => 'Status aktif harus berupa nilai benar atau salah.',
        ];
    }
}
