<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;

// Dashboard
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;

// Dokter
use App\Http\Controllers\Doctor\DentalRecordController;
use App\Http\Controllers\Doctor\AppointmentController;


// ======================================================
// HALAMAN UTAMA
// ======================================================

Route::get('/', function () {
    return view('welcome');
});


// ======================================================
// REDIRECT DASHBOARD BERDASARKAN ROLE
// ======================================================

Route::get('/dashboard', function () {

    $user = Auth::user();
    $role = $user?->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    }

    if ($role === 'pasien') {
        return redirect()->route('pasien.dashboard');
    }

    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


// ======================================================
// PROFILE
// ======================================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ======================================================
// ADMIN
// ======================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        // ==================================================
        // DASHBOARD ADMIN
        // ==================================================

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');


        // ==================================================
        // DATA DOKTER
        // ==================================================

        Route::resource(
            'doctors',
            \App\Http\Controllers\Admin\DoctorController::class
        )
        ->except(['show'])
        ->names('admin.doctors');


        // ==================================================
        // DATA PASIEN
        // ==================================================

        Route::resource(
            'patients',
            \App\Http\Controllers\Admin\PatientController::class
        )
        ->except(['show'])
        ->names('admin.patients');


        // ==================================================
        // JADWAL PRAKTIK
        // ==================================================

        Route::resource(
            'schedules',
            \App\Http\Controllers\Admin\DoctorScheduleController::class
        )
        ->except(['show'])
        ->names('admin.schedules');


        // ==================================================
        // APPOINTMENT
        // ==================================================

        Route::resource(
            'appointments',
            \App\Http\Controllers\Admin\AppointmentController::class
        )
        ->except(['show'])
        ->names('admin.appointments');


        // ==================================================
        // REKAM MEDIS
        // ==================================================

        Route::get(
            '/dental-records',
            [\App\Http\Controllers\Admin\DentalRecordController::class, 'index']
        )->name('admin.dental-records.index');


        // ==================================================
        // TARIF TINDAKAN
        // ==================================================

        Route::resource(
            'treatments',
            \App\Http\Controllers\Admin\TreatmentController::class
        )
        ->names('admin.treatments');


        // ==================================================
        // DATA OBAT
        // ==================================================

        Route::resource(
            'medicines',
            \App\Http\Controllers\Admin\MedicineController::class
        )
        ->names('admin.medicines');


        // ==================================================
        // TAGIHAN
        // ==================================================

        Route::resource(
            'billings',
            \App\Http\Controllers\Admin\BillingController::class
        )
        ->names('admin.billings');


        // ==================================================
        // PEMBAYARAN
        // ==================================================

        Route::resource(
            'payments',
            \App\Http\Controllers\Admin\PaymentController::class
        )
        ->except(['show'])
        ->names('admin.payments');

    });


// ======================================================
// DOKTER
// ======================================================

Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->group(function () {

        // ==================================================
        // DASHBOARD DOKTER
        // ==================================================

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('dokter.dashboard');

            
        // ==================================================
        // APPOINTMENT DOKTER
        // ==================================================

        Route::get(
            '/appointments',
            [AppointmentController::class, 'index']
        )->name('dokter.appointments.index');


        // ==================================================
        // ANTRIAN PASIEN
        // ==================================================

        Route::get(
            '/queue',
            [AppointmentController::class, 'queue']
        )->name('dokter.queue.index');


        // ==================================================
        // REKAM MEDIS
        // ==================================================

        Route::get(
            '/dental-records',
            [DentalRecordController::class, 'index']
        )->name('dokter.dental-records.index');


        // Form tambah rekam medis
        Route::get(
            '/dental-records/create',
            [DentalRecordController::class, 'create']
        )->name('dokter.dental-records.create');


        // Simpan rekam medis
        Route::post(
            '/dental-records',
            [DentalRecordController::class, 'store']
        )->name('dokter.dental-records.store');


        // ==================================================
        // ODONTOGRAM
        // ==================================================

        Route::get(
        '/odontogram',
        [DentalRecordController::class, 'odontogram']
        )->name('dokter.odontogram.index');

    });


// ======================================================
// PASIEN
// ======================================================

Route::middleware(['auth', 'role:pasien'])
    ->prefix('pasien')
    ->group(function () {

        // ==================================================
        // DASHBOARD PASIEN
        // ==================================================

        Route::get(
            '/dashboard',
            [PatientDashboardController::class, 'index']
        )->name('pasien.dashboard');


        Route::get(
            '/appointments',
            [\App\Http\Controllers\Patient\AppointmentController::class, 'index']
        )->name('pasien.appointments.index');

        Route::get(
            '/appointments/create',
            [\App\Http\Controllers\Patient\AppointmentController::class, 'create']
        )->name('pasien.appointments.create');

        Route::post(
            '/appointments',
            [\App\Http\Controllers\Patient\AppointmentController::class, 'store']
        )->name('pasien.appointments.store');

        Route::get(
            '/appointments/available-times',
            [\App\Http\Controllers\Patient\AppointmentController::class, 'availableTimes']
        )->name('pasien.appointments.available-times');

    });


// ======================================================
// AUTHENTICATION
// ======================================================

require __DIR__ . '/auth.php';