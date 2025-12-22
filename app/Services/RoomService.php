<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\RoomRepository;
use DomainException;

class RoomService
{
    public function __construct(
        protected RoomRepository $roomRepository
    ) {}

    public function create(array $data): Room
    {
        return $this->roomRepository->store($data);
    }

    public function update(Room $room, array $data): Room
    {
        // if (
        //     array_key_exists('is_active', $data)
        //     && $data['is_active'] === false
        //     && $room->bookings()->active()->exists()
        // ) {
        //     throw new DomainException(
        //         'Ruangan tidak dapat dinonaktifkan karena masih memiliki booking aktif.'
        //     );
        // }

        return $this->roomRepository->update($room, $data);
    }

    public function delete(Room $room): void
    {
        // if ($room->bookings()->exists()) {
        //     throw new DomainException(
        //         'Ruangan tidak dapat dihapus karena memiliki riwayat booking.'
        //     );
        // }

        $this->roomRepository->delete($room);
    }
}
