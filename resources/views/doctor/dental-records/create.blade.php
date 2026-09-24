<x-doctor-layout>

    <x-slot name="title">
        Rekam Medis & Odontogram
    </x-slot>

    <x-slot name="header">
        Rekam Medis & Odontogram
    </x-slot>


    <div class="max-w-7xl mx-auto space-y-6">

        {{-- =====================================================
             DATA PASIEN
        ====================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center gap-3 mb-5">
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                    👤
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Data Pasien
                    </h2>

                    <p class="text-sm text-gray-500">
                        Informasi pasien yang sedang diperiksa
                    </p>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">
                        Nama Pasien
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $appointment->patient->user->name ?? '-' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">
                        Tanggal Appointment
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $appointment->appointment_date ?? '-' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">
                        Keluhan
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $appointment->complaint ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('dokter.dental-records.store') }}"
            id="medicalRecordForm"
        >

            @csrf

            <input
                type="hidden"
                name="appointment_id"
                value="{{ $appointment->id }}"
            >


            {{-- =================================================
                 DIAGNOSIS
            ================================================== --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="mb-5">

                    <h2 class="text-lg font-bold text-gray-800">
                        Pemeriksaan
                    </h2>

                    <p class="text-sm text-gray-500">
                        Masukkan hasil pemeriksaan pasien.
                    </p>

                </div>


                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Diagnosis
                </label>

                <textarea
                    name="diagnosis"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Contoh: Karies dentin pada gigi 16..."
                >{{ old('diagnosis') }}</textarea>

            </div>


            {{-- =================================================
                 ODONTOGRAM
            ================================================== --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="mb-6">

                    <h2 class="text-xl font-bold text-gray-800">
                        🦷 Odontogram
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Klik permukaan gigi untuk memilih bagian yang akan diperiksa.
                    </p>

                </div>


                {{-- =================================================
                     LEGEND
                ================================================== --}}

                <div class="flex flex-wrap gap-2 mb-6">

                    <span class="px-3 py-2 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">
                        Sehat
                    </span>

                    <span class="px-3 py-2 rounded-lg bg-red-50 text-red-700 text-xs font-semibold">
                        Karies
                    </span>

                    <span class="px-3 py-2 rounded-lg bg-yellow-50 text-yellow-700 text-xs font-semibold">
                        Tambalan
                    </span>

                    <span class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 text-xs font-semibold">
                        Hilang
                    </span>

                    <span class="px-3 py-2 rounded-lg bg-purple-50 text-purple-700 text-xs font-semibold">
                        Mahkota
                    </span>

                    <span class="px-3 py-2 rounded-lg bg-orange-50 text-orange-700 text-xs font-semibold">
                        Pulpitis
                    </span>

                </div>


                {{-- =================================================
                     SELECTED SURFACE
                ================================================== --}}

                <div
                    id="selectedSurfacePanel"
                    class="mb-6 p-4 rounded-xl border border-blue-200 bg-blue-50"
                >

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>

                            <p class="text-xs text-blue-600 font-semibold uppercase">
                                Permukaan Terpilih
                            </p>

                            <p
                                id="selectedSurfaceText"
                                class="text-lg font-bold text-gray-800 mt-1"
                            >
                                Belum memilih permukaan gigi
                            </p>

                        </div>


                        <div
                            id="conditionButtons"
                            class="flex flex-wrap gap-2"
                        >

                            <button
                                type="button"
                                data-condition="sehat"
                                class="condition-btn px-3 py-2 rounded-lg bg-green-100 text-green-700 text-xs font-semibold"
                            >
                                Sehat
                            </button>

                            <button
                                type="button"
                                data-condition="karies"
                                class="condition-btn px-3 py-2 rounded-lg bg-red-100 text-red-700 text-xs font-semibold"
                            >
                                Karies
                            </button>

                            <button
                                type="button"
                                data-condition="tambalan"
                                class="condition-btn px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 text-xs font-semibold"
                            >
                                Tambalan
                            </button>

                            <button
                                type="button"
                                data-condition="hilang"
                                class="condition-btn px-3 py-2 rounded-lg bg-gray-200 text-gray-700 text-xs font-semibold"
                            >
                                Hilang
                            </button>

                            <button
                                type="button"
                                data-condition="mahkota"
                                class="condition-btn px-3 py-2 rounded-lg bg-purple-100 text-purple-700 text-xs font-semibold"
                            >
                                Mahkota
                            </button>

                            <button
                                type="button"
                                data-condition="pulpitis"
                                class="condition-btn px-3 py-2 rounded-lg bg-orange-100 text-orange-700 text-xs font-semibold"
                            >
                                Pulpitis
                            </button>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ODONTOGRAM CONTAINER
                ================================================== --}}

                <div class="overflow-x-auto">

                    <div class="min-w-[1050px]">

                        {{-- RAHANG ATAS --}}

                        <div class="text-center mb-4">

                            <span class="inline-block px-4 py-2 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold">
                                RAHANG ATAS
                            </span>

                        </div>


                        <div
                            id="upperJaw"
                            class="flex justify-center gap-2"
                        >

                            {{-- Gigi 18 - 11 --}}

                            @foreach([
                                '18','17','16','15','14','13','12','11',
                                '21','22','23','24','25','26','27','28'
                            ] as $tooth)

                                @php
                                    $isAnterior =
                                        in_array(substr($tooth, 1), ['1','2','3']);
                                @endphp

                                <div
                                    class="tooth-wrapper"
                                    data-tooth="{{ $tooth }}"
                                    data-type="{{ $isAnterior ? 'anterior' : 'posterior' }}"
                                >

                                    <div class="text-center text-xs font-bold text-gray-600 mb-1">
                                        {{ $tooth }}
                                    </div>


                                    <div class="tooth-svg-container">

                                        <svg
                                            class="tooth-svg"
                                            viewBox="0 0 100 100"
                                            aria-label="Gigi {{ $tooth }}"
                                        >

                                            {{-- MESIAL --}}

                                            <path
                                                class="tooth-surface"
                                                data-surface="mesial"
                                                d="M10 20 L30 30 L30 70 L10 80 Z"
                                            />


                                            {{-- DISTAL --}}

                                            <path
                                                class="tooth-surface"
                                                data-surface="distal"
                                                d="M70 30 L90 20 L90 80 L70 70 Z"
                                            />


                                            {{-- BUCCAL / LABIAL --}}

                                            <path
                                                class="tooth-surface"
                                                data-surface="{{ $isAnterior ? 'labial' : 'buccal' }}"
                                                d="M10 20 L50 10 L90 20 L70 30 L30 30 Z"
                                            />


                                            {{-- LINGUAL --}}

                                            <path
                                                class="tooth-surface"
                                                data-surface="lingual"
                                                d="M30 70 L70 70 L90 80 L50 90 L10 80 Z"
                                            />


                                            {{-- OCCLUSAL / INCISAL --}}

                                            <path
                                                class="tooth-surface"
                                                data-surface="{{ $isAnterior ? 'incisal' : 'occlusal' }}"
                                                d="M30 30 L70 30 L70 70 L30 70 Z"
                                            />

                                        </svg>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- PEMISAH RAHANG --}}

                        <div class="flex items-center gap-4 my-8">

                            <div class="flex-1 border-t border-dashed border-gray-300"></div>

                            <span class="text-xs text-gray-400 font-semibold">
                                MIDLINE
                            </span>

                            <div class="flex-1 border-t border-dashed border-gray-300"></div>

                        </div>


                        {{-- RAHANG BAWAH --}}

                        <div class="text-center mb-4">

                            <span class="inline-block px-4 py-2 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold">
                                RAHANG BAWAH
                            </span>

                        </div>


                        <div
                            id="lowerJaw"
                            class="flex justify-center gap-2"
                        >

                            @foreach([
                                '48','47','46','45','44','43','42','41',
                                '31','32','33','34','35','36','37','38'
                            ] as $tooth)

                                @php
                                    $isAnterior =
                                        in_array(substr($tooth, 1), ['1','2','3']);
                                @endphp

                                <div
                                    class="tooth-wrapper"
                                    data-tooth="{{ $tooth }}"
                                    data-type="{{ $isAnterior ? 'anterior' : 'posterior' }}"
                                >

                                    <div class="text-center text-xs font-bold text-gray-600 mb-1">
                                        {{ $tooth }}
                                    </div>


                                    <div class="tooth-svg-container">

                                        <svg
                                            class="tooth-svg"
                                            viewBox="0 0 100 100"
                                            aria-label="Gigi {{ $tooth }}"
                                        >

                                            <path
                                                class="tooth-surface"
                                                data-surface="mesial"
                                                d="M10 20 L30 30 L30 70 L10 80 Z"
                                            />

                                            <path
                                                class="tooth-surface"
                                                data-surface="distal"
                                                d="M70 30 L90 20 L90 80 L70 70 Z"
                                            />

                                            <path
                                                class="tooth-surface"
                                                data-surface="{{ $isAnterior ? 'labial' : 'buccal' }}"
                                                d="M10 20 L50 10 L90 20 L70 30 L30 30 Z"
                                            />

                                            <path
                                                class="tooth-surface"
                                                data-surface="lingual"
                                                d="M30 70 L70 70 L90 80 L50 90 L10 80 Z"
                                            />

                                            <path
                                                class="tooth-surface"
                                                data-surface="{{ $isAnterior ? 'incisal' : 'occlusal' }}"
                                                d="M30 30 L70 30 L70 70 L30 70 Z"
                                            />

                                        </svg>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     INPUT ODONTOGRAM
                ================================================== --}}

                <div id="odontogramInputs"></div>


                {{-- =================================================
                     RINGKASAN
                ================================================== --}}

                <div class="mt-8">

                    <h3 class="font-semibold text-gray-800 mb-3">
                        Ringkasan Kondisi Gigi
                    </h3>

                    <div
                        id="odontogramSummary"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3"
                    >

                        <div class="p-4 rounded-xl bg-gray-50 border">
                            <p class="text-xs text-gray-500">
                                Gigi diperiksa
                            </p>

                            <p
                                id="totalExamined"
                                class="text-xl font-bold text-gray-800"
                            >
                                0
                            </p>
                        </div>


                        <div class="p-4 rounded-xl bg-red-50 border border-red-100">
                            <p class="text-xs text-red-600">
                                Karies
                            </p>

                            <p
                                id="totalCaries"
                                class="text-xl font-bold text-red-700"
                            >
                                0
                            </p>
                        </div>


                        <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-100">
                            <p class="text-xs text-yellow-700">
                                Tambalan
                            </p>

                            <p
                                id="totalFillings"
                                class="text-xl font-bold text-yellow-700"
                            >
                                0
                            </p>
                        </div>


                        <div class="p-4 rounded-xl bg-gray-100 border border-gray-200">
                            <p class="text-xs text-gray-600">
                                Hilang
                            </p>

                            <p
                                id="totalMissing"
                                class="text-xl font-bold text-gray-700"
                            >
                                0
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 TREATMENT
            ================================================== --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <h2 class="text-lg font-bold text-gray-800">
                    Tindakan / Treatment
                </h2>

                <p class="text-sm text-gray-500 mb-4">
                    Masukkan tindakan yang dilakukan dokter.
                </p>

                <textarea
                    name="treatment"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Contoh: Restorasi gigi 16 menggunakan resin komposit..."
                >{{ old('treatment') }}</textarea>

            </div>


            {{-- =================================================
                 CATATAN
            ================================================== --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <h2 class="text-lg font-bold text-gray-800">
                    Catatan Dokter
                </h2>

                <p class="text-sm text-gray-500 mb-4">
                    Catatan tambahan mengenai kondisi pasien.
                </p>

                <textarea
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan catatan..."
                >{{ old('notes') }}</textarea>

            </div>


            {{-- =================================================
                 BUTTON
            ================================================== --}}

            <div class="flex flex-wrap justify-end gap-3">

                <a
                    href="{{ route('dokter.queue.index') }}"
                    class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm"
                >
                    💾 Simpan Rekam Medis
                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
         STYLE ODONTOGRAM
    ========================================================== --}}

    <style>

        .tooth-wrapper {
            width: 58px;
            flex-shrink: 0;
        }

        .tooth-svg-container {
            width: 58px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tooth-svg {
            width: 58px;
            height: 64px;
            overflow: visible;
        }

        .tooth-surface {
            fill: #ffffff;
            stroke: #64748b;
            stroke-width: 2;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .tooth-surface:hover {
            fill: #dbeafe;
            stroke: #2563eb;
            stroke-width: 3;
        }

        .tooth-surface.selected {
            fill: #bfdbfe;
            stroke: #2563eb;
            stroke-width: 3;
        }

        .tooth-surface.condition-sehat {
            fill: #dcfce7;
            stroke: #16a34a;
        }

        .tooth-surface.condition-karies {
            fill: #fee2e2;
            stroke: #dc2626;
        }

        .tooth-surface.condition-tambalan {
            fill: #fef3c7;
            stroke: #d97706;
        }

        .tooth-surface.condition-hilang {
            fill: #e5e7eb;
            stroke: #6b7280;
        }

        .tooth-surface.condition-mahkota {
            fill: #f3e8ff;
            stroke: #9333ea;
        }

        .tooth-surface.condition-pulpitis {
            fill: #ffedd5;
            stroke: #ea580c;
        }

    </style>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | State
            |--------------------------------------------------------------------------
            */

            const odontogram = {};

            let selectedTooth = null;
            let selectedSurface = null;


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const surfaces =
                document.querySelectorAll('.tooth-surface');

            const wrappers =
                document.querySelectorAll('.tooth-wrapper');

            const selectedSurfaceText =
                document.getElementById('selectedSurfaceText');

            const odontogramInputs =
                document.getElementById('odontogramInputs');


            /*
            |--------------------------------------------------------------------------
            | Condition
            |--------------------------------------------------------------------------
            */

            const conditions = {

                sehat: {
                    label: 'Sehat',
                    className: 'condition-sehat'
                },

                karies: {
                    label: 'Karies',
                    className: 'condition-karies'
                },

                tambalan: {
                    label: 'Tambalan',
                    className: 'condition-tambalan'
                },

                hilang: {
                    label: 'Hilang',
                    className: 'condition-hilang'
                },

                mahkota: {
                    label: 'Mahkota',
                    className: 'condition-mahkota'
                },

                pulpitis: {
                    label: 'Pulpitis',
                    className: 'condition-pulpitis'
                }

            };


            /*
            |--------------------------------------------------------------------------
            | Format nama permukaan
            |--------------------------------------------------------------------------
            */

            function surfaceLabel(surface) {

                const labels = {

                    mesial: 'Mesial',

                    distal: 'Distal',

                    occlusal: 'Oklusal',

                    incisal: 'Insisal',

                    buccal: 'Bukal',

                    labial: 'Labial',

                    lingual: 'Lingual'

                };

                return labels[surface] || surface;

            }


            /*
            |--------------------------------------------------------------------------
            | Pilih permukaan
            |--------------------------------------------------------------------------
            */

            function selectSurface(surfaceElement) {

                surfaces.forEach(function (surface) {

                    surface.classList.remove('selected');

                });


                surfaceElement.classList.add('selected');


                const wrapper =
                    surfaceElement.closest('.tooth-wrapper');


                selectedTooth =
                    wrapper.dataset.tooth;


                selectedSurface =
                    surfaceElement.dataset.surface;


                selectedSurfaceText.textContent =
                    `Gigi ${selectedTooth} — ${surfaceLabel(selectedSurface)}`;

            }


            /*
            |--------------------------------------------------------------------------
            | Simpan data ke hidden input
            |--------------------------------------------------------------------------
            */

            function createInput(
                tooth,
                surface,
                condition
            ) {

                const name =
                    `odontogram_data[${tooth}][${surface}]`;


                let input =
                    document.querySelector(
                        `input[name="${name}"]`
                    );


                if (!input) {

                    input =
                        document.createElement('input');

                    input.type = 'hidden';

                    input.name = name;

                    odontogramInputs.appendChild(input);

                }


                input.value = condition;

            }


            /*
            |--------------------------------------------------------------------------
            | Set condition
            |--------------------------------------------------------------------------
            */

            function setCondition(condition) {

                if (
                    !selectedTooth ||
                    !selectedSurface
                ) {

                    alert(
                        'Silakan pilih permukaan gigi terlebih dahulu.'
                    );

                    return;

                }


                if (!conditions[condition]) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Buat struktur data
                |--------------------------------------------------------------------------
                */

                if (!odontogram[selectedTooth]) {

                    odontogram[selectedTooth] = {};

                }


                odontogram[selectedTooth][selectedSurface] =
                    condition;


                /*
                |--------------------------------------------------------------------------
                | Hidden input
                |--------------------------------------------------------------------------
                */

                createInput(
                    selectedTooth,
                    selectedSurface,
                    condition
                );


                /*
                |--------------------------------------------------------------------------
                | Update tampilan SVG
                |--------------------------------------------------------------------------
                */

                surfaces.forEach(function (surface) {

                    const wrapper =
                        surface.closest('.tooth-wrapper');


                    if (
                        wrapper.dataset.tooth ===
                        selectedTooth &&

                        surface.dataset.surface ===
                        selectedSurface
                    ) {

                        Object.values(conditions)
                            .forEach(function (item) {

                                surface.classList.remove(
                                    item.className
                                );

                            });


                        surface.classList.add(
                            conditions[condition].className
                        );

                    }

                });


                updateSummary();

            }


            /*
            |--------------------------------------------------------------------------
            | Event klik permukaan
            |--------------------------------------------------------------------------
            */

            surfaces.forEach(function (surface) {

                surface.addEventListener(
                    'click',
                    function () {

                        selectSurface(surface);

                    }
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Event condition
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.condition-btn')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            setCondition(
                                button.dataset.condition
                            );

                        }
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | Ringkasan
            |--------------------------------------------------------------------------
            */

            function updateSummary() {

                let examined = 0;

                let caries = 0;

                let fillings = 0;

                let missing = 0;


                Object.values(odontogram)
                    .forEach(function (tooth) {

                        Object.values(tooth)
                            .forEach(function (condition) {

                                examined++;


                                if (
                                    condition === 'karies'
                                ) {

                                    caries++;

                                }


                                if (
                                    condition === 'tambalan'
                                ) {

                                    fillings++;

                                }


                                if (
                                    condition === 'hilang'
                                ) {

                                    missing++;

                                }

                            });

                    });


                document.getElementById(
                    'totalExamined'
                ).textContent = examined;


                document.getElementById(
                    'totalCaries'
                ).textContent = caries;


                document.getElementById(
                    'totalFillings'
                ).textContent = fillings;


                document.getElementById(
                    'totalMissing'
                ).textContent = missing;

            }

        });

    </script>

</x-doctor-layout>
