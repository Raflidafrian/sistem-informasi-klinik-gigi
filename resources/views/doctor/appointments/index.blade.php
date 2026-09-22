<x-doctor-layout>

    <x-slot name="title">
        Appointment Dokter
    </x-slot>

    <x-slot name="header">
        Appointment
    </x-slot>


    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-900">
            Appointment Pasien
        </h1>

        <p class="text-slate-500 mt-1">
            Daftar pasien yang memiliki jadwal pemeriksaan dengan Anda.
        </p>

    </div>


    {{-- FILTER TANGGAL --}}

    <div class="bg-white rounded-xl border border-slate-200 p-5 mb-6">

        <form
            method="GET"
            action="{{ route('dokter.appointments.index') }}"
            class="flex items-end gap-4"
        >

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tanggal
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


    {{-- TABLE --}}

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50 border-b">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold">
                        No
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

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-semibold">

                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                        </td>

                        <td class="px-6 py-4">

                            <div class="font-semibold">

                                {{ $appointment->patient->user->name ?? '-' }}

                            </div>

                            <div class="text-sm text-slate-500">

                                {{ $appointment->patient->user->phone ?? '-' }}

                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-600">

                            {{ $appointment->complaint ?? '-' }}

                        </td>

                        <td class="px-6 py-4">

                            @if($appointment->status === 'pending')

                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>

                            @elseif($appointment->status === 'confirmed')

                                <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    Dikonfirmasi
                                </span>

                            @elseif($appointment->status === 'completed')

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Selesai
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    Dibatalkan
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            @if($appointment->status === 'confirmed')

                                <a
                                    href="{{ route('dokter.dental-records.create', ['appointment_id' => $appointment->id]) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm"
                                >
                                    Mulai Pemeriksaan
                                </a>

                            @elseif($appointment->status === 'completed')

                                <span class="text-green-600 text-sm font-medium">
                                    Pemeriksaan selesai
                                </span>

                            @else

                                <span class="text-slate-400 text-sm">
                                    Belum dapat diperiksa
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-12 text-center"
                        >

                            <div class="text-4xl mb-3">
                                📅
                            </div>

                            <p class="text-slate-500">
                                Belum ada appointment pada tanggal ini.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-doctor-layout>