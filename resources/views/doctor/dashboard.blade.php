<x-doctor-layout>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Dashboard Dokter
            </h1>

            <p class="text-slate-500 mt-1">
                Selamat datang, dr. {{ $doctor->user->name }}
            </p>
        </div>


        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- TOTAL --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Appointment Hari Ini
                        </p>

                        <p class="text-3xl font-bold text-slate-900 mt-2">
                            {{ $totalToday }}
                        </p>

                    </div>

                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">
                        📅
                    </div>

                </div>

            </div>


            {{-- PENDING --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Menunggu
                        </p>

                        <p class="text-3xl font-bold text-yellow-600 mt-2">
                            {{ $pendingToday }}
                        </p>

                    </div>

                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">
                        ⏳
                    </div>

                </div>

            </div>


            {{-- CONFIRMED --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Dikonfirmasi
                        </p>

                        <p class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $confirmedToday }}
                        </p>

                    </div>

                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">
                        ✓
                    </div>

                </div>

            </div>


            {{-- SELESAI --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Selesai
                        </p>

                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ $completedToday }}
                        </p>

                    </div>

                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">
                        ✓
                    </div>

                </div>

            </div>

        </div>


        {{-- APPOINTMENT HARI INI --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

            <div class="p-6 border-b border-slate-200">

                <h2 class="text-lg font-bold text-slate-900">
                    Appointment Hari Ini
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar pasien yang memiliki jadwal pemeriksaan hari ini.
                </p>

            </div>


            @if ($todayAppointments->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">
                                    Jam
                                </th>

                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">
                                    Pasien
                                </th>

                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">
                                    Keluhan
                                </th>

                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200">

                            @foreach ($todayAppointments as $appointment)

                                <tr>

                                    <td class="px-6 py-4">

                                        <span class="font-semibold">
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

                                            <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                                Menunggu
                                            </span>

                                        @elseif ($appointment->status === 'confirmed')

                                            <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                                Dikonfirmasi
                                            </span>

                                        @elseif ($appointment->status === 'completed')

                                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                                Selesai
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
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

                    <div class="text-4xl mb-3">
                        📅
                    </div>

                    <p class="text-slate-500">
                        Belum ada appointment hari ini.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-doctor-layout>