
<x-admin-layout title="Detail Pasien" header="Detail Pasien">

    <div class="space-y-6">

        {{-- Tombol kembali --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Detail Pasien
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi pasien dan riwayat pelayanan klinik.
                </p>
            </div>

            <a href="{{ route('admin.patients.index') }}"
               class="rounded-lg bg-slate-100 px-4 py-2
                      text-sm font-medium text-slate-700
                      hover:bg-slate-200">
                &larr; Kembali ke Data Pasien
            </a>
        </div>

        {{-- Profil pasien --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-5 text-lg font-bold text-slate-800">
                Informasi Pasien
            </h2>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-sm text-slate-500">Nama Lengkap</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $patient->user->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-1 text-slate-800">
                        {{ $patient->user->email ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Nomor HP</p>
                    <p class="mt-1 text-slate-800">
                        {{ $patient->user->phone ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">NIK</p>
                    <p class="mt-1 text-slate-800">
                        {{ $patient->nik ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Tempat, Tanggal Lahir</p>
                    <p class="mt-1 text-slate-800">
                        {{ $patient->birth_place ?? '-' }},
                        {{ $patient->birth_date
                            ? $patient->birth_date->format('d-m-Y')
                            : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Jenis Kelamin</p>
                    <p class="mt-1 text-slate-800">
                        @if ($patient->gender === 'male')
                            Laki-laki
                        @elseif ($patient->gender === 'female')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div class="sm:col-span-2 lg:col-span-3">
                    <p class="text-sm text-slate-500">Alamat</p>
                    <p class="mt-1 whitespace-pre-line text-slate-800">
                        {{ $patient->address ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Riwayat appointment --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Riwayat Appointment
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-sm font-semibold">Tanggal</th>
                            <th class="px-5 py-3 text-sm font-semibold">Waktu</th>
                            <th class="px-5 py-3 text-sm font-semibold">Dokter</th>
                            <th class="px-5 py-3 text-sm font-semibold">Keluhan</th>
                            <th class="px-5 py-3 text-sm font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($patient->appointments->sortByDesc('appointment_date') as $appointment)
                            <tr>
                                <td class="px-5 py-4 text-sm">
                                    {{ $appointment->appointment_date
                                        ? $appointment->appointment_date->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $appointment->appointment_time ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $appointment->doctor->user->name
                                        ?? $appointment->doctor->name
                                        ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $appointment->complaint ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <span class="rounded-full bg-slate-100 px-3 py-1">
                                        {{ $appointment->status ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-5 py-8 text-center text-sm text-slate-500">
                                    Belum ada riwayat appointment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Riwayat rekam medis --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Riwayat Rekam Medis
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-sm font-semibold">Tanggal</th>
                            <th class="px-5 py-3 text-sm font-semibold">Dokter</th>
                            <th class="px-5 py-3 text-sm font-semibold">Diagnosis</th>
                            <th class="px-5 py-3 text-sm font-semibold">Tindakan</th>
                            <th class="px-5 py-3 text-sm font-semibold">Catatan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($patient->dentalRecords->sortByDesc('created_at') as $record)
                            <tr>
                                <td class="px-5 py-4 text-sm">
                                    {{ $record->appointment?->appointment_date
                                        ? $record->appointment->appointment_date->format('d-m-Y')
                                        : $record->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $record->doctor->user->name
                                        ?? $record->doctor->name
                                        ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $record->diagnosis ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $record->treatment ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    {{ $record->notes ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-5 py-8 text-center text-sm text-slate-500">
                                    Belum ada riwayat rekam medis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Riwayat tagihan --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Riwayat Tagihan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-sm font-semibold">Tanggal</th>
                            <th class="px-5 py-3 text-sm font-semibold">Total</th>
                            <th class="px-5 py-3 text-sm font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($patient->billings->sortByDesc('created_at') as $billing)
                            <tr>
                                <td class="px-5 py-4 text-sm">
                                    {{ $billing->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    Rp {{ number_format((float) $billing->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <span class="rounded-full bg-slate-100 px-3 py-1">
                                        {{ $billing->status ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="px-5 py-8 text-center text-sm text-slate-500">
                                    Belum ada tagihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-admin-layout>
