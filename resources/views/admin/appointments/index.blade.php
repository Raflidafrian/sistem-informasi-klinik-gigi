<x-admin-layout>

    <x-slot name="title">
        Appointment
    </x-slot>

    <x-slot name="header">
        Appointment
    </x-slot>


    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        {{-- HEADER --}}
        <div class="p-6 flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold text-gray-900">
                    Appointment
                </h2>

                <p class="text-gray-500 mt-1">
                    Kelola janji temu pasien dengan dokter.
                </p>

            </div>


            <a
                href="{{ route('admin.appointments.create') }}"
                class="px-5 py-3 bg-blue-600 hover:bg-blue-700
                       text-white rounded-lg font-semibold transition">

                + Tambah Appointment

            </a>

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="mx-6 mb-5 bg-green-50
                        border border-green-200
                        text-green-700
                        px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-y border-gray-200">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left">
                            Jam
                        </th>

                        <th class="px-6 py-4 text-left">
                            Keluhan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($appointments as $appointment)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            {{-- PASIEN --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold">
                                    {{ $appointment->patient->user->name ?? '-' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $appointment->patient->nik ?? '-' }}
                                </div>

                            </td>


                            {{-- DOKTER --}}
                            <td class="px-6 py-4">

                                {{ $appointment->doctor->user->name ?? '-' }}

                            </td>


                            {{-- TANGGAL --}}
                            <td class="px-6 py-4">

                                {{ $appointment->appointment_date->format('d/m/Y') }}

                            </td>


                            {{-- JAM --}}
                            <td class="px-6 py-4">

                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                            </td>


                            {{-- KELUHAN --}}
                            <td class="px-6 py-4 max-w-xs">

                                {{ $appointment->complaint ?: '-' }}

                            </td>


                            {{-- STATUS --}}
                            <td class="px-6 py-4">

                                @if($appointment->status === 'pending')

                                    <span class="px-3 py-1 rounded-full
                                                 bg-yellow-100 text-yellow-700
                                                 text-sm font-medium">

                                        Pending

                                    </span>

                                @elseif($appointment->status === 'confirmed')

                                    <span class="px-3 py-1 rounded-full
                                                 bg-blue-100 text-blue-700
                                                 text-sm font-medium">

                                        Confirmed

                                    </span>

                                @elseif($appointment->status === 'completed')

                                    <span class="px-3 py-1 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-sm font-medium">

                                        Completed

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full
                                                 bg-red-100 text-red-700
                                                 text-sm font-medium">

                                        Cancelled

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    <a
                                        href="{{ route('admin.appointments.edit', $appointment) }}"
                                        class="px-3 py-2 rounded-lg
                                               bg-yellow-100 text-yellow-700
                                               hover:bg-yellow-200">

                                        Edit

                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.appointments.destroy', $appointment) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus appointment ini?');">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2 rounded-lg
                                                   bg-red-100 text-red-700
                                                   hover:bg-red-200">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-14 text-center text-gray-500">

                                <div class="text-5xl mb-3">
                                    📅
                                </div>

                                <p>
                                    Belum ada appointment.
                                </p>

                                <a
                                    href="{{ route('admin.appointments.create') }}"
                                    class="text-blue-600 hover:underline mt-2 inline-block">

                                    + Tambah Appointment

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-admin-layout>