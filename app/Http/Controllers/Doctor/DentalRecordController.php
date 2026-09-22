<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DentalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DentalRecordController extends Controller
{
    /**
     * Form rekam medis
     */

    public function index () {
        $doctor = Auth::user()->doctor()->first();

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $dentalRecords = DentalRecord::with(['patient.user'])->where('doctor_id', $doctor->id)->latest()->get();

        return view(
            'doctor.dental-records.index',
            compact('dentalRecords')
        );
    }
    public function create(Request $request)
    {
        $appointmentId = $request->query('appointment_id');

        if (!$appointmentId) {
            return redirect()
                ->route('dokter.queue.index')
                ->with('error', 'Appointment tidak ditemukan.');
        }

        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil appointment
        |--------------------------------------------------------------------------
        */

        $appointment = Appointment::with([
            'patient.user',
            'doctor.user',
            'dentalRecord'
        ])
        ->where('id', $appointmentId)
        ->where('doctor_id', $doctor->id)
        ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cek apakah sudah ada rekam medis
        |--------------------------------------------------------------------------
        */

        if ($appointment->dentalRecord) {

            return view(
                'doctor.dental-records.edit',
                compact('appointment')
            );
        }


        return view(
            'doctor.dental-records.create',
            compact('appointment')
        );
    }


    /**
     * Simpan rekam medis
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'appointment_id' => 'required|exists:appointments,id',

            'diagnosis' => 'nullable|string|max:5000',

            'treatment' => 'nullable|string|max:5000',

            'notes' => 'nullable|string|max:5000',

            'odontogram_data' => 'nullable|array',

        ]);


        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan appointment memang milik dokter yang login
        |--------------------------------------------------------------------------
        */

        $appointment = Appointment::with('patient')
            ->where('id', $validated['appointment_id'])
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cegah membuat rekam medis dua kali
        |--------------------------------------------------------------------------
        */

        if ($appointment->dentalRecord) {

            return back()->withErrors([
                'appointment_id' => 'Rekam medis untuk appointment ini sudah tersedia.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan rekam medis
        |--------------------------------------------------------------------------
        */

        

        DentalRecord::create([

            'appointment_id' => $appointment->id,

            'patient_id' => $appointment->patient_id,

            'doctor_id' => $doctor->id,

            'odontogram_data' =>
                $validated['odontogram_data'] ?? [],

            'diagnosis' =>
                $validated['diagnosis'] ?? null,

            'treatment' =>
                $validated['treatment'] ?? null,

            'notes' =>
                $validated['notes'] ?? null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Appointment selesai
        |--------------------------------------------------------------------------
        */

        $appointment->update([
            'status' => 'completed'
        ]);


        return redirect()
            ->route('dokter.queue.index')
            ->with(
                'success',
                'Rekam medis berhasil disimpan.'
            );
    }
}