<x-doctor-layout>

    <x-slot name="title">
        Rekam Medis
    </x-slot>

    <x-slot name="header">
        Rekam Medis
    </x-slot>


    {{-- HEADER --}}

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-900">
            Rekam Medis Pasien
        </h1>

        <p class="text-slate-500 mt-1">
            Catat hasil pemeriksaan pasien.
        </p>

    </div>


    {{-- DATA PASIEN --}}

    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">

        <h2 class="text-lg font-bold text-slate-900 mb-5">
            Data Pasien
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>

                <p class="text-sm text-slate-500">
                    Nama Pasien
                </p>

                <p class="font-semibold text-slate-900 mt-1">

                    {{ $appointment->patient->user->name ?? '-' }}

                </p>

            </div>


            <div>

                <p class="text-sm text-slate-500">
                    No. HP
                </p>

                <p class="font-semibold text-slate-900 mt-1">

                    {{ $appointment->patient->user->phone ?? '-' }}

                </p>

            </div>


            <div>

                <p class="text-sm text-slate-500">
                    Tanggal Pemeriksaan
                </p>

                <p class="font-semibold text-slate-900 mt-1">

                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('d F Y') }}

                </p>

            </div>


            <div>

                <p class="text-sm text-slate-500">
                    Jam
                </p>

                <p class="font-semibold text-slate-900 mt-1">

                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                </p>

            </div>


            <div class="md:col-span-2">

                <p class="text-sm text-slate-500">
                    Keluhan Pasien
                </p>

                <p class="font-semibold text-slate-900 mt-1">

                    {{ $appointment->complaint ?? 'Tidak ada keluhan' }}

                </p>

            </div>

        </div>

    </div>


    {{-- FORM REKAM MEDIS --}}

    <form
        method="POST"
        action="{{ route('dokter.dental-records.store') }}"
    >

        @csrf

        <input
            type="hidden"
            name="appointment_id"
            value="{{ $appointment->id }}"
        >


        {{-- DIAGNOSIS --}}

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">

            <h2 class="text-lg font-bold text-slate-900 mb-5">
                Pemeriksaan
            </h2>


            <div class="mb-5">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Diagnosis
                </label>

                <textarea
                    name="diagnosis"
                    rows="4"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan diagnosis pasien..."
                >{{ old('diagnosis') }}</textarea>

                @error('diagnosis')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- TINDAKAN --}}

            <div class="mb-5">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tindakan
                </label>

                <textarea
                    name="treatment"
                    rows="4"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan tindakan yang dilakukan..."
                >{{ old('treatment') }}</textarea>

                @error('treatment')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- CATATAN --}}

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Catatan Dokter
                </label>

                <textarea
                    name="notes"
                    rows="4"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Catatan tambahan..."
                >{{ old('notes') }}</textarea>

                @error('notes')

                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>


        {{-- ODONTOGRAM SEMENTARA --}}

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">

            <h2 class="text-lg font-bold text-slate-900 mb-2">
                Odontogram
            </h2>

            <p class="text-sm text-slate-500 mb-5">
                Fitur odontogram interaktif akan kita sambungkan pada tahap berikutnya.
            </p>


            <div class="grid grid-cols-8 gap-2">

                @foreach([
                    18,17,16,15,14,13,12,11,
                    21,22,23,24,25,26,27,28,
                    48,47,46,45,44,43,42,41,
                    31,32,33,34,35,36,37,38
                ] as $tooth)

                    <div
                        class="border border-slate-300 rounded-lg p-3 text-center bg-slate-50"
                    >

                        <div class="text-xs text-slate-500">
                            Gigi
                        </div>

                        <div class="font-bold text-slate-900">
                            {{ $tooth }}
                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- BUTTON --}}

        <div class="flex items-center gap-3">

            <a
                href="{{ route('dokter.queue.index') }}"
                class="px-5 py-3 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300"
            >
                Kembali
            </a>


            <button
                type="submit"
                class="px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium"
            >
                💾 Simpan Rekam Medis
            </button>

        </div>

    </form>

</x-doctor-layout>