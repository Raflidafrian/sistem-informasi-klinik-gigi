
<x-doctor-layout>
    <x-slot name="title">Buat Resep Obat</x-slot>
    <x-slot name="header">Buat Resep Obat</x-slot>

    <div class="mx-auto max-w-5xl space-y-6 p-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Buat Resep Obat
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Pilih rekam medis pasien dan tambahkan obat.
            </p>
        </div>

        @if($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700"
                 role="alert">
                <p class="mb-2 font-semibold">
                    Resep belum dapat disimpan:
                </p>
                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('dokter.prescriptions.store') }}"
            method="POST"
            id="prescriptionForm"
            class="space-y-6"
        >
            @csrf

            {{-- PILIH REKAM MEDIS --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

                <label
                    for="dental_record_id"
                    class="mb-2 block font-semibold text-slate-800"
                >
                    Pasien / Rekam Medis
                </label>

                <select
                    id="dental_record_id"
                    name="dental_record_id"
                    required
                    class="w-full rounded-lg border border-slate-300 p-3"
                >
                    <option value="">Pilih pasien</option>

                    @foreach($records as $record)
                        <option
                            value="{{ $record->id }}"
                            @selected(
                                old(
                                    'dental_record_id',
                                    request('dental_record_id')
                                ) == $record->id
                            )
                        >
                            {{ $record->patient?->user?->name ?? 'Pasien' }}
                            —
                            {{ $record->diagnosis ?: 'Tanpa diagnosis' }}
                        </option>
                    @endforeach
                </select>

                @if($records->isEmpty())
                    <p class="mt-3 text-sm text-amber-700">
                        Belum ada rekam medis yang dapat dibuatkan resep.
                        Lengkapi rekam medis pasien terlebih dahulu.
                    </p>
                @endif
            </div>

            {{-- DAFTAR OBAT --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Daftar Obat
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Tambahkan obat sesuai resep dokter.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="addMedicineButton"
                        onclick="addMedicine()"
                        @disabled($medicines->isEmpty())
                        class="rounded-lg bg-blue-600 px-4 py-2
                               font-semibold text-white hover:bg-blue-700
                               disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        + Tambah Obat
                    </button>
                </div>

                @if($medicines->isEmpty())
                    <div class="mb-4 rounded-lg bg-amber-50 p-4 text-sm text-amber-800">
                        Data obat belum tersedia. Hubungi admin untuk
                        menambahkan obat terlebih dahulu.
                    </div>
                @endif

                <div id="medicineRows" class="space-y-4"></div>

                <p
                    id="medicineError"
                    class="mt-3 hidden text-sm text-red-600"
                    role="alert"
                >
                    Tambahkan minimal satu obat.
                </p>
            </div>

            {{-- CATATAN --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

                <label
                    for="notes"
                    class="mb-2 block font-semibold text-slate-800"
                >
                    Catatan Tambahan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 p-3"
                    placeholder="Catatan resep (opsional)"
                >{{ old('notes') }}</textarea>
            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-wrap justify-end gap-3">

                <a
                    href="{{ route('dokter.prescriptions.index') }}"
                    class="rounded-lg border border-slate-300
                           bg-white px-5 py-3 text-slate-700
                           hover:bg-slate-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    id="submitButton"
                    @disabled($records->isEmpty() || $medicines->isEmpty())
                    class="rounded-lg bg-blue-600 px-5 py-3
                           font-semibold text-white hover:bg-blue-700
                           disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Simpan Resep
                </button>
            </div>
        </form>
    </div>

    <script>
        const medicines = @json(
            $medicines->map(fn ($medicine) => [
                'id' => $medicine->id,
                'name' => $medicine->name,
            ])->values()
        );

        const previousItems = @json(
            old('items', [
                [
                    'medicine_id' => '',
                    'dosage' => '',
                    'frequency' => '',
                    'duration' => '',
                    'quantity' => 1,
                    'usage_instruction' => '',
                ]
            ])
        );

        let rowIndex = 0;

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;');
        }

        function addMedicine(item = {}) {
            const index = rowIndex++;

            const options = medicines.map(medicine => {
                const selected =
                    String(item.medicine_id ?? '') ===
                    String(medicine.id)
                        ? 'selected'
                        : '';

                return `
                    <option
                        value="${escapeHtml(medicine.id)}"
                        ${selected}
                    >
                        ${escapeHtml(medicine.name)}
                    </option>
                `;
            }).join('');

            const row = document.createElement('div');

            row.className =
                'medicine-row rounded-xl border border-slate-200 p-4 space-y-4';

            row.innerHTML = `
                <div class="flex items-center justify-between gap-3">

                    <h3 class="font-semibold text-slate-800">
                        Obat
                    </h3>

                    <button
                        type="button"
                        class="remove-medicine text-sm font-medium
                               text-red-600 hover:underline"
                    >
                        Hapus
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Nama Obat
                        </span>

                        <select
                            name="items[${index}][medicine_id]"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                            <option value="">Pilih obat</option>
                            ${options}
                        </select>
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Dosis
                        </span>

                        <input
                            type="text"
                            name="items[${index}][dosage]"
                            value="${escapeHtml(item.dosage)}"
                            placeholder="Dosis sesuai resep"
                            maxlength="255"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Frekuensi
                        </span>

                        <input
                            type="text"
                            name="items[${index}][frequency]"
                            value="${escapeHtml(item.frequency)}"
                            placeholder="Frekuensi sesuai resep"
                            maxlength="255"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Durasi
                        </span>

                        <input
                            type="text"
                            name="items[${index}][duration]"
                            value="${escapeHtml(item.duration)}"
                            placeholder="Durasi sesuai resep"
                            maxlength="255"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Jumlah
                        </span>

                        <input
                            type="number"
                            min="1"
                            step="1"
                            name="items[${index}][quantity]"
                            value="${escapeHtml(item.quantity ?? 1)}"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-sm font-medium">
                            Aturan Pakai
                        </span>

                        <input
                            type="text"
                            name="items[${index}][usage_instruction]"
                            value="${escapeHtml(
                                item.usage_instruction ?? item.instructions ?? ''
                            )}"
                            placeholder="Aturan pakai sesuai resep"
                            maxlength="255"
                            required
                            class="w-full rounded-lg border
                                   border-slate-300 p-3"
                        >
                    </label>

                </div>
            `;

            row.querySelector('.remove-medicine')
                .addEventListener('click', () => {
                    row.remove();
                    updateMedicineNumbers();
                });

            document.getElementById('medicineRows')
                .appendChild(row);

            document.getElementById('medicineError')
                .classList.add('hidden');

            updateMedicineNumbers();
        }

        function updateMedicineNumbers() {
            const rows = document.querySelectorAll('.medicine-row');

            rows.forEach((row, index) => {
                row.querySelector('h3').textContent =
                    `Obat ${index + 1}`;
            });
        }

        document.getElementById('prescriptionForm')
            .addEventListener('submit', function (event) {

                const rows = document.querySelectorAll('.medicine-row');

                if (rows.length === 0) {
                    event.preventDefault();

                    document.getElementById('medicineError')
                        .classList.remove('hidden');

                    return;
                }

                const submitButton =
                    document.getElementById('submitButton');

                if (this.checkValidity()) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Menyimpan...';
                }
            });

        if (Array.isArray(previousItems) && previousItems.length > 0) {
            previousItems.forEach(item => addMedicine(item));
        } else {
            addMedicine();
        }
    </script>
</x-doctor-layout>
