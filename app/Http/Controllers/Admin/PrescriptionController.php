<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    /**
     * Menampilkan seluruh resep obat.
     */
    public function index()
    {
        $prescriptions = Prescription::with([
            'dentalRecord.patient.user',
            'dentalRecord.doctor.user',
            'items.medicine',
        ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.prescriptions.index',
            compact('prescriptions')
        );
    }

    /**
     * Menampilkan detail resep obat.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load([
            'dentalRecord.patient.user',
            'dentalRecord.doctor.user',
            'items.medicine',
        ]);

        return view(
            'admin.prescriptions.show',
            compact('prescription')
        );
    }
}