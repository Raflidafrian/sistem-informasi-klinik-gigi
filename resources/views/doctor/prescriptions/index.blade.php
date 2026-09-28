<x-doctor-layout>
    <div class="space-y-6">

        <div class="flex flex-wrap items-center
                    justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Resep Obat
                </h1>
                <p class="text-slate-500 mt-1">
                    Daftar resep obat yang telah dibuat.
                </p>
            </div>

            <a href="{{ route('dokter.prescriptions.create') }}"
               class="rounded-lg bg-blue-600 px-5 py-3
                      text-white font-semibold hover:bg-blue-700">
                + Buat Resep
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl
                    border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Pasien</th>
                        <th class="p-4">Diagnosis</th>
                        <th class="p-4">Jumlah Obat</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($prescriptions as $prescription)
                        <tr>
                            <td class="p-4">
                                {{ $prescription->created_at
                                    ->format('d/m/Y') }}
                            </td>

                            <td class="p-4 font-medium">
                                {{ $prescription->patient?->user?->name
                                    ?? '-' }}
                            </td>

                            <td class="p-4">
                                {{ $prescription->dentalRecord?->diagnosis
                                    ?? '-' }}
                            </td>

                            <td class="p-4">
                                {{ $prescription->items->count() }}
                            </td>

                            <td class="p-4">
                                <a
                                    href="{{ route(
                                        'dokter.prescriptions.show',
                                        $prescription
                                    ) }}"
                                    class="font-semibold text-blue-600
                                           hover:underline"
                                >
                                    Lihat Resep
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="p-12 text-center text-slate-500">
                                Belum ada resep obat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $prescriptions->links() }}
    </div>
</x-doctor-layout>