<x-admin-layout>

    <x-slot name="header">
        Tambah Dokter
    </x-slot>


    <div class="max-w-4xl">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <h1 class="text-xl font-bold text-gray-900 mb-6">
                Tambah Dokter Baru
            </h1>


            <form method="POST"
                  action="{{ route('admin.doctors.store') }}"
                  class="space-y-5">

                @csrf


                {{-- Nama --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Dokter
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: dr. Ahmad"
                        class="w-full border-gray-300 rounded-lg"
                        required>

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Email --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="dokter@gmail.com"
                        class="w-full border-gray-300 rounded-lg"
                        required>

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- No HP --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full border-gray-300 rounded-lg">

                </div>


                {{-- Spesialisasi --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Spesialisasi
                    </label>

                    <input
                        type="text"
                        name="specialization"
                        value="{{ old('specialization') }}"
                        placeholder="Contoh: Dokter Gigi Umum"
                        class="w-full border-gray-300 rounded-lg">

                </div>


                {{-- STR --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nomor Lisensi / STR
                    </label>

                    <input
                        type="text"
                        name="license_number"
                        value="{{ old('license_number') }}"
                        class="w-full border-gray-300 rounded-lg">

                </div>


                {{-- Bio --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Bio
                    </label>

                    <textarea
                        name="bio"
                        rows="4"
                        class="w-full border-gray-300 rounded-lg">{{ old('bio') }}</textarea>

                </div>


                {{-- Button --}}
                <div class="flex gap-3 pt-4">

                    <a href="{{ route('admin.doctors.index') }}"
                       class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold">

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">

                        Simpan Dokter

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>