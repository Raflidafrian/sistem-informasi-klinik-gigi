<x-admin-layout>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                Tambah Tagihan
            </h1>

            <p class="mt-1 text-gray-500">
                Buat tagihan berdasarkan rekam medis dan tindakan pasien.
            </p>
        </div>


        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">

                <div class="font-semibold text-red-700 mb-2">
                    Terdapat kesalahan:
                </div>

                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- FORM --}}
        <form
            method="POST"
            action="{{ route('admin.billings.store') }}"
            class="space-y-6"
        >

            @csrf


            {{-- PASIEN --}}
            <div>

                <label
                    for="patient_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Pasien
                </label>

                <select
                    name="patient_id"
                    id="patient_id"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        -- Pilih Pasien --
                    </option>

                    @foreach ($patients as $patient)

                        <option
                            value="{{ $patient->id }}"
                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                        >
                            {{ $patient->user->name }}
                            @if ($patient->nik)
                                - NIK: {{ $patient->nik }}
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- REKAM MEDIS --}}
            <div>

                <label
                    for="dental_record_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Rekam Medis
                </label>

                <select
                    name="dental_record_id"
                    id="dental_record_id"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        -- Pilih Rekam Medis --
                    </option>

                    @foreach ($dentalRecords as $record)

                        <option
                            value="{{ $record->id }}"
                            {{ old('dental_record_id') == $record->id ? 'selected' : '' }}
                        >
                            Rekam Medis #{{ $record->id }}
                            -
                            {{ $record->patient->user->name }}

                            @if ($record->diagnosis)
                                - {{ $record->diagnosis }}
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- TINDAKAN --}}
            <div>

                <label
                    for="treatment_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Tindakan
                </label>

                <select
                    name="treatment_id"
                    id="treatment_id"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        -- Pilih Tindakan --
                    </option>

                    @foreach ($treatments as $treatment)

                        <option
                            value="{{ $treatment->id }}"
                            data-price="{{ $treatment->price }}"
                            {{ old('treatment_id') == $treatment->id ? 'selected' : '' }}
                        >
                            {{ $treatment->name }}
                            - Rp {{ number_format($treatment->price, 0, ',', '.') }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- JUMLAH --}}
            <div>

                <label
                    for="quantity"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Jumlah
                </label>

                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    value="{{ old('quantity', 1) }}"
                    min="1"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- TOTAL --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">

                <div class="flex items-center justify-between">

                    <span class="text-gray-600 font-medium">
                        Total Tagihan
                    </span>

                    <span
                        id="total-display"
                        class="text-2xl font-bold text-blue-600"
                    >
                        Rp 0
                    </span>

                </div>

            </div>


            {{-- STATUS --}}
            <div>

                <label
                    for="status"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Status Pembayaran
                </label>

                <select
                    name="status"
                    id="status"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="unpaid">
                        Belum Dibayar
                    </option>

                </select>

                <p class="mt-2 text-sm text-gray-500">
                    Tagihan baru secara otomatis dibuat dengan status belum dibayar.
                </p>

            </div>


            {{-- BUTTON --}}
            <div class="flex items-center gap-3 pt-4">

                <a
                    href="{{ route('admin.billings.index') }}"
                    class="px-5 py-3 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"
                >
                    Simpan Tagihan
                </button>

            </div>

        </form>

    </div>


    {{-- HITUNG TOTAL --}}
    <script>

        const treatmentSelect =
            document.getElementById('treatment_id');

        const quantityInput =
            document.getElementById('quantity');

        const totalDisplay =
            document.getElementById('total-display');


        function calculateTotal() {

            const selectedOption =
                treatmentSelect.options[
                    treatmentSelect.selectedIndex
                ];

            const price =
                Number(
                    selectedOption?.dataset.price || 0
                );

            const quantity =
                Number(quantityInput.value || 0);

            const total =
                price * quantity;


            totalDisplay.textContent =
                'Rp ' +
                total.toLocaleString('id-ID');

        }


        treatmentSelect.addEventListener(
            'change',
            calculateTotal
        );


        quantityInput.addEventListener(
            'input',
            calculateTotal
        );


        calculateTotal();

    </script>

</x-admin-layout>