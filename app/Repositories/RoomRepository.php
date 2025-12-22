<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoomRepository
{
    public function __construct(
        protected Room $room
    ) {}

    public function paginate(
        int $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator {
        return $this->room
            ->search($filters['search'] ?? null)
            ->activeStatus($filters['is_active'] ?? null)
            ->latest()
            ->paginate($perPage);
    }


    public function findById(int $id): ?Room
    {
        return $this->room->find($id);
    }

    public function store(array $data): Room
    {
        return $this->room->create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room;
    }

    public function delete(Room $room): void
    {
        $room->delete();
    }
}
