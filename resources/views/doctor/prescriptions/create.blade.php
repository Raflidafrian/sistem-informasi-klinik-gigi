<x-doctor-layout>
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Buat Resep Obat
            </h1>
            <p class="mt-1 text-slate-500">
                Pilih rekam medis pasien dan tambahkan obat.
            </p>
        </div>

        @if($errors->any())
            <div class="rounded-lg bg-red-50 p-4 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('dokter.prescriptions.store') }}"
            method="POST"
            class="space-y-6"
        >
            @csrf

            <div class="rounded-xl bg-white p-6 shadow-sm
                        border border-slate-200">
                <label class="mb-2 block font-semibold">
                    Pasien / Rekam Medis
                </label>

                <select
                    name="dental_record_id"
                    required
                    class="w-full rounded-lg border
                           border-slate-300 p-3"
                >
                    <option value="">Pilih pasien</option>

                    @foreach($records as $record)
                        <option
                            value="{{ $record->id }}"
                            @selected(
                                old('dental_record_id',
                                    request('dental_record_id'))
                                == $record->id
                            )
                        >
                            {{ $record->patient?->user?->name }}
                            — {{ $record->diagnosis ?? 'Tanpa diagnosis' }}
                        </option>
                    @endforeach
                </select>

                @if($records->isEmpty())
                    <p class="mt-3 text-amber-700">
                        Belum ada rekam medis tanpa resep.
                        Isi rekam medis pasien terlebih dahulu.
                    </p>
                @endif
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm
                        border border-slate-200">
                <div class="flex flex-wrap items-center
                            justify-between gap-3 mb-5">
                    <h2 class="text-lg font-bold">
                        Daftar Obat
                    </h2>

                    <button
                        type="button"
                        onclick="addMedicine()"
                        class="rounded-lg bg-blue-600
                               px-4 py-2 text-white"
                    >
                        + Tambah Obat
                    </button>
                </div>

                <div id="medicineRows" class="space-y-4"></div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm
                        border border-slate-200">
                <label class="mb-2 block font-semibold">
                    Catatan Tambahan
                </label>

                <textarea
                    name="notes"
                    rows="3"
                    class="w-full rounded-lg border
                           border-slate-300 p-3"
                    placeholder="Catatan resep (opsional)"
                >{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a
                    href="{{ route('dokter.prescriptions.index') }}"
                    class="rounded-lg border border-slate-300
                           px-5 py-3"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    @disabled($records->isEmpty() || $medicines->isEmpty())
                    class="rounded-lg bg-blue-600 px-5 py-3
                           font-semibold text-white
                           hover:bg-blue-700
                           disabled:opacity-50"
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
            old('items', [['medicine_id' => '']])
        );

        let rowIndex = 0;

        function addMedicine(item = {}) {
            const index = rowIndex++;

            const options = medicines.map(medicine => {
                const selected =
                    String(item.medicine_id ?? '') ===
                    String(medicine.id)
                        ? 'selected'
                        : '';

                return `<option value="${medicine.id}"
                                ${selected}>
                            ${escapeHtml(medicine.name)}
                        </option>`;
            }).join('');

            const row = document.createElement('div');

            row.className =
                'rounded-lg border border-slate-200 p-4 space-y-4';

            row.innerHTML = `
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold">Obat</h3>

                    <button type="button"
                            class="text-red-600 hover:underline"
                            onclick="this.closest('.medicine-row').remove()">
                        Hapus
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="block">
                        <span class="block mb-1">Nama Obat</span>
                        <select
                            name="items[${index}][medicine_id]"
                            required
                            class="w-full rounded-lg border p-3"
                        >
                            <option value="">Pilih obat</option>
                            ${options}
                        </select>
                    </label>

                    <label class="block">
                        <span class="block mb-1">Dosis</span>
                        <input
                            name="items[${index}][dosage]"
                            required
                            value="${escapeHtml(item.dosage ?? '')}"
                            placeholder="Contoh: 500 mg"
                            class="w-full rounded-lg border p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="block mb-1">Frekuensi</span>
                        <input
                            name="items[${index}][frequency]"
                            required
                            value="${escapeHtml(item.frequency ?? '')}"
                            placeholder="Contoh: 3 kali sehari"
                            class="w-full rounded-lg border p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="block mb-1">Durasi</span>
                        <input
                            name="items[${index}][duration]"
                            required
                            value="${escapeHtml(item.duration ?? '')}"
                            placeholder="Contoh: 5 hari"
                            class="w-full rounded-lg border p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="block mb-1">Jumlah</span>
                        <input
                            type="number"
                            min="1"
                            name="items[${index}][quantity]"
                            required
                            value="${escapeHtml(item.quantity ?? 1)}"
                            class="w-full rounded-lg border p-3"
                        >
                    </label>

                    <label class="block">
                        <span class="block mb-1">Aturan Pakai</span>
                        <input
                            name="items[${index}][instructions]"
                            value="${escapeHtml(item.instructions ?? '')}"
                            placeholder="Contoh: Sesudah makan"
                            class="w-full rounded-lg border p-3"
                        >
                    </label>
                </div>
            `;

            row.classList.add('medicine-row');

            document.getElementById('medicineRows')
                .appendChild(row);
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('"', '&quot;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;');
        }

        previousItems.forEach(item => addMedicine(item));
    </script>
</x-doctor-layout>