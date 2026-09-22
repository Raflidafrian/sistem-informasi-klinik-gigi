<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingItem;
use App\Models\Patient;
use App\Models\DentalRecord;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Daftar tagihan
     */
    public function index()
    {
        $billings = Billing::with([
            'patient.user',
            'dentalRecord'
        ])
        ->latest()
        ->get();

        return view(
            'admin.billings.index',
            compact('billings')
        );
    }


    /**
     * Form tambah tagihan
     */
    public function create()
{
    $patients = Patient::with('user')
        ->latest()
        ->get();

    $dentalRecords = DentalRecord::with([
        'patient.user',
        'doctor.user'
    ])
    ->latest()
    ->get();

    $treatments = Treatment::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view(
        'admin.billings.create',
        compact(
            'patients',
            'dentalRecords',
            'treatments'
        )
    );
}


    /**
     * Simpan tagihan
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'dental_record_id' => 'required|exists:dental_records,id',
        'treatment_id' => 'required|exists:treatments,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $treatment = Treatment::findOrFail(
        $validated['treatment_id']
    );

    $subtotal = $treatment->price * $validated['quantity'];

    DB::transaction(function () use (
        $validated,
        $treatment,
        $subtotal
    ) {

        // Buat tagihan
        $billing = Billing::create([
            'patient_id' => $validated['patient_id'],
            'dental_record_id' => $validated['dental_record_id'],
            'total_amount' => $subtotal,
            'status' => 'unpaid',
        ]);


        // Buat detail tagihan
        BillingItem::create([
            'billing_id' => $billing->id,
            'treatment_id' => $treatment->id,
            'quantity' => $validated['quantity'],
            'price' => $treatment->price,
            'subtotal' => $subtotal,
        ]);
    });

    return redirect()
        ->route('admin.billings.index')
        ->with(
            'success',
            'Tagihan berhasil dibuat.'
        );
}


    /**
     * Detail tagihan
     */
    public function show(Billing $billing)
    {
        $billing->load([
            'patient.user',
            'dentalRecord',
            'items.treatment'
        ]);

        return view(
            'admin.billings.show',
            compact('billing')
        );
    }


    /**
     * Form edit tagihan
     */
    public function edit(Billing $billing)
    {
        $patients = Patient::with('user')
            ->latest()
            ->get();

        $dentalRecords = DentalRecord::with([
            'patient.user',
            'doctor.user'
        ])
        ->latest()
        ->get();

        return view(
            'admin.billings.edit',
            compact(
                'billing',
                'patients',
                'dentalRecords'
            )
        );
    }


    /**
     * Update tagihan
     */
    public function update(
        Request $request,
        Billing $billing
    ) {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dental_record_id' => 'required|exists:dental_records,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,cancelled',
        ]);

        $billing->update($validated);

        return redirect()
            ->route('admin.billings.index')
            ->with('success', 'Tagihan berhasil diperbarui.');
    }


    /**
     * Hapus tagihan
     */
    public function destroy(Billing $billing)
    {
        $billing->delete();

        return redirect()
            ->route('admin.billings.index')
            ->with('success', 'Tagihan berhasil dihapus.');
    }
}