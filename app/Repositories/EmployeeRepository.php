<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository
{
    // 1. Inject Model melalui Constructor
    public function __construct(
        protected User $model
    ) {}

    // 2. Method untuk mendapatkan data pegawai dengan paginasi dan filter
    public function getAllPaginated(
        int $perPage = 10,
        array $filters = []
    ) {
        return $this->model
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', 'Staff');
            })
            ->when($filters['search'] ?? null, function (Builder $query, $search) {
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);
    }

    //3. method untuk menyimpan data pegawai baru
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    //4. method untuk update data pegawai
    public function update(User $user, array $data)
    {
        return $user->update($data);
    }

    //5. method untuk delete data pegawai
    public function delete(User $user)
    {
        return $user->delete();
    }
}
