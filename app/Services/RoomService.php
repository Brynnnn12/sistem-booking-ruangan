<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\RoomRepository;
use App\Traits\ImageHandler;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoomService
{
    use ImageHandler;

    public function __construct(
        protected RoomRepository $roomRepository
    ) {}

    public function getPaginated(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->roomRepository->paginate($perPage, $filters);
    }

    public function create(array $data): Room
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->uploadImage($data['image'], $data['name'] ?? 'room', 'rooms');
            }

            return $this->roomRepository->store($data);
        });
    }

    public function update(Room $room, array $data): Room
    {
        return DB::transaction(function () use ($room, $data) {
            //jika room sudah ada booking aktif, maka tidak boleh mengubah is_active menjadi false
            if ($room->bookings()->active()->exists() && array_key_exists('is_active', $data) && $data['is_active'] === false) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'is_active' => 'Ruangan tidak dapat dinonaktifkan karena masih memiliki booking aktif.',
                ]);
            }
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                // Upload gambar baru dulu
                $newImagePath = $this->uploadImage($data['image'], $data['name'] ?? $room->name, 'rooms');

                // Jika upload berhasil, hapus gambar lama dan set path baru
                $this->deletePhysicalFile($room->getRawOriginal('image'));
                $data['image'] = $newImagePath;
            }

            return $this->roomRepository->update($room, $data);
        });
    }

    public function delete(Room $room): void
    {
        DB::transaction(function () use ($room) {
            if ($room->bookings()->active()->exists()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'room' => 'Ruangan tidak dapat dihapus karena masih memiliki booking aktif.',
                ]);
            }

            // Delete DB dulu
            $this->roomRepository->delete($room);

            // Jika berhasil, baru hapus file fisik
            $this->deletePhysicalFile($room->getRawOriginal('image'));
        });
    }

    /**
     * Override folder untuk room images
     */
    protected function getImageFolder(): string
    {
        return 'rooms';
    }
}
