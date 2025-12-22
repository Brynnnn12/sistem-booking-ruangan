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
        $user = $this->user();

        return [
            'room_id' => 'sometimes|exists:rooms,id',
            'start_time' => 'sometimes|date|after:now',
            'end_time' => 'sometimes|date|after:start_time',
            'note' => 'nullable|string|max:1000',
            'status' => $user->hasRole('Admin')
                ? 'sometimes|in:approved,rejected,cancelled'
                : 'prohibited',
        ];
    }

    //pesan kustom
    public function messages(): array
    {
        return [
            'room_id.exists' => 'Ruangan tidak ditemukan.',
            'start_time.date' => 'Format waktu mulai tidak valid.',
            'start_time.after' => 'Waktu mulai harus setelah waktu saat ini.',
            'end_time.date' => 'Format waktu selesai tidak valid.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'note.string' => 'Catatan harus berupa teks.',
            'note.max' => 'Catatan maksimal 1000 karakter.',
            'status.in' => 'Status harus salah satu dari: approved, rejected, cancelled.',
            'status.prohibited' => 'Anda tidak memiliki izin mengubah status.',
        ];
    }
}
