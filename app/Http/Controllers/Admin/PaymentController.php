<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
public function store(Request $request)
{
    $validated = $request->validate([
        'billing_id' => 'required|exists:billings,id',
        'amount' => 'required|numeric|min:0',
        'method' => 'required|in:cash,transfer,qris',
        'paid_at' => 'required|date',
    ]);

    // Ambil data tagihan
    $billing = Billing::findOrFail(
        $validated['billing_id']
    );

    // Pastikan tagihan belum dibayar
    if ($billing->status === 'paid') {
        return back()
            ->withInput()
            ->withErrors([
                'billing_id' => 'Tagihan ini sudah dibayar.'
            ]);
    }

    // Ambil total tagihan sebagai angka
    $totalAmount = (float) $billing->total_amount;

    // Ambil jumlah pembayaran sebagai angka
    $paymentAmount = (float) $validated['amount'];

    // Pastikan jumlah pembayaran sama dengan total tagihan
    if ($paymentAmount !== $totalAmount) {

        return back()
            ->withInput()
            ->withErrors([
                'amount' =>
                    'Jumlah pembayaran harus sama dengan total tagihan yaitu Rp ' .
                    number_format(
                        $totalAmount,
                        0,
                        ',',
                        '.'
                    )
            ]);
    }

    // Simpan pembayaran
    Payment::create([
        'billing_id' => $billing->id,
        'amount' => $paymentAmount,
        'method' => $validated['method'],
        'paid_at' => $validated['paid_at'],
        'processed_by' => Auth::id(),
    ]);

    // Ubah status tagihan menjadi lunas
    $billing->update([
        'status' => 'paid',
    ]);

    return redirect()
        ->route('admin.payments.index')
        ->with(
            'success',
            'Pembayaran berhasil diproses.'
        );
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
    public function update(
        Request $request,
        Payment $payment
    ) {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,transfer,qris',
            'paid_at' => 'required|date',
        ]);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Pembayaran berhasil diperbarui.'
            );
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