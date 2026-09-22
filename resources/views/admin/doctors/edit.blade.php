<x-admin-layout>

    <x-slot name="title">
        Edit Dokter
    </x-slot>

    <x-slot name="header">
        Edit Dokter
    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                    Edit Data Dokter
                </h3>

                <p class="text-gray-500 mt-1">
                    Perbarui informasi dokter
                </p>
            </div>


            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">

                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('admin.doctors.update', $doctor) }}">

                @csrf
                @method('PUT')


                {{-- NAMA --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Dokter
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $doctor->user->name) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                </div>


                {{-- EMAIL --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $doctor->user->email) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                </div>


                {{-- NO HP --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $doctor->user->phone) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- SPESIALISASI --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Spesialisasi
                    </label>

                    <input
                        type="text"
                        name="specialization"
                        value="{{ old('specialization', $doctor->specialization) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- LISENSI --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Lisensi / STR
                    </label>

                    <input
                        type="text"
                        name="license_number"
                        value="{{ old('license_number', $doctor->license_number) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- BIO --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bio
                    </label>

                    <textarea
                        name="bio"
                        rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('bio', $doctor->bio) }}</textarea>

                </div>


                {{-- STATUS --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Dokter
                    </label>

                    <select
                        name="is_active"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option value="1"
                            {{ old('is_active', $doctor->is_active) ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ !old('is_active', $doctor->is_active) ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('admin.doctors.index') }}"
                        class="px-5 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>