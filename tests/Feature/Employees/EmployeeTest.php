<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Membuat peran admin sebelum setiap pengujian
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Staff']);
});

function verifiedUserWithRole(string $role): User
{
    $user = User::factory()->create([
        'email_verified_at' => Carbon::now(),
    ]);

    $user->assignRole($role);

    return $user;
}

test('admin bisa melihat halaman daftar pegawai', function () {
    //Arrange
    $adminUser = verifiedUserWithRole('Admin');

    //Act 
    $response = actingAs($adminUser)->get(route('dashboard.employees.index'));

    //Assert
    $response->assertStatus(200);
});

test('staff tidak bisa melihat halaman daftar pegawai', function () {
    //Arrange
    $staffUser = verifiedUserWithRole('Staff');

    //Act 
    $response = actingAs($staffUser)->get(route('dashboard.employees.index'));

    //Assert
    $response->assertStatus(403);
});
