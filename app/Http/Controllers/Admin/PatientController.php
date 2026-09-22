<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Menampilkan daftar pasien
     */
    public function index()
    {
        $patients = Patient::with('user')
            ->latest()
            ->get();

        return view('admin.patients.index', compact('patients'));
    }


    /**
     * Menampilkan form tambah pasien
     */
    public function create()
    {
        return view('admin.patients.create');
    }


    /**
     * Menyimpan pasien
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email',

            'phone' => 'nullable|string|max:20',

            'nik' => 'nullable|string|max:16|unique:patients,nik',

            'birth_date' => 'nullable|date',

            'gender' => 'nullable|in:male,female',

            'address' => 'nullable|string',
        ]);


        // ==========================================
        // BUAT USER
        // ==========================================

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,

            // Password sementara
            'password' => Hash::make('password'),

            // Role pasien
            'role' => 'pasien',
        ]);


        // ==========================================
        // BUAT DATA PATIENT
        // ==========================================

        Patient::create([
            'user_id' => $user->id,
            'nik' => $validated['nik'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);


        // ==========================================
        // KEMBALI KE DATA PASIEN
        // ==========================================

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }


    /**
     * Form edit pasien
     */
    public function edit(Patient $patient)
    {
        $patient->load('user');

        return view(
            'admin.patients.edit',
            compact('patient')
        );
    }


    /**
     * Update pasien
     */
    public function update(Request $request, Patient $patient)
    {
        $patient->load('user');

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' =>
                'required|email|unique:users,email,' .
                $patient->user_id,

            'phone' => 'nullable|string|max:20',

            'nik' =>
                'nullable|string|max:16|unique:patients,nik,' .
                $patient->id,

            'birth_date' => 'nullable|date',

            'gender' => 'nullable|in:male,female',

            'address' => 'nullable|string',
        ]);


        // Update user
        $patient->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);


        // Update patient
        $patient->update([
            'nik' => $validated['nik'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);


        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }


    /**
     * Hapus pasien
     */
    public function destroy(Patient $patient)
    {
        $user = $patient->user;

        $patient->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}