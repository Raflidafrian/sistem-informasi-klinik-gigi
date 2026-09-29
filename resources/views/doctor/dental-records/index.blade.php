
<x-doctor-layout>

    <x-slot name="title">
        Rekam Medis
    </x-slot>

    <x-slot name="header">
        Rekam Medis
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Rekam Medis Pasien
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Daftar rekam medis pasien yang ditangani oleh dokter.
                </p>
            </div>

            <a
                href="{{ route('dokter.queue.index') }}"
                class="inline-flex items-center rounded-lg bg-blue-600
                       px-4 py-2.5 text-sm font-semibold text-white
                       hover:bg-blue-700"
            >
                Lihat Antrian Pasien
            </a>
        </div>

        {{-- NOTIFIKASI BERHASIL --}}
        @if(session('success'))
            <div
                class="rounded-xl border border-green-200 bg-green-50
                       px-5 py-4 text-sm text-green-800"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- NOTIFIKASI ERROR --}}
        @if(session('error'))
            <div
                class="rounded-xl border border-red-200 bg-red-50
                       px-5 py-4 text-sm text-red-800"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif

        {{-- CARD --}}
        <div
            class="overflow-hidden rounded-xl border border-slate-200
                   bg-white shadow-sm"
        >

            <div
                class="flex flex-wrap items-center justify-between
                       gap-3 border-b border-slate-200 px-6 py-4"
            >
                <h2 class="font-semibold text-slate-800">
                    Daftar Rekam Medis
                </h2>

                <span
                    class="rounded-full bg-blue-50 px-3 py-1
                           text-sm font-semibold text-blue-700"
                >
                    Total: {{ $dentalRecords->count() }}
                </span>
            </div>

            @if($dentalRecords->isNotEmpty())

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    No
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    Pasien
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    Diagnosis
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    Tindakan
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    Tanggal
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs
                                           font-semibold uppercase
                                           text-slate-500"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            @foreach($dentalRecords as $record)

                                <tr class="hover:bg-slate-50">

                                    {{-- NOMOR --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                               text-sm text-slate-600"
                                    >
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- PASIEN --}}
                                    <td class="px-6 py-4">
                                        <div
                                            class="font-semibold
                                                   text-slate-900"
                                        >
                                            {{ $record->patient?->user?->name
                                                ?? 'Nama pasien tidak tersedia' }}
                                        </div>

                                        <div
                                            class="mt-1 text-xs
                                                   text-slate-500"
                                        >
                                            Rekam Medis #{{ $record->id }}
                                        </div>
                                    </td>

                                    {{-- DIAGNOSIS --}}
                                    <td
                                        class="max-w-xs px-6 py-4
                                               text-sm text-slate-600"
                                    >
                                        <p class="line-clamp-3">
                                            {{ $record->diagnosis ?: '-' }}
                                        </p>
                                    </td>

                                    {{-- TINDAKAN --}}
                                    <td
                                        class="max-w-xs px-6 py-4
                                               text-sm text-slate-600"
                                    >
                                        <p class="line-clamp-3">
                                            {{ $record->treatment ?: '-' }}
                                        </p>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                               text-sm text-slate-500"
                                    >
                                        {{ $record->created_at
                                            ?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4"
                                    >
                                        @if($record->appointment_id)

                                            <a
                                                href="{{ route(
                                                    'dokter.dental-records.create',
                                                    [
                                                        'appointment_id' =>
                                                            $record->appointment_id
                                                    ]
                                                ) }}"
                                                class="inline-flex items-center
                                                       rounded-lg bg-blue-600
                                                       px-4 py-2 text-sm
                                                       font-semibold text-white
                                                       hover:bg-blue-700"
                                            >
                                                Lihat / Edit
                                            </a>

                                        @else

                                            <span
                                                class="text-xs text-slate-400"
                                            >
                                                Appointment tidak tersedia
                                            </span>

                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- BELUM ADA REKAM MEDIS --}}
                <div
                    class="flex flex-col items-center justify-center
                           px-6 py-16 text-center"
                >

                    <div
                        class="mb-4 flex h-20 w-20 items-center
                               justify-center rounded-full bg-blue-50"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-10 w-10 text-blue-600"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                    </div>

                    <h3
                        class="text-lg font-semibold text-slate-800"
                    >
                        Belum Ada Rekam Medis
                    </h3>

                    <p
                        class="mt-2 max-w-md text-sm text-slate-500"
                    >
                        Belum terdapat rekam medis pasien yang
                        tersimpan untuk dokter yang sedang login.
                    </p>

                    <a
                        href="{{ route('dokter.queue.index') }}"
                        class="mt-5 inline-flex items-center rounded-lg
                               bg-blue-600 px-5 py-2.5 text-sm
                               font-semibold text-white hover:bg-blue-700"
                    >
                        Lihat Antrian Pasien
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-doctor-layout>
