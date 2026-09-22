<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'complaint'        => 'nullable|string|max:1000',
        ]);

        // Cek bentrok jadwal dokter pada tanggal dan jam yang sama
        $exists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'appointment_time' => 'Jadwal dokter pada waktu tersebut sudah terisi.'
            ]);
        }

        // Simpan data janji temu
        Appointment::create([
            'patient_id'       => Auth::user()->patient?->id,
            'doctor_id'        => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'complaint'        => $validated['complaint'],
            'status'           => 'pending',
        ]);

        return redirect()
            ->route('patient.appointments')
            ->with('success', 'Appointment berhasil dibuat.');
    }
}