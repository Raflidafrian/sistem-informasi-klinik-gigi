<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DentalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrescriptionController extends Controller
{
    /**
     * Daftar resep milik dokter yang sedang login.
     */
    public function index()
    {
        $doctor = Auth::user()->doctor;

        abort_unless(
            $doctor,
            403,
            'Data dokter tidak ditemukan.'
        );

        $prescriptions = Prescription::with([
            'dentalRecord.patient.user',
            'items.medicine',
        ])
            ->whereHas('dentalRecord', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->latest()
            ->paginate(10);

        return view(
            'doctor.prescriptions.index',
            compact('prescriptions')
        );
    }

    /**
     * Form pembuatan resep obat.
     */
    public function create()
    {
        $doctor = Auth::user()->doctor;

        abort_unless(
            $doctor,
            403,
            'Data dokter tidak ditemukan.'
        );

        // Hanya rekam medis milik dokter ini
        // yang belum memiliki resep.
        $records = DentalRecord::with('patient.user')
            ->where('doctor_id', $doctor->id)
            ->whereDoesntHave('prescription')
            ->latest()
            ->get();

        $medicines = Medicine::orderBy('name')->get();

        return view(
            'doctor.prescriptions.create',
            compact('records', 'medicines')
        );
    }

    /**
     * Simpan resep beserta seluruh item obat.
     */
    public function store(Request $request)
    {
        $doctor = Auth::user()->doctor;

        abort_unless(
            $doctor,
            403,
            'Data dokter tidak ditemukan.'
        );

        $validated = $request->validate(
            [
                'dental_record_id' => [
                    'required',
                    'integer',
                    'exists:dental_records,id',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],

                'items' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'items.*.medicine_id' => [
                    'required',
                    'integer',
                    'exists:medicines,id',
                ],

                'items.*.quantity' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'items.*.dosage' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'items.*.frequency' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'items.*.duration' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'items.*.usage_instruction' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
            [
                'dental_record_id.required' =>
                    'Silakan pilih rekam medis pasien.',

                'items.required' =>
                    'Tambahkan minimal satu obat.',

                'items.min' =>
                    'Tambahkan minimal satu obat.',

                'items.*.medicine_id.required' =>
                    'Nama obat wajib dipilih.',

                'items.*.quantity.required' =>
                    'Jumlah obat wajib diisi.',

                'items.*.quantity.min' =>
                    'Jumlah obat minimal 1.',

                'items.*.dosage.required' =>
                    'Dosis obat wajib diisi.',

                'items.*.frequency.required' =>
                    'Frekuensi obat wajib diisi.',

                'items.*.duration.required' =>
                    'Durasi obat wajib diisi.',

                'items.*.usage_instruction.required' =>
                    'Aturan pakai obat wajib diisi.',
            ]
        );

        // Pemeriksaan awal agar pesan kesalahan
        // lebih mudah dipahami pengguna.
        $record = DentalRecord::query()
            ->where('doctor_id', $doctor->id)
            ->findOrFail($validated['dental_record_id']);

        if ($record->prescription()->exists()) {
            throw ValidationException::withMessages([
                'dental_record_id' =>
                    'Rekam medis ini sudah memiliki resep obat.',
            ]);
        }

        // Transaksi menjaga agar resep dan seluruh
        // item obat disimpan secara bersamaan.
        DB::transaction(function () use ($validated, $doctor) {

            // Kunci rekam medis selama penyimpanan
            // untuk mengurangi risiko resep ganda.
            $record = DentalRecord::query()
                ->where('doctor_id', $doctor->id)
                ->lockForUpdate()
                ->findOrFail($validated['dental_record_id']);

            if ($record->prescription()->exists()) {
                throw ValidationException::withMessages([
                    'dental_record_id' =>
                        'Rekam medis ini sudah memiliki resep obat.',
                ]);
            }

            $prescription = Prescription::create([
                'dental_record_id' => $record->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $items = [];

            foreach ($validated['items'] as $item) {

                // Struktur prescription_items yang
                // digunakan controller sebelumnya
                // tidak memiliki kolom frequency
                // dan duration secara terpisah.
                // Keduanya disertakan dalam aturan pakai.
                $usageInstruction = implode('; ', [
                    'Frekuensi: ' . trim($item['frequency']),
                    'Durasi: ' . trim($item['duration']),
                    'Aturan pakai: ' .
                        trim($item['usage_instruction']),
                ]);

                $items[] = [
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'dosage' => $item['dosage'],
                    'usage_instruction' => $usageInstruction,
                ];
            }

            $prescription->items()->createMany($items);
        });

        return redirect()
            ->route('dokter.prescriptions.index')
            ->with(
                'success',
                'Resep obat berhasil disimpan.'
            );
    }

    /**
     * Detail resep obat.
     */
    public function show(Prescription $prescription)
    {
        $doctor = Auth::user()->doctor;

        abort_unless(
            $doctor,
            403,
            'Data dokter tidak ditemukan.'
        );

        abort_unless(
            $prescription->dentalRecord?->doctor_id === $doctor->id,
            403,
            'Anda tidak memiliki akses ke resep ini.'
        );

        $prescription->load([
            'dentalRecord.patient.user',
            'dentalRecord.doctor.user',
            'items.medicine',
        ]);

        return view(
            'doctor.prescriptions.show',
            compact('prescription')
        );
    }
}