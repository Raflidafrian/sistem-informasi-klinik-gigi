<x-admin-layout>

    <x-slot name="title">
        Edit Tarif Tindakan
    </x-slot>

    <x-slot name="header">
        Edit Tarif Tindakan
    </x-slot>

    <div class="max-w-4xl">

        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-900">
                Edit Tarif Tindakan
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi tarif tindakan.
            </p>

        </div>


        {{-- ERROR VALIDASI --}}
        @if ($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200
                        text-red-700 px-5 py-4 rounded-lg">

                <div class="font-semibold mb-2">
                    Terdapat kesalahan:
                </div>

                <ul class="list-disc list-inside text-sm">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}
        <div class="bg-white rounded-xl border border-slate-200
                    shadow-sm p-8">

            <form method="POST"
                  action="{{ route('admin.treatments.update', $treatment) }}">

                @csrf

                @method('PUT')


                {{-- NAMA TINDAKAN --}}
                <div class="mb-6">

                    <label for="name"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Nama Tindakan
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $treatment->name) }}"
                        required
                        class="w-full rounded-lg border border-slate-300
                               px-4 py-3
                               focus:border-blue-500 focus:ring-2
                               focus:ring-blue-200 outline-none">

                </div>


                {{-- DESKRIPSI --}}
                <div class="mb-6">

                    <label for="description"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Deskripsi

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full rounded-lg border border-slate-300
                               px-4 py-3
                               focus:border-blue-500 focus:ring-2
                               focus:ring-blue-200 outline-none">{{ old('description', $treatment->description) }}</textarea>

                </div>


                {{-- HARGA --}}
                <div class="mb-6">

                    <label for="price"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Harga
                        <span class="text-red-500">*</span>

                    </label>

                    <div class="flex">

                        <span class="inline-flex items-center px-4
                                     rounded-l-lg border border-r-0
                                     border-slate-300 bg-slate-100
                                     text-slate-600">

                            Rp

                        </span>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price', $treatment->price) }}"
                            min="0"
                            step="1000"
                            required
                            class="w-full rounded-r-lg border border-slate-300
                                   px-4 py-3
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-200 outline-none">

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="mb-6">

                    <label for="is_active"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Status
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        id="is_active"
                        name="is_active"
                        required
                        class="w-full rounded-lg border border-slate-300
                               px-4 py-3
                               focus:border-blue-500 focus:ring-2
                               focus:ring-blue-200 outline-none">

                        <option value="1"
                            {{ old('is_active', $treatment->is_active) == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ old('is_active', $treatment->is_active) == 0 ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center gap-3 pt-4">

                    <a href="{{ route('admin.treatments.index') }}"
                       class="px-5 py-3 rounded-lg
                              bg-slate-200 text-slate-700
                              font-semibold
                              hover:bg-slate-300 transition">

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="px-5 py-3 rounded-lg
                               bg-blue-600 text-white
                               font-semibold
                               hover:bg-blue-700 transition">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>