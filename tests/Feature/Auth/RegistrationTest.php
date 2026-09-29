<?php

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '081234567890',
        'nik' => '3201234567890001',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // Pastikan tidak ada kesalahan validasi.
    $response->assertSessionHasNoErrors();

    // Pastikan pengguna otomatis login.
    $this->assertAuthenticated();

    // Pastikan diarahkan ke dashboard.
    $response->assertRedirect(
        route('dashboard', absolute: false)
    );

    // Pastikan akun tersimpan sebagai pasien.
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'phone' => '081234567890',
        'role' => 'pasien',
    ]);

    // Pastikan profil pasien juga dibuat.
    $user = User::where(
        'email',
        'test@example.com'
    )->firstOrFail();

    $this->assertDatabaseHas('patients', [
        'user_id' => $user->id,
        'nik' => '3201234567890001',
    ]);
});