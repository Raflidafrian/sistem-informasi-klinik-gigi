<x-admin-layout>

    <x-slot name="title">
        Tarif Tindakan
    </x-slot>

    <x-slot name="header">
        Tarif Tindakan
    </x-slot>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Tarif Tindakan
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola tarif tindakan praktik dokter gigi
                </p>
            </div>

            <a href="{{ route('admin.treatments.create') }}"
               class="inline-flex items-center gap-2 px-5 py-3
                      bg-blue-600 text-white rounded-lg
                      hover:bg-blue-700 transition">

                <span>＋</span>
                Tambah Tindakan

            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="bg-green-50 border border-green-200
                        text-green-700 px-5 py-4 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        {{-- TABLE --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                                Nama Tindakan
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                                Deskripsi
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                                Harga
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($treatments as $treatment)

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-900">
                                        {{ $treatment->name }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $treatment->description ?: '-' }}

                                </td>

                                <td class="px-6 py-4">

                                    <span class="font-semibold text-slate-900">

                                        Rp {{ number_format($treatment->price, 0, ',', '.') }}

                                    </span>

                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($treatment->is_active)

                                        <span class="inline-flex px-3 py-1
                                                     rounded-full text-xs font-semibold
                                                     bg-green-100 text-green-700">

                                            Aktif

                                        </span>

                                    @else

                                        <span class="inline-flex px-3 py-1
                                                     rounded-full text-xs font-semibold
                                                     bg-red-100 text-red-700">

                                            Tidak Aktif

                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.treatments.edit', $treatment) }}"
                                           class="px-3 py-2 rounded-lg
                                                  bg-yellow-100 text-yellow-700
                                                  hover:bg-yellow-200 transition">

                                            Edit

                                        </a>


                                        {{-- HAPUS --}}
                                        <form method="POST"
                                              action="{{ route('admin.treatments.destroy', $treatment) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus tindakan ini?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-2 rounded-lg
                                                           bg-red-100 text-red-700
                                                           hover:bg-red-200 transition">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="text-5xl mb-4">
                                        💰
                                    </div>

                                    <p class="text-slate-500 mb-4">
                                        Belum ada data tarif tindakan.
                                    </p>

                                    <a href="{{ route('admin.treatments.create') }}"
                                       class="text-blue-600 hover:text-blue-700 font-semibold">

                                        ＋ Tambah Tindakan

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