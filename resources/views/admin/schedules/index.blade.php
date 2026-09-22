<x-admin-layout>

    <x-slot name="title">
        Jadwal Praktik
    </x-slot>

    <x-slot name="header">
        Jadwal Praktik
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        {{-- HEADER --}}
        <div class="p-6 flex items-center justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Jadwal Praktik
                </h2>

                <p class="text-gray-500 mt-1">
                    Kelola jadwal praktik dokter
                </p>
            </div>

            <a href="{{ route('admin.schedules.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white
                      px-5 py-3 rounded-lg font-semibold transition">

                + Tambah Jadwal

            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="mx-6 mb-4 bg-green-50 border border-green-200
                        text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-y border-gray-200">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Hari
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jam Praktik
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($schedules as $schedule)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold">
                                    {{ $schedule->doctor->user->name ?? '-' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $schedule->doctor->specialization ?? '-' }}
                                </div>

                            </td>


                            <td class="px-6 py-4">

                                @php
                                    $days = [
                                        1 => 'Senin',
                                        2 => 'Selasa',
                                        3 => 'Rabu',
                                        4 => 'Kamis',
                                        5 => 'Jumat',
                                        6 => 'Sabtu',
                                        7 => 'Minggu',
                                    ];
                                @endphp

                                {{ $days[$schedule->day_of_week] ?? '-' }}

                            </td>


                            <td class="px-6 py-4">

                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}

                            </td>


                            <td class="px-6 py-4">

                                @if($schedule->is_active)

                                    <span class="px-3 py-1 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-sm font-medium">

                                        Aktif

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full
                                                 bg-red-100 text-red-700
                                                 text-sm font-medium">

                                        Tidak Aktif

                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                       class="px-3 py-2 rounded-lg
                                              bg-yellow-100 text-yellow-700
                                              hover:bg-yellow-200">

                                        Edit

                                    </a>


                                    <form method="POST"
                                          action="{{ route('admin.schedules.destroy', $schedule) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
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

                            <td colspan="6"
                                class="px-6 py-12 text-center text-gray-500">

                                <div class="text-4xl mb-3">
                                    🗓️
                                </div>

                                <p>
                                    Belum ada jadwal praktik.
                                </p>

                                <a href="{{ route('admin.schedules.create') }}"
                                   class="text-blue-600 hover:underline mt-2 inline-block">

                                    + Tambah Jadwal

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-admin-layout>