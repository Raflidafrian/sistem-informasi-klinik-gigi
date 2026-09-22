<x-admin-layout>

    <x-slot name="title">
        Pembayaran
    </x-slot>

    <x-slot name="header">
        Pembayaran
    </x-slot>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Data Pembayaran
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola pembayaran tagihan pasien
                </p>
            </div>

            <a href="{{ route('admin.payments.create') }}"
               class="inline-flex items-center gap-2 px-5 py-3
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
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tagihan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jumlah
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Metode
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y">

                    @forelse($payments as $payment)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="font-semibold">
                                    {{ $payment->billing->patient->user->name ?? '-' }}
                                </div>

                            </td>

                            <td class="px-6 py-4">
                                #{{ $payment->billing_id }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">

                                @if($payment->method === 'cash')
                                    Tunai
                                @elseif($payment->method === 'transfer')
                                    Transfer
                                @else
                                    QRIS
                                @endif

                            </td>

                            <td class="px-6 py-4">
                                {{ $payment->paid_at?->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a href="{{ route('admin.payments.edit', $payment) }}"
                                       class="px-3 py-2 bg-yellow-100
                                              text-yellow-700 rounded-lg
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
                                    💳
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

</x-admin-layout>