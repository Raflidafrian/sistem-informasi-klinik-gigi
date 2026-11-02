<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran
     */
    public function index()
    {
        $payments = Payment::with([
            'billing.patient.user',
            'processor',
        ])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Form tambah pembayaran
     */
    public function create()
    {
        $billings = Billing::with([
            'patient.user',
            'dentalRecord',
        ])
            ->where('status', 'unpaid')
            ->latest()
            ->get();

        return view('admin.payments.create', compact('billings'));
    }

    /**
     * Simpan pembayaran baru
     */
    public function store(Request $request)
    {
        $bankNames = [
            'BCA Syariah',
            'Bank Central Asia (BCA)',
            'Bank Mandiri',
            'Bank Rakyat Indonesia (BRI)',
            'Bank Negara Indonesia (BNI)',
            'Bank Syariah Indonesia (BSI)',
            'Bank Tabungan Negara (BTN)',
            'CIMB Niaga',
            'Bank Danamon',
            'Bank Permata',
            'OCBC',
            'Maybank',
            'Bank Mega',
        ];

        $validated = $request->validate([
            'billing_id' => [
                'required',
                'integer',
                'exists:billings,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'method' => [
                'required',
                Rule::in(['cash', 'transfer']),
            ],

            'bank_name' => [
                'nullable',
                'required_if:method,transfer',
                Rule::in($bankNames),
            ],

            'paid_at' => [
                'required',
                'date',
            ],
        ], [
            'billing_id.required' => 'Silakan pilih tagihan terlebih dahulu.',
            'billing_id.exists' => 'Tagihan yang dipilih tidak ditemukan.',
            'amount.required' => 'Jumlah pembayaran wajib diisi.',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'amount.gt' => 'Jumlah pembayaran harus lebih dari nol.',
            'method.required' => 'Silakan pilih metode pembayaran.',
            'method.in' => 'Metode pembayaran tidak valid.',
            'bank_name.required_if' => 'Silakan pilih bank untuk pembayaran transfer.',
            'bank_name.in' => 'Pilihan bank tidak valid.',
            'paid_at.required' => 'Tanggal pembayaran wajib diisi.',
            'paid_at.date' => 'Format tanggal pembayaran tidak valid.',
        ]);

        try {
            DB::transaction(function () use ($validated) {

                // Ambil dan kunci tagihan agar tidak diproses bersamaan.
                $billing = Billing::whereKey($validated['billing_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                // Pastikan tagihan belum dibayar.
                if ($billing->status === 'paid') {
                    throw new \RuntimeException(
                        'Tagihan ini sudah dibayar.'
                    );
                }

                // Pastikan nominal pembayaran sesuai total tagihan.
                $paymentAmount = round((float) $validated['amount'], 2);
                $totalAmount = round((float) $billing->total_amount, 2);

                if ($paymentAmount !== $totalAmount) {
                    throw new \RuntimeException(
                        'Jumlah pembayaran harus sama dengan total tagihan yaitu Rp ' .
                        number_format($totalAmount, 0, ',', '.')
                    );
                }

                // Simpan pembayaran.
                Payment::create([
                    'billing_id' => $billing->id,
                    'amount' => $paymentAmount,
                    'method' => $validated['method'],

                    'bank_name' => $validated['method'] === 'transfer'
                        ? ($validated['bank_name'] ?? null)
                        : null,

                    'paid_at' => $validated['paid_at'],
                    'processed_by' => Auth::id(),
                ]);

                // Perbarui status tagihan.
                $billing->update([
                    'status' => 'paid',
                ]);
            });

        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_id' => $e->getMessage(),
                ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_id' => 'Tagihan tidak ditemukan.',
                ]);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil diproses.');
    }

    /**
     * Form edit pembayaran
     */
    public function edit(Payment $payment)
    {
        $payment->load([
            'billing.patient.user',
        ]);

        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * Update pembayaran
     */
    public function update(Request $request, Payment $payment)
    {
        $bankNames = [
            'BCA Syariah',
            'Bank Central Asia (BCA)',
            'Bank Mandiri',
            'Bank Rakyat Indonesia (BRI)',
            'Bank Negara Indonesia (BNI)',
            'Bank Syariah Indonesia (BSI)',
            'Bank Tabungan Negara (BTN)',
            'CIMB Niaga',
            'Bank Danamon',
            'Bank Permata',
            'OCBC',
            'Maybank',
            'Bank Mega',
        ];

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'method' => [
                'required',
                Rule::in(['cash', 'transfer', 'qris']),
            ],

            'bank_name' => [
                'nullable',
                'required_if:method,transfer',
                Rule::in($bankNames),
            ],

            'paid_at' => [
                'required',
                'date',
            ],
        ], [
            'amount.required' => 'Jumlah pembayaran wajib diisi.',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'amount.gt' => 'Jumlah pembayaran harus lebih dari nol.',
            'method.required' => 'Silakan pilih metode pembayaran.',
            'method.in' => 'Metode pembayaran tidak valid.',
            'bank_name.required_if' => 'Silakan pilih bank untuk pembayaran transfer.',
            'bank_name.in' => 'Pilihan bank tidak valid.',
            'paid_at.required' => 'Tanggal pembayaran wajib diisi.',
            'paid_at.date' => 'Format tanggal pembayaran tidak valid.',
        ]);

        $billing = $payment->billing;

        if (!$billing) {
            return back()
                ->withInput()
                ->withErrors([
                    'amount' => 'Tagihan pembayaran tidak ditemukan.',
                ]);
        }

        $amount = round((float) $validated['amount'], 2);
        $total = round((float) $billing->total_amount, 2);

        if ($amount !== $total) {
            return back()
                ->withInput()
                ->withErrors([
                    'amount' => 'Jumlah pembayaran harus sama dengan total tagihan.',
                ]);
        }

        DB::transaction(function () use ($payment, $billing, $validated, $amount) {

            $payment->update([
                'amount' => $amount,
                'method' => $validated['method'],

                'bank_name' => $validated['method'] === 'transfer'
                    ? ($validated['bank_name'] ?? null)
                    : null,

                'paid_at' => $validated['paid_at'],
            ]);

            $billing->update([
                'status' => 'paid',
            ]);
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Hapus pembayaran
     */
    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $payment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $billing = $payment->billing;

            $payment->delete();

            // Kembalikan status tagihan menjadi unpaid.
            if ($billing) {
                $billing->update([
                    'status' => 'unpaid',
                ]);
            }
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}