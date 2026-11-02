<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran
     */
    public function index()
    {
        $payments = Payment::with([
            'billing.patient.user',
            'processor'
        ])
        ->latest()
        ->get();

        return view(
            'admin.payments.index',
            compact('payments')
        );
    }

    /**
     * Form tambah pembayaran
     */
    public function create()
    {
        $billings = Billing::with([
            'patient.user',
            'dentalRecord'
        ])
        ->where('status', 'unpaid')
        ->latest()
        ->get();

        return view(
            'admin.payments.create',
            compact('billings')
        );
    }

    /**
     * Simpan pembayaran
     */
    /**
 * Simpan pembayaran
 */

/**
 * Simpan pembayaran
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'billing_id' => 'required|exists:billings,id',

        'amount' => 'required|numeric|min:0',

        'method' => 'required|in:cash,transfer',

        'bank_name' => [
            'nullable',
            'required_if:method,transfer',
            'in:BCA Syariah,Bank Central Asia (BCA),Bank Mandiri,Bank Rakyat Indonesia (BRI),Bank Negara Indonesia (BNI),Bank Syariah Indonesia (BSI),Bank Tabungan Negara (BTN),CIMB Niaga,Bank Danamon,Bank Permata,OCBC,Maybank,Bank Mega',
        ],

        'paid_at' => 'required|date',
    ], [
        'bank_name.required_if' => 'Silakan pilih bank untuk pembayaran transfer.',
        'bank_name.in' => 'Pilihan bank tidak valid.',
    ]);

    // Ambil data tagihan
    $billing = Billing::findOrFail($validated['billing_id']);

    // Pastikan tagihan belum dibayar
    if ($billing->status === 'paid') {
        return back()
            ->withInput()
            ->withErrors([
                'billing_id' => 'Tagihan ini sudah dibayar.',
            ]);
    }

    // Pastikan jumlah pembayaran sama dengan total tagihan
    $totalAmount = (float) $billing->total_amount;
    $paymentAmount = (float) $validated['amount'];

    if (number_format($paymentAmount, 2, '.', '') !==
        number_format($totalAmount, 2, '.', '')) {

        return back()
            ->withInput()
            ->withErrors([
                'amount' =>
                    'Jumlah pembayaran harus sama dengan total tagihan yaitu Rp ' .
                    number_format($totalAmount, 0, ',', '.'),
            ]);
    }

    // Simpan pembayaran dan perbarui status tagihan
    DB::transaction(function () use ($billing, $validated, $paymentAmount) {

        Payment::create([
            'billing_id' => $billing->id,
            'amount' => $paymentAmount,
            'method' => $validated['method'],
            'bank_name' => $validated['method'] === 'transfer'
                ? $validated['bank_name']
                : null,
            'paid_at' => $validated['paid_at'],
            'processed_by' => Auth::id(),
        ]);

        $billing->update([
            'status' => 'paid',
        ]);

    });

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
            'billing.patient.user'
        ]);

        return view(
            'admin.payments.edit',
            compact('payment')
        );
    }

    

/**
 * Update pembayaran
 */
public function update(Request $request, Payment $payment)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',

        'method' => 'required|in:cash,transfer,qris',

        'bank_name' => [
            'nullable',
            'required_if:method,transfer',
            'in:BCA Syariah,Bank Central Asia (BCA),Bank Mandiri,Bank Rakyat Indonesia (BRI),Bank Negara Indonesia (BNI),Bank Syariah Indonesia (BSI),Bank Tabungan Negara (BTN),CIMB Niaga,Bank Danamon,Bank Permata,OCBC,Maybank,Bank Mega',
        ],

        'paid_at' => 'required|date',
    ], [
        'bank_name.required_if' => 'Silakan pilih bank untuk pembayaran transfer.',
        'bank_name.in' => 'Pilihan bank tidak valid.',
    ]);

    $billing = $payment->billing;

    if (!$billing) {
        return back()
            ->withInput()
            ->withErrors([
                'amount' => 'Tagihan pembayaran tidak ditemukan.',
            ]);
    }

    // Pastikan jumlah pembayaran sama dengan total tagihan.
    $amount = number_format(
        (float) $validated['amount'],
        2,
        '.',
        ''
    );

    $total = number_format(
        (float) $billing->total_amount,
        2,
        '.',
        ''
    );

    if ($amount !== $total) {
        return back()
            ->withInput()
            ->withErrors([
                'amount' => 'Jumlah pembayaran harus sama dengan total tagihan.',
            ]);
    }

    // Perbarui pembayaran dan status tagihan.
    DB::transaction(function () use ($payment, $billing, $validated) {

        $payment->update([
            'amount' => $validated['amount'],

            'method' => $validated['method'],

            'bank_name' => $validated['method'] === 'transfer'
                ? $validated['bank_name']
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
        $billing = $payment->billing;

        $payment->delete();

        // Kembalikan status tagihan menjadi unpaid
        $billing->update([
            'status' => 'unpaid',
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Pembayaran berhasil dihapus.'
            );
    }
}