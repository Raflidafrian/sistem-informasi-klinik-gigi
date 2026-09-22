<x-admin-layout>

    <x-slot name="title">
        Tagihan
    </x-slot>

    <x-slot name="header">
        Tagihan
    </x-slot>

    <div>

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Data Tagihan
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola tagihan pasien praktik dokter gigi.
                </p>

            </div>

            <a href="{{ route('admin.billings.create') }}"
               class="px-5 py-3 bg-blue-600 text-white
                      rounded-lg font-semibold
                      hover:bg-blue-700 transition">

                + Tambah Tagihan

            </a>

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="mb-6 bg-green-50 border border-green-200
                        text-green-700 rounded-lg p-4">

                {{ session('success') }}

            </div>

        @endif


        {{-- TABLE --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($billings as $billing)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-slate-800">

                                    {{ $billing->patient->user->name ?? '-' }}

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                Rp {{ number_format(
                                    $billing->total_amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            <td class="px-6 py-4">

                                @if($billing->status === 'paid')

                                    <span class="px-3 py-1 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-xs font-semibold">

                                        Lunas

                                    </span>

                                @elseif($billing->status === 'cancelled')

                                    <span class="px-3 py-1 rounded-full
                                                 bg-red-100 text-red-700
                                                 text-xs font-semibold">

                                        Dibatalkan

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full
                                                 bg-yellow-100 text-yellow-700
                                                 text-xs font-semibold">

                                        Belum Dibayar

                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a href="{{ route(
                                        'admin.billings.show',
                                        $billing
                                    ) }}"
                                    class="px-3 py-2 bg-blue-100
                                           text-blue-700 rounded-lg
                                           text-sm">

                                        Detail

                                    </a>


                                    <a href="{{ route(
                                        'admin.billings.edit',
                                        $billing
                                    ) }}"
                                    class="px-3 py-2 bg-yellow-100
                                           text-yellow-700 rounded-lg
                                           text-sm">

                                        Edit

                                    </a>


                                    <form method="POST"
                                          action="{{ route(
                                              'admin.billings.destroy',
                                              $billing
                                          ) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm(
                                                'Yakin ingin menghapus tagihan ini?'
                                            )"
                                            class="px-3 py-2 bg-red-100
                                                   text-red-700 rounded-lg
                                                   text-sm">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-16 text-center">

                                <div class="text-4xl mb-3">
                                    🧾
                                </div>

                                <p class="text-slate-500">
                                    Belum ada data tagihan.
                                </p>

                                <a href="{{ route(
                                    'admin.billings.create'
                                ) }}"
                                class="inline-block mt-4
                                       text-blue-600 font-semibold">

                                    + Tambah Tagihan

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-admin-layout>