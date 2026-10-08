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
        // Validasi data pasien
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

            'birth_place' => [
                'required',
                'string',
                'max:100',
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'gender' => [
                'required',
                'in:male,female',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ], [
            'name.required' =>
                'Nama lengkap wajib diisi.',

            'email.required' =>
                'Alamat email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah terdaftar.',

            'phone.required' =>
                'Nomor HP wajib diisi.',

            'phone.regex' =>
                'Nomor HP harus diawali 08 dan berisi 10-13 angka.',

            'nik.required' =>
                'NIK wajib diisi.',

            'nik.digits' =>
                'NIK harus terdiri dari 16 angka.',

            'nik.unique' =>
                'NIK sudah terdaftar.',

            'birth_place.required' =>
                'Tempat lahir wajib diisi.',

            'birth_date.required' =>
                'Tanggal lahir wajib diisi.',

            'birth_date.date' =>
                'Tanggal lahir tidak valid.',

            'birth_date.before_or_equal' =>
                'Tanggal lahir tidak boleh melebihi hari ini.',

            'gender.required' =>
                'Jenis kelamin wajib dipilih.',

            'gender.in' =>
                'Jenis kelamin tidak valid.',

            'address.required' =>
                'Alamat wajib diisi.',

            'password.required' =>
                'Password wajib diisi.',

            'password.confirmed' =>
                'Konfirmasi password tidak sama.',
        ]);


        // Simpan akun dan profil pasien
        // dalam satu transaksi database.
        $user = DB::transaction(function () use ($validated) {

            // ==========================================
            // 1. BUAT USER
            // ==========================================

            $user = new User();

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];

            $user->password = Hash::make(
                $validated['password']
            );

            // Semua pendaftar melalui halaman register
            // otomatis menjadi pasien.
            $user->role = 'pasien';

            $user->save();


            // ==========================================
            // 2. BUAT PROFIL PASIEN
            // ==========================================

            Patient::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
            ]);


            return $user;
        });


        // Kirim event registrasi
        event(new Registered($user));


        // Login otomatis
        Auth::login($user);


        // Redirect sesuai role
        return redirect()->route('dashboard');
    }
}