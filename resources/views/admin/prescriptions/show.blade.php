<x-admin-layout>

    <x-slot name="title">
        Detail Resep Obat
    </x-slot>

    <x-slot name="header">
        Detail Resep Obat
    </x-slot>

    <div class="max-w-5xl space-y-6">

        {{-- INFORMASI RESEP --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex flex-wrap justify-between gap-3 mb-6">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Detail Resep Obat
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Informasi resep yang telah dibuat oleh dokter.
                    </p>
                </div>

                <a
                    href="{{ route('admin.prescriptions.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700
                           rounded-lg hover:bg-gray-300 font-medium"
                >
                    Kembali
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <p class="text-sm text-gray-500">
                        Nama Pasien
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $prescription->dentalRecord?->patient?->user?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Nama Dokter
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $prescription->dentalRecord?->doctor?->user?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Tanggal Resep
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $prescription->created_at?->format('d F Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Diagnosis
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $prescription->dentalRecord?->diagnosis ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500">
                    Catatan Dokter
                </p>

                <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700">
                    {{ $prescription->notes ?: 'Tidak ada catatan tambahan.' }}
                </div>
            </div>

        </div>

        {{-- DAFTAR OBAT --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">

            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">
                    Daftar Obat yang Diresepkan
                </h3>

                <p class="text-gray-500 text-sm mt-1">
                    Informasi obat dan aturan penggunaannya.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold">
                                Nama Obat
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold">
                                Jumlah
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold">
                                Dosis
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold">
                                Aturan Pakai
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($prescription->items as $item)

                            <tr>

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $item->medicine?->name ?? 'Obat tidak ditemukan' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->quantity }}
                                    {{ $item->medicine?->unit ?? '' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->dosage }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->usage_instruction }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-10 text-center text-gray-500">
                                    Belum ada obat pada resep ini.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-admin-layout>
