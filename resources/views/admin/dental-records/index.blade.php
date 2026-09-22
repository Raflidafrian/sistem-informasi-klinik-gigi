<x-admin-layout>

    <x-slot name="title">
        Rekam Medis
    </x-slot>

    <x-slot name="header">
        Rekam Medis
    </x-slot>


    <div>

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Rekam Medis
                </h1>

                <p class="text-gray-500 mt-1">
                    Riwayat pemeriksaan pasien
                </p>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Diagnosis
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tindakan
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse ($records as $record)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold">

                                    {{ $record->patient->user->name ?? '-' }}

                                </div>

                                <div class="text-sm text-gray-500">

                                    {{ $record->patient->nik ?? '-' }}

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                {{ $record->doctor->user->name ?? '-' }}

                            </td>


                            <td class="px-6 py-4">

                                {{ $record->appointment?->appointment_date
                                    ? \Carbon\Carbon::parse(
                                        $record->appointment->appointment_date
                                    )->format('d/m/Y')
                                    : '-' }}

                            </td>


                            <td class="px-6 py-4">

                                {{ $record->diagnosis ?: '-' }}

                            </td>


                            <td class="px-6 py-4">

                                {{ $record->treatment ?: '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center">

                                <div class="text-4xl mb-3">
                                    📋
                                </div>

                                <p class="text-gray-500">
                                    Belum ada rekam medis.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-admin-layout>