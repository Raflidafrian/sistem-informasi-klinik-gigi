<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Patient::where(
            'user_id',
            Auth::id()
        )->first();

        $appointments = $patient
            ? $patient->appointments()
                ->with('doctor')
                ->orderByDesc('appointment_date')
                ->get()
            : collect();

        return view(
            'patient.appointments.index',
            compact('appointments')
        );
    }

    public function create()
    {
        $doctors = Doctor::orderBy('id')->get();

        return view(
            'patient.appointments.create',
            compact('doctors')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'complaint' => 'required|string|max:1000',
        ]);

        $patient = Patient::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $exists = Appointment::where(
            'doctor_id',
            $validated['doctor_id']
        )
        ->whereDate(
            'appointment_date',
            $validated['appointment_date']
        )
        ->where(
            'appointment_time',
            $validated['appointment_time']
        )
        ->whereIn('status', ['pending', 'confirmed'])
        ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'appointment_time' =>
                    'Jadwal dokter pada jam tersebut sudah terisi.',
            ]);
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'complaint' => $validated['complaint'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('pasien.appointments.index')
            ->with(
                'success',
                'Booking berhasil. Menunggu konfirmasi admin.'
            );
    }
}