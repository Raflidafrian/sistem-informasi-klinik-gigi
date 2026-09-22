<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Menampilkan daftar dokter
     */
    public function index()
    {
        $doctors = Doctor::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }


    /**
     * Form tambah dokter
     */
    public function create()
    {
        return view('admin.doctors.create');
    }


    /**
     * Simpan dokter baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);


        // Buat akun user dokter
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('dokter123'),
            'role' => 'dokter',
            'phone' => $validated['phone'] ?? null,
        ]);


        // Buat data dokter
        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_active' => true,
        ]);


        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }


    /**
     * Form edit dokter
     */
    public function edit(Doctor $doctor)
    {
        $doctor->load('user');

        return view('admin.doctors.edit', compact('doctor'));
    }


    /**
     * Update dokter
     */
    public function update(Request $request, Doctor $doctor)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $doctor->user_id,
        'phone' => 'nullable|string|max:20',
        'specialization' => 'nullable|string|max:255',
        'license_number' => 'nullable|string|max:255',
        'bio' => 'nullable|string',
        'is_active' => 'required|boolean',
    ], [
        'name.required' => 'Nama dokter wajib diisi.',
        'email.required' => 'Email dokter wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email tersebut sudah digunakan oleh pengguna lain.',
    ]);

    // Update data user
    $doctor->user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? null,
    ]);

    // Update data dokter
    $doctor->update([
        'specialization' => $validated['specialization'] ?? null,
        'license_number' => $validated['license_number'] ?? null,
        'bio' => $validated['bio'] ?? null,
        'is_active' => $validated['is_active'],
    ]);

    return redirect()
        ->route('admin.doctors.index')
        ->with('success', 'Data dokter berhasil diperbarui.');
}


    /**
     * Hapus dokter
     */
    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;

        $doctor->delete();

        if ($user) {
            $user->delete();
        }


        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil dihapus.');
    }
}