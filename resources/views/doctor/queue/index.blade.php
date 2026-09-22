<x-doctor-layout>

    <x-slot name="title">
        Antrian Pasien
    </x-slot>

    <x-slot name="header">
        Antrian Pasien
    </x-slot>


    {{-- HEADER --}}

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-900">
            Antrian Pasien
        </h1>

        <p class="text-slate-500 mt-1">
            Daftar pasien yang memiliki jadwal pemeriksaan hari ini.
        </p>

    </div>


    {{-- FILTER TANGGAL --}}

    <div class="bg-white rounded-xl border border-slate-200 p-5 mb-6">

        <form
            method="GET"
            action="{{ route('dokter.queue.index') }}"
            class="flex items-end gap-4"
        >

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tanggal Antrian
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ $date }}"
                    class="border border-slate-300 rounded-lg px-4 py-2"
                >

            </div>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
            >
                Tampilkan
            </button>

        </form>

    </div>


    {{-- RINGKASAN --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- Total --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Total Pasien
            </p>

            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $appointments->count() }}
            </p>

        </div>


        {{-- Menunggu --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Menunggu
            </p>

            <p class="text-3xl font-bold text-yellow-600 mt-2">

                {{ $appointments->where('status', 'confirmed')->count() }}

            </p>

        </div>


        {{-- Selesai --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Selesai
            </p>

            <p class="text-3xl font-bold text-green-600 mt-2">

                {{ $appointments->where('status', 'completed')->count() }}

            </p>

        </div>

    </div>


    {{-- DAFTAR ANTRIAN --}}

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="font-bold text-lg">
                Daftar Antrian
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            No. Antrian
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jam
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Keluhan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($appointments as $appointment)

                        <tr class="hover:bg-slate-50">

                            {{-- NOMOR ANTRIAN --}}

                            <td class="px-6 py-4">

                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">

                                    {{ $loop->iteration }}

                                </div>

                            </td>


                            {{-- JAM --}}

                            <td class="px-6 py-4">

                                <span class="font-semibold">

                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                                </span>

                            </td>


                            {{-- PASIEN --}}

                            <td class="px-6 py-4">

                                <div class="font-semibold text-slate-900">

                                    {{ $appointment->patient->user->name ?? '-' }}

                                </div>

                                <div class="text-sm text-slate-500">

                                    {{ $appointment->patient->user->phone ?? '-' }}

                                </div>

                            </td>


                            {{-- KELUHAN --}}

                            <td class="px-6 py-4 text-slate-600">

                                {{ $appointment->complaint ?? 'Tidak ada keluhan' }}

                            </td>


                            {{-- STATUS --}}

                            <td class="px-6 py-4">

                                @if($appointment->status === 'pending')

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">

                                        Menunggu Konfirmasi

                                    </span>

                                @elseif($appointment->status === 'confirmed')

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">

                                        Menunggu Pemeriksaan

                                    </span>

                                @elseif($appointment->status === 'completed')

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">

                                        Selesai

                                    </span>

                                @elseif($appointment->status === 'cancelled')

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">

                                        Dibatalkan

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="px-6 py-4">

                                @if($appointment->status === 'confirmed')

                                    <a
                                        href="{{ route('dokter.dental-records.create', ['appointment_id' => $appointment->id]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium"
                                    >

                                        🩺 Periksa

                                    </a>

                                @elseif($appointment->status === 'completed')

                                    <a
                                        href="{{ route('dokter.dental-records.create', ['appointment_id' => $appointment->id]) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition"
                                    >
                                        
                                        📋 Lihat Rekam Medis
                                    </a>

                                @elseif($appointment->status === 'pending')

                                    <span class="text-yellow-600 text-sm">
                                        Menunggu konfirmasi
                                    </span>

                                @else

                                    <span class="text-red-500 text-sm">
                                        Dibatalkan
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="text-5xl mb-4">
                                    👥
                                </div>

                                <p class="text-slate-500">
                                    Belum ada pasien dalam antrian.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-doctor-layout>