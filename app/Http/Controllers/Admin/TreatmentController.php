<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Menampilkan daftar tarif tindakan
     */
    public function index()
    {
        $treatments = Treatment::latest()->get();

        return view('admin.treatments.index', compact('treatments'));
    }

    /**
     * Form tambah tindakan
     */
    public function create()
    {
        return view('admin.treatments.create');
    }

    /**
     * Simpan tindakan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        Treatment::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit(Treatment $treatment)
    {
        return view('admin.treatments.edit', compact('treatment'));
    }

    /**
     * Update tindakan
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $treatment->update($validated);

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil diperbarui.');
    }

    /**
     * Hapus tindakan
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil dihapus.');
    }
}