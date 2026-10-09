<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::orderBy('category')
            ->orderBy('name')
            ->get();

        return view('admin.treatments.index', compact('treatments'));
    }

    public function create()
    {
        return view('admin.treatments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
        ], [
            'name.required' => 'Nama tindakan wajib diisi.',
            'category.required' => 'Kategori tindakan wajib dipilih.',
            'min_price.required' => 'Harga minimum wajib diisi.',
            'max_price.required' => 'Harga maksimum wajib diisi.',
            'max_price.gte' => 'Harga maksimum harus sama dengan atau lebih besar dari harga minimum.',
        ]);

        Treatment::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'min_price' => $validated['min_price'],
            'max_price' => $validated['max_price'],
            'price' => $validated['min_price'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil ditambahkan.');
    }

    public function edit(Treatment $treatment)
    {
        return view('admin.treatments.edit', compact('treatment'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama tindakan wajib diisi.',
            'category.required' => 'Kategori tindakan wajib dipilih.',
            'min_price.required' => 'Harga minimum wajib diisi.',
            'max_price.required' => 'Harga maksimum wajib diisi.',
            'max_price.gte' => 'Harga maksimum harus sama dengan atau lebih besar dari harga minimum.',
        ]);

        $treatment->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'min_price' => $validated['min_price'],
            'max_price' => $validated['max_price'],
            'price' => $validated['min_price'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil diperbarui.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()
            ->route('admin.treatments.index')
            ->with('success', 'Tarif tindakan berhasil dihapus.');
    }
}