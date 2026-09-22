<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    /**
     * Menampilkan antrian pasien dokter hari ini
     */
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        // Default tanggal hari ini
        $date = $request->input(
            'date',
            now()->format('Y-m-d')
        );

        // Ambil appointment dokter pada tanggal yang dipilih
        $appointments = Appointment::with([
            'patient.user'
        ])
        ->where('doctor_id', $doctor->id)
        ->whereDate('appointment_date', $date)
        ->orderBy('appointment_time')
        ->get();

        return view(
            'doctor.queue.index',
            compact(
                'appointments',
                'date'
            )
        );
    }
}