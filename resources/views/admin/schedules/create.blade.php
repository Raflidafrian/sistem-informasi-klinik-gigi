<x-admin-layout>

    <x-slot name="title">
        Tambah Jadwal Praktik
    </x-slot>

    <x-slot name="header">
        Tambah Jadwal Praktik
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        {{-- HEADER --}}
        <div class="p-6 border-b border-gray-200">

            <h2 class="text-xl font-bold text-gray-900">
                Tambah Jadwal Praktik
            </h2>

            <p class="text-gray-500 mt-1">
                Masukkan jadwal praktik dokter.
            </p>

        </div>


        {{-- FORM --}}
        <form method="POST" action="{{ route('schedules.store') }}" class="p-6">

            @csrf


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 bg-red-50 border border-red-200
                            text-red-700 px-4 py-3 rounded-lg">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- DOKTER --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Dokter
                </label>

                <select
                    name="doctor_id"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500 focus:ring-blue-500"
                    required>

                    <option value="">
                        -- Pilih Dokter --
                    </option>

                    @foreach ($doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>

                            {{ $doctor->user->name ?? 'Nama dokter tidak tersedia' }}

                            @if($doctor->specialization)
                                - {{ $doctor->specialization }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- HARI --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Hari Praktik
                </label>

                <select
                    name="day_of_week"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500 focus:ring-blue-500"
                    required>

                    <option value="">
                        -- Pilih Hari --
                    </option>

                    <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>
                        Senin
                    </option>

                    <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>
                        Selasa
                    </option>

                    <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>
                        Rabu
                    </option>

                    <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>
                        Kamis
                    </option>

                    <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>
                        Jumat
                    </option>

                    <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>
                        Sabtu
                    </option>

                    <option value="7" {{ old('day_of_week') == 7 ? 'selected' : '' }}>
                        Minggu
                    </option>

                </select>

            </div>


            {{-- JAM MULAI --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jam Mulai
                </label>

                <input
                    type="time"
                    name="start_time"
                    value="{{ old('start_time') }}"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500 focus:ring-blue-500"
                    required>

            </div>


            {{-- JAM SELESAI --}}
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jam Selesai
                </label>

                <input
                    type="time"
                    name="end_time"
                    value="{{ old('end_time') }}"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500 focus:ring-blue-500"
                    required>

            </div>


            {{-- BUTTON --}}
            <div class="flex gap-3">

                <a
                    href="{{ route('schedules.index') }}"
                    class="px-5 py-3 rounded-lg bg-gray-200
                           text-gray-700 font-semibold
                           hover:bg-gray-300 transition">

                    Kembali

                </a>


                <button
                    type="submit"
                    class="px-5 py-3 rounded-lg bg-blue-600
                           text-white font-semibold
                           hover:bg-blue-700 transition">

                    Simpan Jadwal

                </button>

            </div>

        </form>

    </div>

</x-admin-layout>