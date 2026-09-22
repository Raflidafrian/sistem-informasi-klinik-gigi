<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Menampilkan daftar appointment
     */
    public function index()
    {
        $appointments = Appointment::with([
            'patient.user',
            'doctor.user'
        ])
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'asc')
        ->get();

        return view(
            'admin.appointments.index',
            compact('appointments')
        );
    }


    /**
     * Form tambah appointment
     */
    public function create()
    {
        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->get();

        $patients = Patient::with('user')
            ->get();

        return view(
            'admin.appointments.create',
            compact('doctors', 'patients')
        );
    }


    /**
     * Simpan appointment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'complaint' => 'nullable|string|max:1000',
        ]);


        // Cek jadwal dokter bentrok
        $exists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();


        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                        'Dokter sudah memiliki appointment pada tanggal dan jam tersebut.'
                ]);
        }


        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'complaint' => $validated['complaint'],
            'status' => 'pending',
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment berhasil dibuat.'
            );
    }


    /**
     * Form edit appointment
     */
    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->get();

        $patients = Patient::with('user')
            ->get();

        return view(
            'admin.appointments.edit',
            compact(
                'appointment',
                'doctors',
                'patients'
            )
        );
    }


    /**
     * Update appointment
     */
    public function update(
        Request $request,
        Appointment $appointment
    ) {

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'complaint' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);


        // Cek bentrok
        $exists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('id', '!=', $appointment->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();


        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                        'Dokter sudah memiliki appointment pada tanggal dan jam tersebut.'
                ]);
        }


        $appointment->update([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'complaint' => $validated['complaint'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment berhasil diperbarui.'
            );
    }


    /**
     * Hapus appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment berhasil dihapus.'
            );
    }
}