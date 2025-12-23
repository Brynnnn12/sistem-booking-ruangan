<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\RoomRepository;
use App\Traits\ImageHandler;
use DomainException;

class RoomService
{
    use ImageHandler;

    public function __construct(
        protected RoomRepository $roomRepository
    ) {}

    public function create(array $data): Room
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->uploadImage($data['image'], $data['name'] ?? 'room', 'rooms');
        }

        return $this->roomRepository->store($data);
    }

    public function update(Room $room, array $data): Room
    {
        //jika room sudah ada booking aktif, maka tidak boleh mengubah is_active menjadi false
        if ($room->bookings()->active()->exists() && array_key_exists('is_active', $data) && $data['is_active'] === false) {
            throw new DomainException('Ruangan tidak dapat dinonaktifkan karena masih memiliki booking aktif.');
        }
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Hapus gambar lama menggunakan helper khusus
            $this->deletePhysicalFile($room->getRawOriginal('image'));

            // Upload gambar baru
            $data['image'] = $this->uploadImage($data['image'], $data['name'] ?? $room->name, 'rooms');
        }

        return $this->roomRepository->update($room, $data);
    }

    public function delete(Room $room): void
    {
        if ($room->bookings()->active()->exists()) {
            throw new DomainException('Ruangan tidak dapat dihapus karena masih memiliki booking aktif.');
        }

        // Hapus file fisik sebelum menghapus data di database
        $this->deletePhysicalFile($room->getRawOriginal('image'));

        $this->roomRepository->delete($room);
    }

    /**
     * Override folder untuk room images
     */
    protected function getImageFolder(): string
    {
        return 'rooms';
    }
}
