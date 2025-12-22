<?php

use App\Models\User;
use App\Models\Room;
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

test('guest tidak bisa akses rooms dan diarahkan ke login', function () {
    get('/dashboard/rooms')
        ->assertStatus(302)
        ->assertRedirect('/login');
});

test('user yang belum verifikasi email diarahkan ke halaman verifikasi', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);
    $user->assignRole('Admin');

    actingAs($user)
        ->get('/dashboard/rooms')
        ->assertStatus(302)
        ->assertRedirect('/verify-email');
});

test('admin bisa melihat halaman daftar ruangan', function () {
    $adminUser = verifiedUserWithRole('Admin');

    actingAs($adminUser)
        ->get('/dashboard/rooms')
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.index');
});

test('staff bisa melihat halaman daftar ruangan', function () {
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($staffUser)
        ->get('/dashboard/rooms')
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.index');
});

test('admin dan staff bisa melihat detail ruangan', function () {
    $room = Room::factory()->create();

    $adminUser = verifiedUserWithRole('Admin');
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($adminUser)
        ->get("/dashboard/rooms/{$room->id}")
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.show');

    actingAs($staffUser)
        ->get("/dashboard/rooms/{$room->id}")
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.show');
});

test('hanya admin yang bisa akses create room', function () {
    $adminUser = verifiedUserWithRole('Admin');
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($adminUser)
        ->get('/dashboard/rooms/create')
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.create');

    actingAs($staffUser)
        ->get('/dashboard/rooms/create')
        ->assertStatus(403);
});

test('hanya admin yang bisa membuat room', function () {
    $payload = [
        'name' => 'Ruang Rapat A',
        'location' => 'Lantai 2',
        'capacity' => 10,
        'is_active' => true,
    ];

    $adminUser = verifiedUserWithRole('Admin');
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($staffUser)
        ->post('/dashboard/rooms', $payload)
        ->assertStatus(403);

    actingAs($adminUser)
        ->post('/dashboard/rooms', $payload)
        ->assertStatus(302)
        ->assertSessionHas('success', 'Room created');

    assertDatabaseHas('rooms', [
        'name' => 'Ruang Rapat A',
        'location' => 'Lantai 2',
        'capacity' => 10,
    ]);
});

test('hanya admin yang bisa edit dan update room', function () {
    $room = Room::factory()->create([
        'name' => 'Ruang Lama',
        'is_active' => true,
    ]);

    $adminUser = verifiedUserWithRole('Admin');
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($staffUser)
        ->get("/dashboard/rooms/{$room->id}/edit")
        ->assertStatus(403);

    actingAs($adminUser)
        ->get("/dashboard/rooms/{$room->id}/edit")
        ->assertStatus(200)
        ->assertViewIs('dashboard.room.edit');

    actingAs($staffUser)
        ->put("/dashboard/rooms/{$room->id}", [
            'name' => 'Ruang Baru',
            'is_active' => true,
        ])
        ->assertStatus(403);

    actingAs($adminUser)
        ->put("/dashboard/rooms/{$room->id}", [
            'name' => 'Ruang Baru',
            'is_active' => false,
        ])
        ->assertStatus(302)
        ->assertSessionHas('success', 'Room updated');

    assertDatabaseHas('rooms', [
        'id' => $room->id,
        'name' => 'Ruang Baru',
        'is_active' => 0,
    ]);
});

test('hanya admin yang bisa menghapus room', function () {
    $room = Room::factory()->create();

    $adminUser = verifiedUserWithRole('Admin');
    $staffUser = verifiedUserWithRole('Staff');

    actingAs($staffUser)
        ->delete("/dashboard/rooms/{$room->id}")
        ->assertStatus(403);

    actingAs($adminUser)
        ->delete("/dashboard/rooms/{$room->id}")
        ->assertStatus(302)
        ->assertSessionHas('success', 'Room deleted');

    assertDatabaseMissing('rooms', [
        'id' => $room->id,
    ]);
});
