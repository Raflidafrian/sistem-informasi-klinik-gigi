<x-admin-layout>

    <x-slot name="title">
        Resep Obat
    </x-slot>

    <x-slot name="header">
        Resep Obat
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        {{-- HEADER --}}
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">
                Resep Obat
            </h2>

            <p class="text-gray-500 mt-1">
                Kelola dan pantau resep obat pasien yang dibuat oleh dokter.
            </p>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200
                        text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-y border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            Jumlah Obat
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($prescriptions as $prescription)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $prescriptions->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $prescription->created_at?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $prescription->dentalRecord?->patient?->user?->name ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $prescription->dentalRecord?->doctor?->user?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $prescription->items->count() }} jenis obat
                            </td>

                            <td class="px-6 py-4">
                                <a
                                    href="{{ route('admin.prescriptions.show', $prescription) }}"
                                    class="inline-block px-3 py-2 rounded-lg
                                           bg-blue-100 text-blue-700
                                           hover:bg-blue-200 font-medium"
                                >
                                    Lihat Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-6 py-12 text-center text-gray-500">

                                <div class="text-4xl mb-3">
                                    💊
                                </div>

                                <p class="font-medium">
                                    Belum ada resep obat.
                                </p>

                                <p class="text-sm mt-1">
                                    Resep akan ditampilkan setelah dokter membuat resep untuk pasien.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-6">
            {{ $prescriptions->links() }}
        </div>

    </div>

</x-admin-layout>