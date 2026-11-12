<x-admin-layout>

    <x-slot name="title">
        Tambah Pembayaran
    </x-slot>

    <x-slot name="header">
        Tambah Pembayaran
    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm border p-8">

            {{-- HEADER --}}
            <div class="mb-8">

                <h1 class="text-2xl font-bold text-slate-900">
                    Tambah Pembayaran
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Proses pembayaran tagihan pasien
                </p>

            </div>

            {{-- ERROR VALIDATION --}}
            @if($errors->any())

                <div class="mb-6 bg-red-50 border border-red-200
                            text-red-700 rounded-lg p-4">

                    <p class="font-semibold mb-2">
                        Terjadi kesalahan:
                    </p>

                    <ul class="list-disc ml-5 text-sm">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('admin.payments.store') }}">

                @csrf

                {{-- TAGIHAN --}}
                <div class="mb-6">

                    <label for="billing_id"
                           class="block text-sm font-medium text-slate-700 mb-2">

                        Tagihan

                    </label>

                    <select
                        name="billing_id"
                        id="billing_id"
                        required
                        class="w-full rounded-lg border-slate-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            -- Pilih Tagihan --
                        </option>

                        @foreach($billings as $billing)

                            <option
                                value="{{ $billing->id }}"
                                data-total="{{ $billing->total_amount }}"
                                data-patient="{{ $billing->patient->user->name ?? '-' }}"
                                {{ old('billing_id') == $billing->id ? 'selected' : '' }}
                            >

                                #{{ $billing->id }}
                                -
                                {{ $billing->patient->user->name ?? 'Pasien' }}
                                -
                                Rp {{ number_format($billing->total_amount, 0, ',', '.') }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- INFORMASI TAGIHAN --}}
                <div id="billing-info"
                     class="hidden mb-6 bg-blue-50
                            border border-blue-200
                            rounded-lg p-5">

                    <h3 class="font-semibold text-blue-900 mb-4">
                        Informasi Tagihan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <p class="text-sm text-slate-500">
                                Nama Pasien
                            </p>

                            <p id="patient-name"
                               class="font-semibold text-slate-900">
                                -
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-slate-500">
                                Total Tagihan
                            </p>

                            <p id="billing-total"
                               class="font-semibold text-blue-700">
                                Rp 0
                            </p>

                        </div>

                    </div>

                </div>

                {{-- JUMLAH --}}
                <div class="mb-6">

                    <label for="amount"
                           class="block text-sm font-medium text-slate-700 mb-2">

                        Jumlah Pembayaran

                    </label>

                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        value="{{ old('amount') }}"
                        min="0"
                        required
                        class="w-full rounded-lg border-slate-300
                               focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Jumlah pembayaran"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Nominal akan otomatis mengikuti total tagihan.
                    </p>

                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="mb-6">

                    <label class="mb-3 block text-sm font-semibold text-slate-700">
                        Metode Pembayaran
                    </label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- TUNAI --}}
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl
                                      border border-slate-200 p-4 transition
                                      hover:border-blue-400 has-[:checked]:border-blue-500
                                      has-[:checked]:bg-blue-50">

                            <input
                                type="radio"
                                name="method"
                                value="cash"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                {{ old('method', 'cash') === 'cash' ? 'checked' : '' }}
                            >

                            <span class="flex h-11 w-11 items-center justify-center
                                         rounded-lg bg-green-100 text-green-700">
                                <i class="fa-solid fa-money-bill-wave text-xl"></i>
                            </span>

                            <span>
                                <span class="block font-semibold text-slate-800">
                                    Tunai
                                </span>
                                <span class="text-xs text-slate-500">
                                    Pembayaran secara langsung
                                </span>
                            </span>

                        </label>

                        {{-- TRANSFER BANK --}}
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl
                                      border border-slate-200 p-4 transition
                                      hover:border-blue-400 has-[:checked]:border-blue-500
                                      has-[:checked]:bg-blue-50">

                            <input
                                type="radio"
                                name="method"
                                value="transfer"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                {{ old('method') === 'transfer' ? 'checked' : '' }}
                            >

                            <span class="flex h-11 w-11 items-center justify-center
                                         rounded-lg bg-blue-100 text-blue-700">
                                <i class="fa-solid fa-building-columns text-xl"></i>
                            </span>

                            <span>
                                <span class="block font-semibold text-slate-800">
                                    Transfer Bank
                                </span>
                                <span class="text-xs text-slate-500">
                                    Pembayaran melalui rekening bank
                                </span>
                            </span>

                        </label>

                    </div>

                </div>

                {{-- PILIHAN CASH --}}
                <div id="cash-option"
                     class="mb-6 hidden rounded-xl border border-green-200
                            bg-green-50 p-4">

                    <p class="mb-3 text-sm font-semibold text-green-800">
                        Pilihan Pembayaran Tunai
                    </p>

                    <label class="flex cursor-pointer items-center gap-3 rounded-lg
                                  border border-green-200 bg-white p-4">

                        <input
                            type="checkbox"
                            id="cash-checkbox"
                            checked
                            disabled
                            class="h-4 w-4 rounded text-green-600"
                        >

                        <span class="flex h-10 w-10 items-center justify-center
                                     rounded-lg bg-green-100 text-green-700">
                            <i class="fa-solid fa-wallet"></i>
                        </span>

                        <span>
                            <span class="block font-semibold text-slate-800">
                                Cash (Uang Tunai)
                            </span>
                            <span class="text-xs text-slate-500">
                                Pembayaran dilakukan secara tunai.
                            </span>
                        </span>

                    </label>

                </div>

                {{-- PILIHAN BANK --}}
                <div id="bank-option"
                     class="mb-6 hidden rounded-xl border border-blue-200
                            bg-blue-50 p-4">

                    <label for="bank_name"
                           class="mb-2 block text-sm font-semibold text-blue-900">

                        Pilih Bank Tujuan

                    </label>

                    <select
                        name="bank_name"
                        id="bank_name"
                        class="w-full rounded-lg border-slate-300 bg-white
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            -- Pilih Bank --
                        </option>

                        @php
                            $banks = [
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
                        @endphp

                        @foreach($banks as $bank)
                            <option
                                value="{{ $bank }}"
                                {{ old('bank_name') === $bank ? 'selected' : '' }}
                            >
                                {{ $bank }}
                            </option>
                        @endforeach

                    </select>

                    <p class="mt-2 text-xs text-blue-700">
                        Silakan pilih bank yang digunakan pasien untuk melakukan transfer.
                    </p>

                    @error('bank_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- TANGGAL PEMBAYARAN --}}
                <div class="mb-8">

                    <label for="paid_at"
                           class="block text-sm font-medium text-slate-700 mb-2">

                        Tanggal Pembayaran

                    </label>

                    <input
                        type="datetime-local"
                        name="paid_at"
                        id="paid_at"
                        value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}"
                        required
                        class="w-full rounded-lg border-slate-300
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                {{-- BUTTON --}}
                <div class="flex items-center gap-3">

                    <a href="{{ route('admin.payments.index') }}"
                       class="px-5 py-3 bg-slate-200
                              text-slate-700 rounded-lg
                              hover:bg-slate-300 transition">

                        Kembali

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600
                               text-white rounded-lg
                               hover:bg-blue-700 transition">

                        Simpan Pembayaran

                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- JAVASCRIPT --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const billingSelect = document.getElementById('billing_id');
            const billingInfo = document.getElementById('billing-info');
            const patientName = document.getElementById('patient-name');
            const billingTotal = document.getElementById('billing-total');
            const amountInput = document.getElementById('amount');

            const methodInputs = document.querySelectorAll(
                'input[name="method"]'
            );

            const cashOption = document.getElementById('cash-option');
            const bankOption = document.getElementById('bank-option');
            const bankSelect = document.getElementById('bank_name');

            // Informasi tagihan
            billingSelect.addEventListener('change', function () {

                const selected =
                    billingSelect.options[billingSelect.selectedIndex];

                if (!billingSelect.value) {
                    billingInfo.classList.add('hidden');
                    patientName.textContent = '-';
                    billingTotal.textContent = 'Rp 0';
                    amountInput.value = '';
                    return;
                }

                const total = parseFloat(selected.dataset.total || 0);
                const patient = selected.dataset.patient || '-';

                patientName.textContent = patient;

                billingTotal.textContent =
                    'Rp ' + total.toLocaleString('id-ID');

                amountInput.value = total;

                billingInfo.classList.remove('hidden');
            });

            // Pilihan metode pembayaran
            function updatePaymentMethod() {

                const selectedMethod = document.querySelector(
                    'input[name="method"]:checked'
                )?.value;

                if (selectedMethod === 'cash') {

                    cashOption.classList.remove('hidden');
                    bankOption.classList.add('hidden');

                    bankSelect.required = false;
                    bankSelect.value = '';

                } else if (selectedMethod === 'transfer') {

                    cashOption.classList.add('hidden');
                    bankOption.classList.remove('hidden');

                    bankSelect.required = true;

                } else {

                    cashOption.classList.add('hidden');
                    bankOption.classList.add('hidden');

                    bankSelect.required = false;
                }
            }

            methodInputs.forEach(function (input) {
                input.addEventListener('change', updatePaymentMethod);
            });

            // Pulihkan pilihan setelah validasi gagal
            updatePaymentMethod();

            // Tampilkan informasi tagihan jika sebelumnya sudah dipilih
            if (billingSelect.value) {
                billingSelect.dispatchEvent(new Event('change'));
            }

        });

    </script>

</x-admin-layout>
