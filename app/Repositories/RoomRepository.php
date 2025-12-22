<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository
{
    public function __construct(
        protected Room $model
    ) {}

    public function paginate(
        int $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator {
        return $this->model
            ->search($filters['search'] ?? null)
            ->activeStatus($filters['is_active'] ?? null)
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Room
    {
        return $this->model->find($id);
    }

    public function store(array $data): Room
    {
        return $this->model->create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);

        return $room->refresh();
    }

    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }
}
