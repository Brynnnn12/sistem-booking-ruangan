<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EmployeeRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployeeService
{
    public function __construct(
        protected EmployeeRepository $employeeRepository
    ) {}

    public function getAllPaginated(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->employeeRepository->getAllPaginated($perPage, $filters);
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // Hash password sebelum create
            $data['password'] = Hash::make($data['password']);

            // Buat user via Repository
            $user = $this->employeeRepository->store($data);

            // Assign role berdasarkan input (bukan otomatis 'Staff')
            $user->assignRole($data['role']);

            return $user;
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            // Hash password jika ada
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // Jangan update jika kosong
            }

            // Update user via Repository
            $this->employeeRepository->update($user, $data);

            // Update role jika ada
            if (isset($data['role'])) {
                $user->syncRoles([$data['role']]); // Sync untuk replace role
            }

            return $user->fresh(); // Return fresh instance
        });
    }

    public function delete(User $user): bool
    {

        return $this->employeeRepository->delete($user);
    }
}
