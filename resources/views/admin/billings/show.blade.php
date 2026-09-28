
<x-admin-layout>
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Detail Tagihan #{{ $billing->id }}
                </h1>
                <p class="mt-1 text-slate-500">
                    Informasi tagihan dan tindakan pasien.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.billings.index') }}"
                   class="rounded-lg border bg-white px-4 py-2 text-slate-700">
                    ← Kembali
                </a>

                <a href="{{ route('admin.billings.edit', $billing->id) }}"
                   class="rounded-lg bg-blue-600 px-4 py-2
                          font-semibold text-white hover:bg-blue-700">
                    Edit Tagihan
                </a>
            </div>
        </div>

        {{-- INFORMASI PASIEN DAN TAGIHAN --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-lg font-bold text-slate-900">
                    Informasi Pasien
                </h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500">Nama pasien</p>
                        <p class="font-semibold">
                            {{ $billing->patient?->user?->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Email</p>
                        <p>{{ $billing->patient?->user?->email ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">ID Rekam Medis</p>
                        <p>#{{ $billing->dental_record_id }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-lg font-bold text-slate-900">
                    Informasi Tagihan
                </h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500">Tanggal</p>
                        <p>
                            {{ $billing->created_at?->format('d/m/Y H:i') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>

                        @if($billing->status === 'paid')
                            <span class="inline-block rounded-full
                                         bg-green-100 px-3 py-1
                                         text-sm font-semibold text-green-700">
                                Lunas
                            </span>
                        @elseif($billing->status === 'unpaid')
                            <span class="inline-block rounded-full
                                         bg-yellow-100 px-3 py-1
                                         text-sm font-semibold text-yellow-700">
                                Belum Lunas
                            </span>
                        @else
                            <span class="inline-block rounded-full
                                         bg-red-100 px-3 py-1
                                         text-sm font-semibold text-red-700">
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- REKAM MEDIS --}}
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="mb-5 text-lg font-bold text-slate-900">
                Rekam Medis
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <p class="mb-1 text-sm text-slate-500">Diagnosis</p>
                    <p class="whitespace-pre-line">
                        {{ $billing->dentalRecord?->diagnosis ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="mb-1 text-sm text-slate-500">Tindakan</p>
                    <p class="whitespace-pre-line">
                        {{ $billing->dentalRecord?->treatment ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- RINCIAN TINDAKAN --}}
        <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
            <div class="border-b px-6 py-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Rincian Tagihan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="p-4">Tindakan</th>
                            <th class="p-4 text-center">Jumlah</th>
                            <th class="p-4 text-right">Harga</th>
                            <th class="p-4 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($billing->items as $item)
                            <tr>
                                <td class="p-4">
                                    {{ $item->treatment?->name ?? '-' }}
                                </td>

                                <td class="p-4 text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="p-4 text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="p-4 text-right font-semibold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="p-8 text-center text-slate-500">
                                    Belum ada rincian tindakan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t bg-blue-50 p-6 text-right">
                <p class="text-sm text-slate-600">Total Tagihan</p>
                <p class="mt-1 text-3xl font-bold text-blue-700">
                    Rp {{ number_format($billing->total_amount, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>
</x-admin-layout>
