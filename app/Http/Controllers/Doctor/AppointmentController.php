<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Daftar Appointment Dokter
     */
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $date = $request->input(
            'date',
            now()->format('Y-m-d')
        );

        $appointments = Appointment::with([
            'patient.user'
        ])
        ->where('doctor_id', $doctor->id)
        ->whereDate('appointment_date', $date)
        ->orderBy('appointment_time')
        ->get();

        return view(
            'doctor.appointments.index',
            compact('appointments', 'date')
        );
    }

    /**
     * Antrian Pasien Dokter
     */
    public function queue(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $date = $request->input(
            'date',
            now()->format('Y-m-d')
        );

        $appointments = Appointment::with([
            'patient.user'
        ])
        ->where('doctor_id', $doctor->id)
        ->whereDate('appointment_date', $date)
        ->orderBy('appointment_time')
        ->get();

        return view(
            'doctor.queue.index',
            compact('appointments', 'date')
        );
    }
}