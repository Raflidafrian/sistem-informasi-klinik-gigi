<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Menampilkan daftar obat
     */
    public function index()
    {
        $medicines = Medicine::latest()->get();

        return view('admin.medicines.index', compact('medicines'));
    }

    /**
     * Form tambah obat
     */
    public function create()
    {
        return view('admin.medicines.create');
    }

    /**
     * Simpan obat baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
        ]);

        Medicine::create([
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'stock' => $validated['stock'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    /**
     * Form edit obat
     */
    public function edit(Medicine $medicine)
{
    return view(
        'admin.medicines.edit',
        compact('medicine')
    );
}

    /**
     * Update obat
     */
    public function update(Request $request, Medicine $medicine)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'unit' => 'required|string|max:100',
        'stock' => 'required|integer|min:0',
        'is_active' => 'required|boolean',
    ]);

    $medicine->update([
        'name' => $validated['name'],
        'unit' => $validated['unit'],
        'stock' => $validated['stock'],
        'is_active' => $validated['is_active'],
    ]);

    return redirect()
        ->route('admin.medicines.index')
        ->with('success', 'Data obat berhasil diperbarui.');
}

    /**
     * Hapus obat
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}