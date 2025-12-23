<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role Staff sudah ada
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);

        // Buat beberapa user dengan role Staff
        $staffUsers = [
            [
                'name' => 'John Doe',
                'email' => 'john@staff.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@staff.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Zaki',
                'email' => 'zaki@staff.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@staff.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@staff.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($staffUsers as $userData) {
            $user = User::create($userData);
            $user->assignRole($staffRole);
        }

        $this->command->info('✓ Created ' . count($staffUsers) . ' staff users successfully!');
    }
}
