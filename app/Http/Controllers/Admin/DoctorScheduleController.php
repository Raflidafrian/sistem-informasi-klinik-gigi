<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Menampilkan semua jadwal praktik
     */
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->get();

        return view('admin.schedules.create', compact('doctors'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Cek apakah dokter sudah memiliki jadwal pada hari yang sama
        $exists = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('is_active', true)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'day_of_week' => 'Dokter tersebut sudah memiliki jadwal pada hari tersebut.'
                ]);
        }

        DoctorSchedule::create([
            'doctor_id' => $validated['doctor_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal praktik berhasil ditambahkan.');
    }

    /**
     * Form edit jadwal
     */
    public function edit(DoctorSchedule $schedule)
    {
        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->get();

        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, DoctorSchedule $schedule)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'nullable|boolean',
        ]);

        $exists = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('id', '!=', $schedule->id)
            ->where('is_active', true)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'day_of_week' => 'Dokter tersebut sudah memiliki jadwal pada hari tersebut.'
                ]);
        }

        $schedule->update([
            'doctor_id' => $validated['doctor_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal praktik berhasil diperbarui.');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(DoctorSchedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal praktik berhasil dihapus.');
    }
}