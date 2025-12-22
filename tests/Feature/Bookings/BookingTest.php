<?php

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;



uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed roles
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Staff']);
});

// Helper function untuk user verified
function verifiedUser(string $role): User
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $user->assignRole($role);

    return $user;
}

test('staff bisa melihat booking miliknya', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'note' => 'Booking Saya',
    ]);

    // Act
    $response = $this->actingAs($user)->get(route('dashboard.bookings.index'));

    // Assert
    $response->assertStatus(200)
        ->assertSee($room->name);
});

test('admin bisa melihat semua booking', function () {
    // Arrange
    $admin = verifiedUser('Admin');
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
    ]);

    // Act
    $response = $this->actingAs($admin)->get(route('dashboard.bookings.index'));

    // Assert
    $response->assertStatus(200)
        ->assertSee($room->name);
});

test('user tanpa role tidak bisa akses booking', function () {
    // Arrange
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    // Act & Assert
    $this->actingAs($user)
        ->get(route('dashboard.bookings.index'))
        ->assertStatus(403);
});

test('staff bisa membuat booking', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $data = [
        'room_id' => $room->id,
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'note' => 'Test booking',
    ];

    // Act
    $response = $this->actingAs($user)->post(route('dashboard.bookings.store'), $data);

    // Assert
    $response->assertRedirect(route('dashboard.bookings.index'));
    $this->assertDatabaseHas('bookings', [
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);
});

test('user tanpa role tidak bisa membuat booking', function () {
    // Arrange
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    $room = Room::factory()->create();

    $data = [
        'room_id' => $room->id,
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'note' => 'Test booking',
    ];

    // Act & Assert
    $this->actingAs($user)
        ->post(route('dashboard.bookings.store'), $data)
        ->assertStatus(403);
});

test('staff bisa update booking pending miliknya', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);

    $data = [
        'room_id' => $room->id,
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'note' => 'Updated booking',
    ];

    // Act
    $response = $this->actingAs($user)->put(route('dashboard.bookings.update', $booking), $data);

    // Assert
    $response->assertRedirect(route('dashboard.bookings.index'));
});

test('staff tidak bisa update booking approved', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_APPROVED,
    ]);

    $data = [
        'room_id' => $room->id,
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'note' => 'Updated booking',
    ];

    // Act & Assert
    $this->actingAs($user)
        ->put(route('dashboard.bookings.update', $booking), $data)
        ->assertStatus(403);
});

test('staff bisa hapus booking pending miliknya', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);

    // Act
    $response = $this->actingAs($user)->delete(route('dashboard.bookings.destroy', $booking));

    // Assert
    $response->assertRedirect(route('dashboard.bookings.index'));
    $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
});

test('admin bisa approve booking pending', function () {
    // Arrange
    $admin = verifiedUser('Admin');
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);

    // Act
    $response = $this->actingAs($admin)->patch(route('dashboard.bookings.approve', $booking));

    // Assert
    $response->assertRedirect();
});

test('admin bisa reject booking pending', function () {
    // Arrange
    $admin = verifiedUser('Admin');
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);

    // Act
    $response = $this->actingAs($admin)->patch(route('dashboard.bookings.reject', $booking));

    // Assert
    $response->assertRedirect();
});

test('staff bisa cancel booking pending miliknya', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_PENDING,
    ]);

    // Act
    $response = $this->actingAs($user)->patch(route('dashboard.bookings.cancel', $booking));

    // Assert
    $response->assertRedirect();
});

test('staff tidak bisa cancel booking approved', function () {
    // Arrange
    $user = verifiedUser('Staff');
    $room = Room::factory()->create();

    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'status' => Booking::STATUS_APPROVED,
    ]);

    // Act & Assert
    $this->actingAs($user)
        ->patch(route('dashboard.bookings.cancel', $booking))
        ->assertStatus(403);
});
