<x-doctor-layout>
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">
                Detail Resep Obat
            </h1>

            <a href="{{ route('dokter.prescriptions.index') }}"
               class="text-blue-600 hover:underline">
                ← Kembali
            </a>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Pasien</p>
                    <p class="font-semibold">
                        {{ $prescription->patient?->user?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Dokter</p>
                    <p class="font-semibold">
                        {{ $prescription->doctor?->user?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Tanggal</p>
                    <p>
                        {{ $prescription->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Diagnosis</p>
                    <p>
                        {{ $prescription->dentalRecord?->diagnosis ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl
                    border bg-white shadow-sm">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4">Obat</th>
                        <th class="p-4">Dosis</th>
                        <th class="p-4">Frekuensi</th>
                        <th class="p-4">Durasi</th>
                        <th class="p-4">Jumlah</th>
                        <th class="p-4">Aturan Pakai</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($prescription->items as $item)
                        <tr>
                            <td class="p-4">
                                {{ $item->medicine?->name ?? '-' }}
                            </td>
                            <td class="p-4">{{ $item->dosage }}</td>
                            <td class="p-4">{{ $item->frequency }}</td>
                            <td class="p-4">{{ $item->duration }}</td>
                            <td class="p-4">{{ $item->quantity }}</td>
                            <td class="p-4">
                                {{ $item->instructions ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($prescription->notes)
            <div class="rounded-xl border bg-white p-6">
                <h2 class="mb-2 font-bold">Catatan Dokter</h2>
                <p class="whitespace-pre-line">
                    {{ $prescription->notes }}
                </p>
            </div>
        @endif
    </div>
</x-doctor-layout>