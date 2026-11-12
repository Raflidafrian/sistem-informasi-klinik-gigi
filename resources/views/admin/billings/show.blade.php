<x-admin-layout>
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">
                    Detail Tagihan #{{ $billing->id }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi tagihan dan tindakan pasien.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                <a href="{{ route('admin.billings.index') }}"
                   class="rounded-lg border border-slate-200 bg-white
                          px-4 py-3 text-center text-sm font-semibold
                          text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-arrow-left mr-1"></i>
                    Kembali
                </a>

                <a href="{{ route('admin.billings.invoice', $billing->id) }}"
                   target="_blank"
                   class="rounded-lg bg-red-600 px-4 py-3 text-center
                          text-sm font-semibold text-white hover:bg-red-700">
                    <i class="fa-solid fa-file-pdf mr-1"></i>
                    Cetak Invoice
                </a>

                <a href="{{ route('admin.billings.edit', $billing->id) }}"
                   class="rounded-lg bg-blue-600 px-4 py-3 text-center
                          text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
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
        <div class="overflow-hidden rounded-xl border border-slate-200
                    bg-white shadow-sm">

            <div class="border-b border-slate-100 px-4 py-5 sm:px-6">
                <h2 class="text-lg font-bold text-slate-900">
                    Rincian Tagihan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-left text-sm">

                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="whitespace-nowrap p-4">Tindakan</th>
                            <th class="whitespace-nowrap p-4 text-center">Jumlah</th>
                            <th class="whitespace-nowrap p-4 text-right">Harga</th>
                            <th class="whitespace-nowrap p-4 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($billing->items as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-medium text-slate-800">
                                    {{ $item->treatment?->name ?? '-' }}
                                </td>

                                <td class="p-4 text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="whitespace-nowrap p-4 text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="whitespace-nowrap p-4 text-right font-semibold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-500">
                                    Belum ada rincian tindakan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="border-t border-blue-100 bg-blue-50 p-4 text-right sm:p-6">
                <p class="text-sm text-slate-600">
                    Total Tagihan
                </p>

                <p class="mt-1 break-words text-2xl font-bold text-blue-700 sm:text-3xl">
                    Rp {{ number_format($billing->total_amount, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>
</x-admin-layout>
