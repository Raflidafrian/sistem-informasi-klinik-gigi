<x-admin-layout>

    <x-slot name="title">
        Tambah Appointment
    </x-slot>

    <x-slot name="header">
        Tambah Appointment
    </x-slot>


    <div class="max-w-4xl">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">

            {{-- HEADER --}}
            <div class="p-6 border-b border-gray-200">

                <h2 class="text-xl font-bold text-gray-900">
                    Tambah Appointment Baru
                </h2>

                <p class="text-gray-500 mt-1">
                    Masukkan data janji temu pasien dengan dokter.
                </p>

            </div>


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mx-6 mt-6 p-4 rounded-lg
                            bg-red-50 border border-red-200
                            text-red-700">

                    <p class="font-semibold mb-2">
                        Terjadi kesalahan:
                    </p>

                    <ul class="list-disc ml-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM --}}
            <form
                method="POST"
                action="{{ route('admin.appointments.store') }}"
                class="p-6">

                @csrf


                {{-- PASIEN --}}
                <div class="mb-5">

                    <label
                        for="patient_id"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Pasien

                    </label>


                    <select
                        id="patient_id"
                        name="patient_id"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            -- Pilih Pasien --
                        </option>

                        @foreach ($patients as $patient)

                            <option
                                value="{{ $patient->id }}"
                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                                {{ $patient->user->name ?? 'Tanpa Nama' }}

                                @if($patient->nik)
                                    - {{ $patient->nik }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- DOKTER --}}
                <div class="mb-5">

                    <label
                        for="doctor_id"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Dokter

                    </label>


                    <select
                        id="doctor_id"
                        name="doctor_id"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            -- Pilih Dokter --
                        </option>

                        @foreach ($doctors as $doctor)

                            <option
                                value="{{ $doctor->id }}"
                                {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>

                                {{ $doctor->user->name ?? 'Tanpa Nama' }}

                                @if($doctor->specialization)
                                    - {{ $doctor->specialization }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TANGGAL --}}
                <div class="mb-5">

                    <label
                        for="appointment_date"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Tanggal Appointment

                    </label>


                    <input
                        type="date"
                        id="appointment_date"
                        name="appointment_date"
                        value="{{ old('appointment_date') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                </div>


                {{-- JAM --}}
                <div class="mb-5">

                    <label
                        for="appointment_time"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Jam Appointment

                    </label>


                    <input
                        type="time"
                        id="appointment_time"
                        name="appointment_time"
                        value="{{ old('appointment_time') }}"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                </div>


                {{-- KELUHAN --}}
                <div class="mb-6">

                    <label
                        for="complaint"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Keluhan Pasien

                    </label>


                    <textarea
                        id="complaint"
                        name="complaint"
                        rows="4"
                        placeholder="Contoh: Sakit gigi sebelah kanan..."
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">{{ old('complaint') }}</textarea>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('admin.appointments.index') }}"
                        class="px-5 py-3 rounded-lg
                               bg-gray-200 text-gray-700
                               hover:bg-gray-300
                               font-semibold">

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="px-5 py-3 rounded-lg
                               bg-blue-600 text-white
                               hover:bg-blue-700
                               font-semibold">

                        Simpan Appointment

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>