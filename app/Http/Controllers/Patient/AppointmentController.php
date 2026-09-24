<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Carbon\Carbon;
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
                ->with('doctor.user')
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
        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->get();

        return view(
            'patient.appointments.create',
            compact('doctors')
        );
    }

    public function availableTimes(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $doctor = Doctor::where('is_active', true)
            ->findOrFail($validated['doctor_id']);

        $date = Carbon::parse($validated['date']);

        // Asumsi day_of_week memakai nilai
        // monday, tuesday, dan seterusnya.
        $day = strtolower($date->englishDayOfWeek);

        $schedules = DoctorSchedule::where(
            'doctor_id',
            $doctor->id
        )
        ->where('day_of_week', $day)
        ->where('is_active', true)
        ->get();

        $bookedTimes = Appointment::where(
            'doctor_id',
            $doctor->id
        )
        ->whereDate(
            'appointment_date',
            $date->toDateString()
        )
        ->whereIn('status', ['pending', 'confirmed'])
        ->pluck('appointment_time')
        ->map(fn ($time) => substr($time, 0, 5))
        ->all();

        $available = [];

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            while ($start->copy()->addMinutes(30)->lte($end)) {
                $time = $start->format('H:i');

                if (
                    !in_array($time, $bookedTimes)
                    && $date->copy()->setTimeFromTimeString($time)->isFuture()
                ) {
                    $available[] = $time;
                }

                $start->addMinutes(30);
            }
        }

        $available = array_values(array_unique($available));
        sort($available);

        return response()->json($available);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'complaint' => 'required|string|max:1000',
        ]);

        $doctor = Doctor::where('is_active', true)
            ->findOrFail($validated['doctor_id']);

        $date = Carbon::parse($validated['appointment_date']);
        $time = $validated['appointment_time'];

        if (!$date->copy()->setTimeFromTimeString($time)->isFuture()) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Pilih waktu pemeriksaan yang akan datang.',
            ]);
        }

        $day = $date->dayOfWeekIso;

        $schedules = DoctorSchedule::where('doctor_id', $doctor->id)
            ->where('day_of_week', $day)
            ->where('is_active', true)
            ->get();

        $validTime = false;

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            while ($start->copy()->addMinutes(30)->lte($end)) {
                if ($start->format('H:i') === $time) {
                    $validTime = true;
                    break 2;
                }

                $start->addMinutes(30);
            }
        }

        if (!$validTime) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Jam tidak sesuai jadwal praktik dokter.',
            ]);
        }

        $booked = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date->toDateString())
            ->whereTime('appointment_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($booked) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Jam ini sudah dipesan pasien lain.',
            ]);
        }

        $patient = Patient::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => $date->toDateString(),
            'appointment_time' => $time,
            'complaint' => $validated['complaint'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('pasien.appointments.index')
            ->with('success', 'Booking berhasil. Menunggu konfirmasi admin.');
    }
}