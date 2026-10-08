<x-doctor-layout>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Dashboard Dokter
            </h1>

            <p class="mt-1 text-slate-500">
                Selamat datang, dr. {{ $doctor->user->name }}
            </p>
        </div>


        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">


            {{-- APPOINTMENT HARI INI --}}
            <div class="rounded-xl border border-slate-200
                        bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Appointment Hari Ini
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $totalToday }}
                        </p>

                    </div>


                    <div class="flex h-12 w-12 items-center
                                justify-center rounded-xl bg-blue-100
                                text-blue-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z" />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- MENUNGGU --}}
            <div class="rounded-xl border border-slate-200
                        bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Menunggu
                        </p>

                        <p class="mt-2 text-3xl font-bold text-yellow-600">
                            {{ $pendingToday }}
                        </p>

                    </div>


                    <div class="flex h-12 w-12 items-center
                                justify-center rounded-xl bg-yellow-100
                                text-yellow-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- DIKONFIRMASI --}}
            <div class="rounded-xl border border-slate-200
                        bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Dikonfirmasi
                        </p>

                        <p class="mt-2 text-3xl font-bold text-blue-600">
                            {{ $confirmedToday }}
                        </p>

                    </div>


                    <div class="flex h-12 w-12 items-center
                                justify-center rounded-xl bg-blue-100
                                text-blue-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5.25 12.75 4.5 4.5 9-9" />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- SELESAI --}}
            <div class="rounded-xl border border-slate-200
                        bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Selesai
                        </p>

                        <p class="mt-2 text-3xl font-bold text-green-600">
                            {{ $completedToday }}
                        </p>

                    </div>


                    <div class="flex h-12 w-12 items-center
                                justify-center rounded-xl bg-green-100
                                text-green-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5.25 12.75 4.5 4.5 9-9" />

                        </svg>

                    </div>

                </div>

            </div>

        </div>


        {{-- APPOINTMENT HARI INI --}}
        <div class="rounded-xl border border-slate-200
                    bg-white shadow-sm">

            <div class="border-b border-slate-200 p-6">

                <h2 class="text-lg font-bold text-slate-900">
                    Appointment Hari Ini
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Daftar pasien yang memiliki jadwal pemeriksaan hari ini.
                </p>

            </div>


            @if ($todayAppointments->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-left
                                           text-sm font-semibold text-slate-700">
                                    Jam
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-sm font-semibold text-slate-700">
                                    Pasien
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-sm font-semibold text-slate-700">
                                    Keluhan
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-sm font-semibold text-slate-700">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200">

                            @foreach ($todayAppointments as $appointment)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="px-6 py-4">

                                        <span class="font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                        </span>

                                    </td>


                                    <td class="px-6 py-4">

                                        <p class="font-semibold text-slate-900">
                                            {{ $appointment->patient->user->name }}
                                        </p>

                                    </td>


                                    <td class="px-6 py-4 text-slate-600">

                                        {{ $appointment->complaint ?? '-' }}

                                    </td>


                                    <td class="px-6 py-4">

                                        @if ($appointment->status === 'pending')

                                            <span class="inline-flex rounded-full
                                                         bg-yellow-100 px-3 py-1
                                                         text-xs font-medium
                                                         text-yellow-700">

                                                Menunggu

                                            </span>

                                        @elseif ($appointment->status === 'confirmed')

                                            <span class="inline-flex rounded-full
                                                         bg-blue-100 px-3 py-1
                                                         text-xs font-medium
                                                         text-blue-700">

                                                Dikonfirmasi

                                            </span>

                                        @elseif ($appointment->status === 'completed')

                                            <span class="inline-flex rounded-full
                                                         bg-green-100 px-3 py-1
                                                         text-xs font-medium
                                                         text-green-700">

                                                Selesai

                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full
                                                         bg-red-100 px-3 py-1
                                                         text-xs font-medium
                                                         text-red-700">

                                                Dibatalkan

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-10 text-center">

                    <div class="mb-3 flex justify-center text-slate-400">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-10 w-10">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z" />

                        </svg>

                    </div>

                    <p class="text-slate-500">
                        Belum ada appointment hari ini.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-doctor-layout>