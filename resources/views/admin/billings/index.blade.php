
<x-admin-layout>

    <x-slot name="title">
        Tagihan
    </x-slot>

    <x-slot name="header">
        Tagihan
    </x-slot>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">
                    Data Tagihan
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola tagihan pasien praktik dokter gigi.
                </p>
            </div>

            <a href="{{ route('admin.billings.create') }}"
               class="inline-flex w-full items-center justify-center rounded-lg
                      bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                      transition hover:bg-blue-700 sm:w-auto">

                <i class="fa-solid fa-plus mr-2"></i>
                Tambah Tagihan

            </a>

        </div>

        {{-- SEARCH TAGIHAN --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <form action="{{ route('admin.billings.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
            </div>
            
            <input
                type="text"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Cari nama pasien atau nomor tagihan..."
                class="w-full rounded-lg border border-slate-300 py-3 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
            
            <div class="grid grid-cols-2 gap-2 sm:flex">
                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="fa-solid fa-search mr-1"></i>
                        Cari
                    </button>
                
                <a href="{{ route('admin.billings.index') }}" class="rounded-lg border border-slate-300 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-rotate-left mr-1"></i>
                        Reset
                </a>
            </div>
        </form>
    
        @if(!empty($search))
        
        <p class="mt-3 text-sm text-slate-500">
            Hasil pencarian untuk:
        <span class="font-semibold text-slate-700">
            "{{ $search }}"
        </span>
        
        — {{ $billings->count() }} tagihan ditemukan.
        </p>

    @endif

</div>

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="rounded-lg border border-green-200 bg-green-50
                        p-4 text-sm text-green-700">

                {{ session('success') }}

            </div>

        @endif


        {{-- ====================================== --}}
        {{-- TAMPILAN DESKTOP / TABLET --}}
        {{-- ====================================== --}}

        <div class="hidden overflow-hidden rounded-xl border border-slate-200
                    bg-white shadow-sm md:block">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[750px]">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Pasien
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Total
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($billings as $billing)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $billing->patient->user->name ?? '-' }}
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-700">
                                    Rp {{ number_format($billing->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4">

                                    @if($billing->status === 'paid')

                                        <span class="inline-flex rounded-full bg-green-100
                                                     px-3 py-1 text-xs font-semibold text-green-700">
                                            Lunas
                                        </span>

                                    @elseif($billing->status === 'cancelled')

                                        <span class="inline-flex rounded-full bg-red-100
                                                     px-3 py-1 text-xs font-semibold text-red-700">
                                            Dibatalkan
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-yellow-100
                                                     px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Belum Dibayar
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <a href="{{ route('admin.billings.show', $billing) }}"
                                           class="rounded-lg bg-blue-100 px-3 py-2
                                                  text-sm font-medium text-blue-700
                                                  hover:bg-blue-200">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.billings.edit', $billing) }}"
                                           class="rounded-lg bg-yellow-100 px-3 py-2
                                                  text-sm font-medium text-yellow-700
                                                  hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.billings.destroy', $billing) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus tagihan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-100 px-3 py-2
                                                           text-sm font-medium text-red-700
                                                           hover:bg-red-200">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty
                        
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                
                                @if(!empty($search))
                                
                                <div class="flex flex-col items-center">
                                <i class="fa-solid fa-magnifying-glass-minus mb-3 text-4xl text-slate-300"></i>
                                <h3 class="font-semibold text-slate-700">
                                    Tagihan Tidak Ditemukan
                                </h3>
                                
                                <p class="mt-2 text-sm text-slate-500">
                                    Tagihan dengan kata kunci "{{ $search }}" tidak ditemukan.
                                </p>
                                
                                <p class="mt-1 text-xs text-slate-400">
                                    Silakan periksa kembali kata kunci pencarian Anda.
                                </p>
                                
                                <a href="{{ route('admin.billings.index') }}" class="mt-4 font-semibold text-blue-600 hover:text-blue-700">
                                    Reset Pencarian
                                </a>
                            </div>
                        @else
                            <div class="text-4xl mb-3">🧾</div>
                            <p class="text-slate-500">
                                Belum ada data tagihan.
                            </p>
                            
                            <a href="{{ route('admin.billings.create') }}" class="mt-4 inline-block font-semibold text-blue-600">
                                + Tambah Tagihan
                            </a>
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>


        {{-- ====================================== --}}
        {{-- TAMPILAN MOBILE --}}
        {{-- ====================================== --}}

        <div class="space-y-4 md:hidden">

            @forelse($billings as $billing)

                <div class="overflow-hidden rounded-xl border border-slate-200
                            bg-white shadow-sm">

                    {{-- CARD HEADER --}}
                    <div class="flex items-start justify-between gap-3
                                border-b border-slate-100 p-4">

                        <div class="min-w-0">

                            <p class="text-xs font-medium text-slate-500">
                                Tagihan #{{ $billing->id }}
                            </p>

                            <h3 class="mt-1 break-words text-base font-bold text-slate-800">
                                {{ $billing->patient->user->name ?? '-' }}
                            </h3>

                        </div>

                        <div class="shrink-0">

                            @if($billing->status === 'paid')

                                <span class="inline-flex rounded-full bg-green-100
                                             px-2.5 py-1 text-xs font-semibold text-green-700">
                                    Lunas
                                </span>

                            @elseif($billing->status === 'cancelled')

                                <span class="inline-flex rounded-full bg-red-100
                                             px-2.5 py-1 text-xs font-semibold text-red-700">
                                    Dibatalkan
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-yellow-100
                                             px-2.5 py-1 text-xs font-semibold text-yellow-700">
                                    Belum Dibayar
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- CARD BODY --}}
                    <div class="space-y-3 p-4">

                        <div class="flex items-center justify-between gap-3">

                            <span class="text-sm text-slate-500">
                                Nomor urut
                            </span>

                            <span class="text-sm font-medium text-slate-700">
                                {{ $loop->iteration }}
                            </span>

                        </div>

                        <div class="flex items-center justify-between gap-3">

                            <span class="text-sm text-slate-500">
                                Total tagihan
                            </span>

                            <span class="text-right text-base font-bold text-blue-700">
                                Rp {{ number_format($billing->total_amount, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>


                    {{-- CARD ACTIONS --}}
                    <div class="grid grid-cols-3 gap-2 border-t border-slate-100
                                bg-slate-50 p-3">

                        <a href="{{ route('admin.billings.show', $billing) }}"
                           class="inline-flex items-center justify-center gap-1
                                  rounded-lg bg-blue-100 px-2 py-2.5
                                  text-xs font-semibold text-blue-700
                                  hover:bg-blue-200">

                            <i class="fa-solid fa-eye"></i>
                            Detail

                        </a>

                        <a href="{{ route('admin.billings.edit', $billing) }}"
                           class="inline-flex items-center justify-center gap-1
                                  rounded-lg bg-yellow-100 px-2 py-2.5
                                  text-xs font-semibold text-yellow-700
                                  hover:bg-yellow-200">

                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit

                        </a>

                        <form method="POST"
                              action="{{ route('admin.billings.destroy', $billing) }}"
                              onsubmit="return confirm('Yakin ingin menghapus tagihan ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center
                                           gap-1 rounded-lg bg-red-100 px-2 py-2.5
                                           text-xs font-semibold text-red-700
                                           hover:bg-red-200">

                                <i class="fa-solid fa-trash"></i>
                                Hapus

                            </button>

                        </form>

                    </div>

                </div>

            @empty
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-12 text-center shadow-sm">
                
                @if(!empty($search))
                
                <i class="fa-solid fa-magnifying-glass-minus mb-3 text-4xl text-slate-300"></i>
                <h3 class="font-semibold text-slate-700">
                    Tagihan Tidak Ditemukan
                </h3>
                
                <p class="mt-2 text-sm text-slate-500">
                    Tagihan dengan kata kunci "{{ $search }}" tidak ditemukan.
                </p>
                
                <p class="mt-1 text-xs text-slate-400">
                    Silakan periksa kembali kata kunci pencarian Anda.
                </p>
                
                <a href="{{ route('admin.billings.index') }}" class="mt-4 inline-block font-semibold text-blue-600">
                    Reset Pencarian
                </a>
            @else
            
            <div class="mb-3 text-4xl">🧾</div>
            
            <p class="text-sm text-slate-500">
                Belum ada data tagihan.
            </p>

            <a href="{{ route('admin.billings.create') }}" class="mt-4 inline-block font-semibold text-blue-600">
                + Tambah Tagihan
            </a>
        @endif
    </div>
@endforelse
</div>
</div>
</x-admin-layout>
