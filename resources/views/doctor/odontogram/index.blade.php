<x-doctor-layout>

    <x-slot name="title">
        Odontogram
    </x-slot>

    <x-slot name="header">
        Odontogram
    </x-slot>


    <div class="max-w-7xl mx-auto space-y-6">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">
                    🦷
                </div>

                <div>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Odontogram
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Pilih pasien untuk melakukan pemeriksaan odontogram.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
             INFORMASI
        ====================================================== --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white rounded-2xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Total Appointment
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $appointments->count() }}
                </p>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Sudah Memiliki Rekam Medis
                </p>

                <p class="text-3xl font-bold text-green-600 mt-2">

                    {{ $appointments->filter(fn ($appointment) => $appointment->dentalRecord)->count() }}

                </p>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 p-5">

                <p class="text-sm text-gray-500">
                    Belum Diperiksa
                </p>

                <p class="text-3xl font-bold text-orange-500 mt-2">

                    {{ $appointments->filter(fn ($appointment) => !$appointment->dentalRecord)->count() }}

                </p>

            </div>

        </div>


        {{-- =====================================================
             DAFTAR PASIEN
        ====================================================== --}}

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

            <div class="p-6 border-b border-gray-200">

                <h2 class="text-lg font-bold text-gray-800">
                    Daftar Pasien
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Pilih appointment untuk membuka odontogram.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Pasien
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Keluhan
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse($appointments as $appointment)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- NO --}}

                                <td class="px-6 py-4 text-sm text-gray-600">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- PASIEN --}}

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">

                                            {{ strtoupper(substr($appointment->patient->user->name ?? 'P', 0, 1)) }}

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-800">

                                                {{ $appointment->patient->user->name ?? '-' }}

                                            </p>

                                            <p class="text-xs text-gray-500">

                                                Patient ID:
                                                {{ $appointment->patient_id }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- TANGGAL --}}

                                <td class="px-6 py-4 text-sm text-gray-700">

                                    @if($appointment->appointment_date)

                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- KELUHAN --}}

                                <td class="px-6 py-4 text-sm text-gray-600">

                                    {{ $appointment->complaint ?? '-' }}

                                </td>


                                {{-- STATUS --}}

                                <td class="px-6 py-4">

                                    @if($appointment->dentalRecord)

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                                            ✓ Sudah Diperiksa

                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">

                                            Belum Diperiksa

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('dokter.dental-records.create', ['appointment_id' => $appointment->id]) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition"
                                    >

                                        🦷

                                        @if($appointment->dentalRecord)
                                            Lihat Odontogram
                                        @else
                                            Isi Odontogram
                                        @endif

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="text-5xl mb-3">
                                        🦷
                                    </div>

                                    <p class="font-semibold text-gray-700">
                                        Belum ada appointment
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Belum ada pasien yang tersedia untuk pemeriksaan odontogram.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-doctor-layout>
