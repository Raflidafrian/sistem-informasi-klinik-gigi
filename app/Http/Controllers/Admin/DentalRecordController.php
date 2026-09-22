<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DentalRecord;

class DentalRecordController extends Controller
{
    /**
     * Menampilkan daftar rekam medis
     */
    public function index()
    {
        $records = DentalRecord::with([
            'patient.user',
            'doctor.user',
            'appointment'
        ])
        ->latest()
        ->get();

        return view('admin.dental-records.index', compact('records'));
    }
}