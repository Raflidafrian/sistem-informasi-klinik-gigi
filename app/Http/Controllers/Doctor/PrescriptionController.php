<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DentalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrescriptionController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        abort_unless($doctor, 403);

        $prescriptions = Prescription::with([
            'dentalRecord.patient.user',
            'items.medicine',
        ])
            ->whereHas('dentalRecord', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->latest()
            ->paginate(10);

        return view(
            'doctor.prescriptions.index',
            compact('prescriptions')
        );
    }

    public function create()
    {
        $doctor = Auth::user()->doctor;

        abort_unless($doctor, 403);

        $records = DentalRecord::with('patient.user')
            ->where('doctor_id', $doctor->id)
            ->whereDoesntHave('prescription')
            ->latest()
            ->get();

        $medicines = Medicine::orderBy('name')->get();

        return view(
            'doctor.prescriptions.create',
            compact('records', 'medicines')
        );
    }

    public function store(Request $request)
    {
        $doctor = Auth::user()->doctor;

        abort_unless($doctor, 403);

        $validated = $request->validate([
            'dental_record_id' => [
                'required',
                'exists:dental_records,id',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => [
                'required',
                'exists:medicines,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'items.*.dosage' => [
                'required',
                'string',
                'max:255',
            ],
            'items.*.usage_instruction' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $record = DentalRecord::where(
            'doctor_id',
            $doctor->id
        )->findOrFail($validated['dental_record_id']);

        if ($record->prescription()->exists()) {
            throw ValidationException::withMessages([
                'dental_record_id' =>
                    'Rekam medis ini sudah memiliki resep obat.',
            ]);
        }

        DB::transaction(function () use ($validated, $record) {
            $prescription = Prescription::create([
                'dental_record_id' => $record->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $prescription->items()->createMany(
                $validated['items']
            );
        });

        return redirect()
            ->route('dokter.prescriptions.index')
            ->with('success', 'Resep obat berhasil disimpan.');
    }

    public function show(Prescription $prescription)
    {
        $doctor = Auth::user()->doctor;

        abort_unless($doctor, 403);

        abort_unless(
            $prescription->dentalRecord?->doctor_id === $doctor->id,
            403
        );

        $prescription->load([
            'dentalRecord.patient.user',
            'dentalRecord.doctor.user',
            'items.medicine',
        ]);

        return view(
            'doctor.prescriptions.show',
            compact('prescription')
        );
    }
}