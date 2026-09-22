<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Billing;

class DashboardController extends Controller
{
    public function index()
    {
        // Total dokter
        $totalDoctors = Doctor::count();

        // Total pasien
        $totalPatients = Patient::count();

        // Total appointment
        $totalAppointments = Appointment::count();

        // Total appointment pending
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // Total appointment confirmed
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();

        // Total appointment completed
        $completedAppointments = Appointment::where('status', 'completed')->count();

        // Total appointment cancelled
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();

        // Total tagihan
        $totalBillings = Billing::count();

        // Total tagihan yang sudah dibayar
        $paidBillings = Billing::where('status', 'paid')->count();

        // Total tagihan yang belum dibayar
        $unpaidBillings = Billing::where('status', 'unpaid')->count();

        // Total pendapatan
        $totalRevenue = Billing::where('status', 'paid')
            ->sum('total_amount');

        return view('admin.dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'totalBillings',
            'paidBillings',
            'unpaidBillings',
            'totalRevenue'
        ));
    }
}