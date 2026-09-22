<x-admin-layout>

    <x-slot name="header">
        Data Dokter
    </x-slot>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Data Dokter
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data dokter praktik gigi
            </p>
        </div>

        <a href="{{ route('admin.doctors.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold">

            + Tambah Dokter

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">

            {{ session('success') }}

        </div>

    @endif


    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Spesialisasi
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($doctors as $doctor)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-900">
                                    {{ $doctor->user->name }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $doctor->license_number ?? '-' }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $doctor->user->email }}
                            </td>


                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $doctor->specialization ?? '-' }}
                            </td>


                            <td class="px-6 py-4">

                                @if($doctor->is_active)

                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.doctors.edit', $doctor) }}"
                                       class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium">

                                        Edit

                                    </a>


                                    <form method="POST"
                                          action="{{ route('admin.doctors.destroy', $doctor) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-12 text-center text-gray-500">

                                Belum ada data dokter.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($doctors->hasPages())

            <div class="px-6 py-4 border-t">

                {{ $doctors->links() }}

            </div>

        @endif

    </div>

</x-admin-layout>