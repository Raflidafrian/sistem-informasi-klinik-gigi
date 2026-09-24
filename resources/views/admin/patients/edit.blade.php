<x-admin-layout
    title="Edit Pasien"
    header="Edit Pasien"
>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Data Pasien
                </h1>

                <p class="text-gray-500 mt-1">
                    Perbarui informasi pasien.
                </p>
            </div>


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">

                    <ul class="list-disc list-inside text-sm">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.patients.update', $patient->id) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')


                {{-- NAMA --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        Nama Pasien
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $patient->user->name) }}"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $patient->user->email) }}"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- NO HP --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $patient->user->phone) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- NIK --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik', $patient->nik) }}"
                        maxlength="16"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- TANGGAL LAHIR --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        name="birth_date"
                        value="{{ old('birth_date', optional($patient->birth_date)->format('Y-m-d')) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- JENIS KELAMIN --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>

                    <select
                        name="gender"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option value="">
                            -- Pilih Jenis Kelamin --
                        </option>

                        <option
                            value="male"
                            {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}
                        >
                            Laki-laki
                        </option>

                        <option
                            value="female"
                            {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}
                        >
                            Perempuan
                        </option>

                    </select>

                </div>


                {{-- ALAMAT --}}
                <div>

                    <label class="block font-medium text-gray-700 mb-2">
                        Alamat
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('address', $patient->address) }}</textarea>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center gap-3 pt-4">

                    <a
                        href="{{ route('admin.patients.index') }}"
                        class="px-5 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold text-gray-700"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold"
                    >
                        Update Pasien
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>