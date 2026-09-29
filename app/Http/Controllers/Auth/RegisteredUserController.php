<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menyimpan registrasi pasien.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data pasien.
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^08[0-9]{8,11}$/',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:patients,nik',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Simpan akun dan profil dalam satu transaksi.
        $user = DB::transaction(function () use ($validated) {

            // 1. Membuat akun pengguna.
            $user = new User();

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make(
                $validated['password']
            );

            // Semua pendaftar otomatis menjadi pasien.
            $user->role = 'pasien';

            $user->save();

            // 2. Membuat profil pasien.
            Patient::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
            ]);

            return $user;
        });

        // Kirim event registrasi.
        event(new Registered($user));

        // Login otomatis setelah registrasi.
        Auth::login($user);

        // Arahkan ke dashboard sesuai role.
        return redirect()->route('dashboard');
    }
}