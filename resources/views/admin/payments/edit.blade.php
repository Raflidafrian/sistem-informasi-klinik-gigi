
<x-admin-layout>
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Pembayaran #{{ $payment->id }}
                </h1>

                <p class="mt-1 text-slate-500">
                    Perbarui informasi pembayaran pasien DentalCare.
                </p>
            </div>

            <a href="{{ route('admin.payments.index') }}"
               class="rounded-lg border border-slate-300
                      bg-white px-4 py-2 text-slate-700
                      hover:bg-slate-50">
                ← Kembali
            </a>
        </div>

        {{-- ERROR VALIDASI --}}
        @if($errors->any())
            <div class="rounded-xl border border-red-200
                        bg-red-50 p-5 text-red-700">
                <p class="mb-2 font-semibold">
                    Periksa kembali data berikut:
                </p>

                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INFORMASI PASIEN --}}
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="mb-5 text-lg font-bold text-slate-900">
                Informasi Tagihan
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">
                        Nama Pasien
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $payment->billing?->patient?->user?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">
                        Nomor Tagihan
                    </p>

                    <p class="mt-1 font-semibold">
                        #{{ $payment->billing_id }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">
                        Total Tagihan
                    </p>

                    <p class="mt-1 text-xl font-bold text-blue-600">
                        Rp {{ number_format(
                            $payment->billing?->total_amount ?? 0,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">
                        Status Tagihan
                    </p>

                    <p class="mt-1 font-semibold">
                        {{ ucfirst($payment->billing?->status ?? '-') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM EDIT --}}
        <form method="POST"
              action="{{ route('admin.payments.update', $payment->id) }}"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-bold text-slate-900">
                    Informasi Pembayaran
                </h2>

                <div class="space-y-6">

                    {{-- JUMLAH PEMBAYARAN --}}
                    <div>
                        <label for="amount"
                               class="mb-2 block text-sm font-semibold">
                            Jumlah Pembayaran (Rp)
                        </label>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            min="0"
                            step="0.01"
                            required
                            value="{{ old('amount', $payment->amount) }}"
                            class="w-full rounded-lg border
                                   border-slate-300 p-3
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                        >

                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div>
                        <label for="method"
                               class="mb-2 block text-sm font-semibold">
                            Metode Pembayaran
                        </label>

                        <select
                            id="method"
                            name="method"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                        >
                            <option value="cash"
                                @selected(
                                    old('method', $payment->method) === 'cash'
                                )>
                                Tunai
                            </option>

                            <option value="transfer"
                                @selected(
                                    old('method', $payment->method) === 'transfer'
                                )>
                                Transfer Bank
                            </option>
                            
                        </select>

                        @error('method')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- TANGGAL PEMBAYARAN --}}
                    <div>
                        <label for="paid_at"
                               class="mb-2 block text-sm font-semibold">
                            Tanggal dan Waktu Pembayaran
                        </label>

                        <input
                            type="datetime-local"
                            id="paid_at"
                            name="paid_at"
                            required
                            value="{{ old(
                                'paid_at',
                                $payment->paid_at?->format('Y-m-d\TH:i')
                            ) }}"
                            class="w-full rounded-lg border
                                   border-slate-300 p-3
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                        >

                        @error('paid_at')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.payments.index') }}"
                   class="rounded-lg border border-slate-300
                          bg-white px-6 py-3 font-semibold
                          text-slate-700 hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-6 py-3
                               font-semibold text-white
                               hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</x-admin-layout>
