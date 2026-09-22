<x-admin-layout>

    <x-slot name="title">
        Tambah Obat
    </x-slot>

    <x-slot name="header">
        Tambah Obat
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- CARD --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

            {{-- HEADER --}}
            <div class="px-8 py-6 border-b border-slate-200">

                <h1 class="text-2xl font-bold text-slate-900">
                    Tambah Obat Baru
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Masukkan data obat dengan lengkap.
                </p>

            </div>


            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('admin.medicines.store') }}"
                  class="p-8">

                @csrf


                {{-- ERROR --}}
                @if($errors->any())

                    <div class="mb-6 bg-red-50 border border-red-200
                                text-red-700 rounded-lg p-4">

                        <ul class="list-disc list-inside text-sm">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <div class="space-y-6">


                    {{-- NAMA OBAT --}}
                    <div>

                        <label for="name"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Nama Obat

                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Amoxicillin"
                            class="w-full rounded-lg border border-slate-300
                                   px-4 py-3
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-200
                                   outline-none"
                            required>

                    </div>


                    {{-- SATUAN --}}
                    <div>

                        <label for="unit"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Satuan

                        </label>

                        <select
                            id="unit"
                            name="unit"
                            class="w-full rounded-lg border border-slate-300
                                   px-4 py-3
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-200
                                   outline-none"
                            required>

                            <option value="">-- Pilih Satuan --</option>

                            <option value="Tablet"
                                {{ old('unit') == 'Tablet' ? 'selected' : '' }}>
                                Tablet
                            </option>

                            <option value="Kapsul"
                                {{ old('unit') == 'Kapsul' ? 'selected' : '' }}>
                                Kapsul
                            </option>

                            <option value="Botol"
                                {{ old('unit') == 'Botol' ? 'selected' : '' }}>
                                Botol
                            </option>

                            <option value="Strip"
                                {{ old('unit') == 'Strip' ? 'selected' : '' }}>
                                Strip
                            </option>

                            <option value="Tube"
                                {{ old('unit') == 'Tube' ? 'selected' : '' }}>
                                Tube
                            </option>

                            <option value="Sachet"
                                {{ old('unit') == 'Sachet' ? 'selected' : '' }}>
                                Sachet
                            </option>

                        </select>

                    </div>


                    {{-- STOK --}}
                    <div>

                        <label for="stock"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Stok

                        </label>

                        <input
                            type="number"
                            id="stock"
                            name="stock"
                            value="{{ old('stock', 0) }}"
                            min="0"
                            placeholder="Contoh: 100"
                            class="w-full rounded-lg border border-slate-300
                                   px-4 py-3
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-200
                                   outline-none"
                            required>

                    </div>


                </div>


                {{-- BUTTON --}}
                <div class="flex items-center gap-3 mt-8 pt-6
                            border-t border-slate-200">

                    <a href="{{ route('admin.medicines.index') }}"
                       class="px-6 py-3 rounded-lg
                              bg-slate-200 text-slate-700
                              font-semibold
                              hover:bg-slate-300 transition">

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="px-6 py-3 rounded-lg
                               bg-blue-600 text-white
                               font-semibold
                               hover:bg-blue-700 transition">

                        💾 Simpan Obat

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>