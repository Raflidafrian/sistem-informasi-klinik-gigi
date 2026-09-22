<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $todayAppointments = Appointment::with([
            'patient.user'
        ])
        ->where('doctor_id', $doctor->id)
        ->whereDate('appointment_date', today())
        ->orderBy('appointment_time')
        ->get();

        $totalToday = $todayAppointments->count();

        $pendingToday = $todayAppointments
            ->where('status', 'pending')
            ->count();

        $confirmedToday = $todayAppointments
            ->where('status', 'confirmed')
            ->count();

        $completedToday = $todayAppointments
            ->where('status', 'completed')
            ->count();

        return view(
            'doctor.dashboard',
            compact(
                'doctor',
                'todayAppointments',
                'totalToday',
                'pendingToday',
                'confirmedToday',
                'completedToday'
            )
        );
    }
}