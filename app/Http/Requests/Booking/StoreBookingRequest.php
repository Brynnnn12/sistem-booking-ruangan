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
        return [
            'room_id'       => ['required', 'exists:rooms,id'],
            'booking_date'  => ['required', 'date', 'after_or_equal:today'],
            'start_time'    => ['required', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:16:00'],
            'end_time'      => ['required', 'date_format:H:i', 'after:start_time', 'after_or_equal:08:00', 'before_or_equal:17:00'],
            'note'          => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'room_id.required'          => 'Ruangan wajib dipilih.',
            'room_id.exists'            => 'Ruangan tidak ditemukan.',
            'booking_date.required'     => 'Tanggal booking wajib diisi.',
            'booking_date.date'         => 'Format tanggal tidak valid.',
            'booking_date.after_or_equal' => 'Tanggal booking minimal hari ini.',
            'start_time.required'       => 'Jam mulai wajib diisi.',
            'start_time.date_format'    => 'Format jam mulai tidak valid (HH:MM).',
            'start_time.after_or_equal' => 'Jam mulai minimal 07:00.',
            'start_time.before_or_equal' => 'Jam mulai maksimal 16:00.',
            'end_time.required'         => 'Jam selesai wajib diisi.',
            'end_time.date_format'      => 'Format jam selesai tidak valid (HH:MM).',
            'end_time.after'            => 'Jam selesai harus setelah jam mulai.',
            'end_time.after_or_equal'   => 'Jam selesai minimal 08:00.',
            'end_time.before_or_equal'  => 'Jam selesai maksimal 17:00.',
            'note.max'                  => 'Catatan maksimal 1000 karakter.',
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
