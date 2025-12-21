<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'Admin'
        ]);

        $staff = Role::create([
            'name' => 'Staff'
        ]);

        //buat user role Admin
        $adminRole = User::create([
            'name' => 'Malik',
            'email' => 'hr@gmail.com',
            'password' => bcrypt('password')
        ]);

        //memberi role admin ke akun admin
        $adminRole->assignRole($admin);
    }
}
