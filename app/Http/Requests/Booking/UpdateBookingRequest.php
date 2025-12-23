<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by BookingPolicy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_id'       => ['sometimes', 'exists:rooms,id'],
            'booking_date'  => ['sometimes', 'date', 'after_or_equal:today'],
            'start_time'    => ['sometimes', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:22:00'],
            'end_time'      => ['sometimes', 'date_format:H:i', 'after:start_time', 'after_or_equal:08:00', 'before_or_equal:23:00'],
            'note'          => ['nullable', 'string', 'max:1000'],
            'status'        => $this->user()->hasRole('Admin')
                ? ['sometimes', 'in:approved,rejected,cancelled']
                : ['prohibited'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'room_id.exists'              => 'Ruangan tidak ditemukan.',
            'booking_date.date'           => 'Format tanggal tidak valid.',
            'booking_date.after_or_equal' => 'Tanggal booking minimal hari ini.',
            'start_time.date_format'      => 'Format jam mulai tidak valid (HH:MM).',
            'start_time.after_or_equal'   => 'Jam mulai minimal 07:00.',
            'start_time.before_or_equal'  => 'Jam mulai maksimal 22:00.',
            'end_time.date_format'        => 'Format jam selesai tidak valid (HH:MM).',
            'end_time.after'              => 'Jam selesai harus setelah jam mulai.',
            'end_time.after_or_equal'     => 'Jam selesai minimal 08:00.',
            'end_time.before_or_equal'    => 'Jam selesai maksimal 23:00.',
            'note.max'                    => 'Catatan maksimal 1000 karakter.',
            'status.in'                   => 'Status harus salah satu dari: approved, rejected, cancelled.',
            'status.prohibited'           => 'Anda tidak memiliki izin mengubah status.',
        ];
    }
}
