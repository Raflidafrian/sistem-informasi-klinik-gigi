
<x-admin-layout>

    <x-slot name="title">
        Pembayaran
    </x-slot>

    <x-slot name="header">
        Pembayaran
    </x-slot>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center
                    sm:justify-between gap-4">

            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
                    Data Pembayaran
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola pembayaran tagihan pasien
                </p>
            </div>

            <a href="{{ route('admin.payments.create') }}"
               class="inline-flex w-full sm:w-auto justify-center
                      items-center gap-2 px-5 py-3
                      bg-blue-600 text-white rounded-lg
                      hover:bg-blue-700 transition">

                <span>+</span>
                <span>Tambah Pembayaran</span>

            </a>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="bg-green-100 text-green-700
                        border border-green-200
                        px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow-sm border
                    border-slate-200 overflow-hidden">

            {{-- Petunjuk khusus mobile --}}
            <div class="px-4 py-3 bg-slate-50 border-b
                        text-xs text-slate-500 sm:hidden">

                <i class="fa-solid fa-arrows-left-right mr-1"></i>
                Geser tabel ke samping untuk melihat seluruh data.

            </div>

            <div class="w-full overflow-x-auto">

                <table class="w-full min-w-[900px]">

                    <thead class="bg-slate-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Pasien
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Tagihan
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Jumlah
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Metode
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($payments as $payment)

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-800">
                                        {{ $payment->billing->patient->user->name ?? '-' }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm">
                                    #{{ $payment->billing_id }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-sm whitespace-nowrap">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-sm">

                                    @if($payment->method === 'cash')

                                        <span class="inline-flex items-center rounded-full
                                                     bg-green-100 px-3 py-1
                                                     text-xs font-semibold text-green-700">
                                            Tunai / Cash
                                        </span>

                                    @elseif($payment->method === 'transfer')

                                        <span class="inline-flex items-center rounded-full
                                                     bg-blue-100 px-3 py-1
                                                     text-xs font-semibold text-blue-700">
                                            Transfer
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <a href="{{ route('admin.payments.edit', $payment) }}"
                                           class="px-3 py-2 bg-yellow-100
                                                  text-yellow-700 rounded-lg
                                                  text-sm font-medium
                                                  hover:bg-yellow-200">

                                            Edit

                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.payments.destroy', $payment) }}"
                                              onsubmit="return confirm('Hapus pembayaran ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-2 bg-red-100
                                                           text-red-700 rounded-lg
                                                           text-sm font-medium
                                                           hover:bg-red-200">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-6 py-12 text-center">

                                    <div class="text-4xl mb-3">

                                    </div>

                                    <p class="text-slate-500">
                                        Belum ada data pembayaran.
                                    </p>

                                    <a href="{{ route('admin.payments.create') }}"
                                       class="inline-block mt-3 text-blue-600 hover:underline">

                                        + Tambah Pembayaran

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-admin-layout>
