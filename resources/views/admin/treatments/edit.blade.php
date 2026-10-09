
<x-admin-layout>
    <x-slot name="title">
        Edit Tarif Tindakan
    </x-slot>

    <x-slot name="header">
        Edit Tarif Tindakan
    </x-slot>

    <div class="max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                Edit Tarif Tindakan
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui kategori, informasi, dan rentang tarif tindakan.
            </p>
        </div>

        {{-- PESAN VALIDASI --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-lg">
                <div class="font-semibold mb-2">Terdapat kesalahan:</div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
            <form method="POST"
                  action="{{ route('admin.treatments.update', $treatment) }}">
                @csrf
                @method('PUT')

                {{-- KATEGORI SESUAI DAFTAR TARIF ASLI --}}
                @php
                    $categories = [
                        'Konsultasi / Premedikasi',
                        'Pembersihan Karang Gigi',
                        'Penambalan Gigi',
                        'Pencabutan Gigi / Bedah Mulut',
                        'Gigi Palsu',
                        'Orthodenti',
                        'Remove / Lepas Bracket',
                    ];

                    $currentCategory = old('category', $treatment->category);
                @endphp

                <div class="mb-6">
                    <label for="category"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>

                    <select id="category"
                            name="category"
                            required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">

                        <option value="">-- Pilih Kategori --</option>

                        {{-- Pertahankan kategori lama agar tetap terlihat saat diedit --}}
                        @if($currentCategory && !in_array($currentCategory, $categories, true))
                            <option value="{{ $currentCategory }}" selected>
                                {{ $currentCategory }} (kategori lama)
                            </option>
                        @endif

                        @foreach($categories as $category)
                            <option value="{{ $category }}"
                                {{ $currentCategory === $category ? 'selected' : '' }}>
                                {{ chr(65 + $loop->index) }}. {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-xs text-slate-500 mt-2">
                        Pilih kategori berdasarkan kelompok tindakan pada daftar tarif klinik.
                    </p>
                </div>

                {{-- NAMA TINDAKAN --}}
                <div class="mb-6">
                    <label for="name"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Tindakan <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $treatment->name) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-4 py-3
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-6">
                    <label for="description"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full rounded-lg border border-slate-300 px-4 py-3
                                     focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">{{ old('description', $treatment->description) }}</textarea>
                </div>

                {{-- HARGA MINIMUM --}}
                <div class="mb-6">
                    <label for="min_price"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Harga Minimum <span class="text-red-500">*</span>
                    </label>

                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0
                                     border-slate-300 bg-slate-100 text-slate-600">
                            Rp
                        </span>

                        <input type="number"
                               id="min_price"
                               name="min_price"
                               value="{{ old('min_price', $treatment->min_price ?? $treatment->price) }}"
                               min="0"
                               step="1000"
                               required
                               class="w-full rounded-r-lg border border-slate-300 px-4 py-3
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                    </div>
                </div>

                {{-- HARGA MAKSIMUM --}}
                <div class="mb-6">
                    <label for="max_price"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Harga Maksimum <span class="text-red-500">*</span>
                    </label>

                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0
                                     border-slate-300 bg-slate-100 text-slate-600">
                            Rp
                        </span>

                        <input type="number"
                               id="max_price"
                               name="max_price"
                               value="{{ old('max_price', $treatment->max_price ?? $treatment->price) }}"
                               min="0"
                               step="1000"
                               required
                               class="w-full rounded-r-lg border border-slate-300 px-4 py-3
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                    </div>

                    <p class="text-xs text-slate-500 mt-2">
                        Harga maksimum harus sama dengan atau lebih besar dari harga minimum.
                        Masukkan nominal dalam Rupiah tanpa titik atau koma.
                    </p>
                </div>

                {{-- STATUS --}}
                <div class="mb-6">
                    <label for="is_active"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select id="is_active"
                            name="is_active"
                            required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">
                        <option value="1"
                            {{ (string) old('is_active', (int) $treatment->is_active) === '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ (string) old('is_active', (int) $treatment->is_active) === '0' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                {{-- TOMBOL --}}
                <div class="flex flex-wrap items-center gap-3 pt-4">
                    <a href="{{ route('admin.treatments.index') }}"
                       class="px-5 py-3 rounded-lg bg-slate-200 text-slate-700 font-semibold
                              hover:bg-slate-300 transition">
                        Kembali
                    </a>

                    <button type="submit"
                            class="px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold
                                   hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
