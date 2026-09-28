
<x-admin-layout>
    <div class="mx-auto max-w-5xl space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Tagihan #{{ $billing->id }}
                </h1>

                <p class="mt-1 text-slate-500">
                    Perbarui informasi tagihan pasien.
                </p>
            </div>

            <a href="{{ route('admin.billings.index') }}"
               class="rounded-lg border bg-white px-4 py-2
                      text-slate-700 hover:bg-slate-50">
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

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('admin.billings.update', $billing->id) }}"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-bold text-slate-900">
                    Informasi Pasien
                </h2>

                <div class="grid gap-6 md:grid-cols-2">

                    {{-- PASIEN --}}
                    <div>
                        <label for="patient_id"
                               class="mb-2 block text-sm font-semibold">
                            Pasien
                        </label>

                        <select id="patient_id"
                                name="patient_id"
                                required
                                class="w-full rounded-lg border
                                       border-slate-300 p-3
                                       focus:border-blue-500
                                       focus:ring-blue-500">

                            <option value="">Pilih pasien</option>

                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    @selected(
                                        old('patient_id', $billing->patient_id)
                                        == $patient->id
                                    )>
                                    {{ $patient->user?->name ?? 'Tanpa nama' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- REKAM MEDIS --}}
                    <div>
                        <label for="dental_record_id"
                               class="mb-2 block text-sm font-semibold">
                            Rekam Medis
                        </label>

                        <select id="dental_record_id"
                                name="dental_record_id"
                                required
                                class="w-full rounded-lg border
                                       border-slate-300 p-3
                                       focus:border-blue-500
                                       focus:ring-blue-500">

                            <option value="">Pilih rekam medis</option>

                            @foreach($dentalRecords as $record)
                                <option value="{{ $record->id }}"
                                        data-patient="{{ $record->patient_id }}"
                                    @selected(
                                        old(
                                            'dental_record_id',
                                            $billing->dental_record_id
                                        ) == $record->id
                                    )>
                                    #{{ $record->id }} -
                                    {{ $record->patient?->user?->name ?? '-' }}
                                    ({{ $record->doctor?->user?->name ?? 'Dokter' }})
                                </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            Pilih rekam medis milik pasien yang dipilih.
                        </p>
                    </div>
                </div>
            </div>

            {{-- INFORMASI TAGIHAN --}}
            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-bold text-slate-900">
                    Informasi Tagihan
                </h2>

                <div class="grid gap-6 md:grid-cols-2">

                    {{-- TOTAL --}}
                    <div>
                        <label for="total_amount"
                               class="mb-2 block text-sm font-semibold">
                            Total Tagihan (Rp)
                        </label>

                        <input type="number"
                               id="total_amount"
                               name="total_amount"
                               min="0"
                               step="0.01"
                               required
                               value="{{ old('total_amount', $billing->total_amount) }}"
                               class="w-full rounded-lg border
                                      border-slate-300 p-3
                                      focus:border-blue-500
                                      focus:ring-blue-500">

                        <p class="mt-2 text-xs text-amber-700">
                            Mengubah total di sini tidak mengubah
                            harga atau jumlah pada rincian tindakan.
                        </p>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label for="status"
                               class="mb-2 block text-sm font-semibold">
                            Status Tagihan
                        </label>

                        <select id="status"
                                name="status"
                                required
                                class="w-full rounded-lg border
                                       border-slate-300 p-3
                                       focus:border-blue-500
                                       focus:ring-blue-500">

                            <option value="unpaid"
                                @selected(
                                    old('status', $billing->status)
                                    === 'unpaid'
                                )>
                                Belum Lunas
                            </option>

                            <option value="paid"
                                @selected(
                                    old('status', $billing->status)
                                    === 'paid'
                                )>
                                Lunas
                            </option>

                            <option value="cancelled"
                                @selected(
                                    old('status', $billing->status)
                                    === 'cancelled'
                                )>
                                Dibatalkan
                            </option>
                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            Perubahan status di sini tidak otomatis
                            membuat transaksi pembayaran.
                        </p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-wrap justify-end gap-3">

                <a href="{{ route('admin.billings.index') }}"
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
