<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['Admin', 'Staff']) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_filter([
            'room_id'    => 'required|exists:rooms,id',
            'user_id'    => null, // Always from auth
            'start_time' => 'required|date|after:now',
            'end_time'   => 'required|date|after:start_time',
            'note'       => 'nullable|string|max:1000',
        ]);
    }


    public function messages(): array
    {
        return [
            'room_id.required' => 'Ruangan wajib dipilih.',
            'room_id.exists' => 'Ruangan tidak ditemukan.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'start_time.date' => 'Format waktu mulai tidak valid.',
            'start_time.after' => 'Waktu mulai harus setelah waktu saat ini.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.date' => 'Format waktu selesai tidak valid.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'note.string' => 'Catatan harus berupa teks.',
            'note.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if (! $this->user()->hasRole('Admin')) {
            $this->merge([
                'user_id' => $this->user()->id,
            ]);
        }
    }
}
