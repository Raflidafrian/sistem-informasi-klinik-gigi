<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'phone'                 => '081234567890',
        'nik'                   => '3201234567890001',
        'birth_place'           => 'Jakarta',
        'birth_date'            => '1990-01-01',
        'gender'                => 'male',
        'address'               => 'Jakarta Selatan',
        'password'              => 'password',
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
        'name'  => 'Test User',
        'email' => 'test@example.com',
        'phone' => '081234567890',
        'role'  => 'pasien',
    ]);

    // Ambil user yang baru dibuat.
    $user = User::where(
        'email',
        'test@example.com'
    )->firstOrFail();

    // Pastikan profil pasien juga dibuat.
    $this->assertDatabaseHas('patients', [
        'user_id'     => $user->id,
        'nik'         => '3201234567890001',
        'birth_place' => 'Jakarta',
        'gender'      => 'male',
        'address'     => 'Jakarta Selatan',
    ]);

    // Ambil data pasien yang baru dibuat.
    $patient = \App\Models\Patient::where(
        'user_id',
        $user->id
    )->firstOrFail();

    // Pastikan tanggal lahir tersimpan dengan benar.
    expect($patient->birth_date->format('Y-m-d'))
        ->toBe('1990-01-01');
});