<x-admin-layout title="Data Pasien" header="Data Pasien">

    <div class="space-y-6">

        {{-- Header halaman --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Data Pasien
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola data pasien praktik dokter gigi
                </p>
            </div>

            <a href="{{ route('admin.patients.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3
                       bg-blue-600 text-white rounded-lg
                       hover:bg-blue-700 transition">

                <span>+</span>
                <span>Tambah Pasien</span>

            </a>

        </div>


        {{-- Pesan sukses --}}
        @if (session('success'))

            <div class="bg-green-100 border border-green-200
                        text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif


        {{-- Pesan error --}}
        @if ($errors->any())

            <div class="bg-red-100 border border-red-200
                        text-red-700 px-4 py-3 rounded-lg">

                <ul class="list-disc ml-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Tabel pasien --}}
        <div class="bg-white rounded-xl shadow-sm border
                    border-slate-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                Pasien
                            </th>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                No. HP
                            </th>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                NIK
                            </th>

                            <th class="px-6 py-4 text-left text-sm
                                       font-semibold text-slate-700">
                                Jenis Kelamin
                            </th>

                            <th class="px-6 py-4 text-center text-sm
                                       font-semibold text-slate-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($patients as $patient)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- No --}}
                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- Nama --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-900">

                                        {{ $patient->user->name ?? '-' }}

                                    </div>

                                </td>


                                {{-- Email --}}
                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $patient->user->email ?? '-' }}

                                </td>


                                {{-- HP --}}
                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $patient->user->phone ?? '-' }}

                                </td>


                                {{-- NIK --}}
                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $patient->nik ?? '-' }}

                                </td>


                                {{-- Jenis kelamin --}}
                                <td class="px-6 py-4 text-sm">

                                    @if ($patient->gender === 'male')

                                        <span class="px-3 py-1 rounded-full
                                                     bg-blue-100 text-blue-700">
                                            Laki-laki
                                        </span>

                                    @elseif ($patient->gender === 'female')

                                        <span class="px-3 py-1 rounded-full
                                                     bg-pink-100 text-pink-700">
                                            Perempuan
                                        </span>

                                    @else

                                        <span class="text-slate-400">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center
                                                justify-center gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.patients.edit', $patient->id) }}"
                                            class="px-3 py-2 rounded-lg
                                                   bg-yellow-100 text-yellow-700
                                                   hover:bg-yellow-200 transition">

                                            Edit

                                        </a>


                                        {{-- Hapus --}}
                                        <form method="POST"
                                            action="{{ route('admin.patients.destroy', $patient->id) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">

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

                                <td colspan="7"
                                    class="px-6 py-12 text-center">

                                    <div class="text-4xl mb-3">
                                        👥
                                    </div>

                                    <p class="text-slate-500">
                                        Belum ada data pasien.
                                    </p>

                                    <a href="{{ route('admin.patients.create') }}"
                                        class="inline-block mt-4
                                               text-blue-600 hover:text-blue-700
                                               font-medium">

                                        + Tambah Pasien

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