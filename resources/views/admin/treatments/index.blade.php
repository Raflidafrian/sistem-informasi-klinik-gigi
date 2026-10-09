
<x-admin-layout>
    <x-slot name="title">Tarif Tindakan</x-slot>
    <x-slot name="header">Tarif Tindakan</x-slot>

    @php
        $groupedTreatments = $treatments->groupBy(function ($treatment) {
            return $treatment->category ?: 'Belum dikategorikan';
        });
    @endphp

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tarif Tindakan</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Pilih kategori untuk melihat daftar tindakan dan tarifnya.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button"
                        id="toggleCategorySearch"
                        aria-expanded="false"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3
                               bg-white border border-slate-300 text-slate-700
                               rounded-lg hover:bg-slate-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <span id="searchButtonText">Cari Kategori</span>
                </button>

                <a href="{{ route('admin.treatments.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3
                          bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <span>＋</span> Tambah Tindakan
                </a>
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PENCARIAN --}}
        <div id="categorySearchPanel"
             class="hidden bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <label for="categorySearchInput"
                   class="block text-sm font-semibold text-slate-700 mb-2">
                Cari nama kategori
            </label>

            <div class="flex flex-col sm:flex-row gap-3">
                <input type="search"
                       id="categorySearchInput"
                       placeholder="Contoh: Penambalan Gigi"
                       autocomplete="off"
                       class="flex-1 rounded-lg border border-slate-300 px-4 py-3
                              focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">

                <button type="button"
                        id="resetCategorySearch"
                        class="px-5 py-3 rounded-lg bg-slate-100 text-slate-700
                               font-semibold hover:bg-slate-200 transition">
                    Reset
                </button>
            </div>

            <p id="categorySearchResult" aria-live="polite"
               class="text-sm text-slate-500 mt-3">
                Ketik nama kategori untuk mencari.
            </p>
        </div>

        {{-- DAFTAR KATEGORI --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">DAFTAR KATEGORI</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Klik nama kategori untuk melihat tindakan di dalamnya.
                </p>
            </div>

            <div id="categoryList" class="divide-y divide-slate-200">

                @forelse($groupedTreatments as $category => $items)
                    <section class="category-group"
                             data-category-group="{{ strtolower($category) }}">

                        {{-- JUDUL KATEGORI --}}
                        <button type="button"
                                class="category-toggle flex w-full items-center justify-between
                                       gap-4 px-5 py-5 text-left hover:bg-blue-50 transition"
                                aria-expanded="false">

                            <span class="font-semibold text-slate-800">
                                {{ chr(65 + $loop->index) }}. {{ strtoupper($category) }}
                                <span class="ml-2 text-sm font-normal text-slate-500">
                                    ({{ $items->count() }} tindakan)
                                </span>
                            </span>

                            <svg class="category-chevron shrink-0 transition-transform"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        {{-- ISI KATEGORI --}}
                        <div class="category-content hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[850px]">
                                    <thead class="bg-slate-50 border-y border-slate-200">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-sm">No</th>
                                            <th class="px-5 py-3 text-left text-sm">Nama Tindakan</th>
                                            <th class="px-5 py-3 text-left text-sm">Deskripsi</th>
                                            <th class="px-5 py-3 text-left text-sm">Rentang Harga</th>
                                            <th class="px-5 py-3 text-center text-sm">Status</th>
                                            <th class="px-5 py-3 text-center text-sm">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($items as $treatment)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-5 py-4 text-sm text-slate-600">
                                                    {{ $loop->iteration }}.
                                                </td>

                                                <td class="px-5 py-4">
                                                    <span class="font-semibold text-slate-900">
                                                        {{ $treatment->name }}
                                                    </span>
                                                </td>

                                                <td class="px-5 py-4 text-sm text-slate-600">
                                                    {{ $treatment->description ?: '-' }}
                                                </td>

                                                <td class="px-5 py-4">
                                                    <span class="font-semibold text-slate-900 whitespace-nowrap">
                                                        @if($treatment->min_price !== null && $treatment->max_price !== null)
                                                            @if((float) $treatment->min_price === (float) $treatment->max_price)
                                                                Rp {{ number_format((float) $treatment->min_price, 0, ',', '.') }}
                                                            @else
                                                                Rp {{ number_format((float) $treatment->min_price, 0, ',', '.') }}
                                                                - Rp {{ number_format((float) $treatment->max_price, 0, ',', '.') }}
                                                            @endif
                                                        @else
                                                            Rp {{ number_format((float) $treatment->price, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                </td>

                                                <td class="px-5 py-4 text-center">
                                                    @if($treatment->is_active)
                                                        <span class="inline-flex px-3 py-1 rounded-full text-xs
                                                                     font-semibold bg-green-100 text-green-700">
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span class="inline-flex px-3 py-1 rounded-full text-xs
                                                                     font-semibold bg-red-100 text-red-700">
                                                            Tidak Aktif
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-5 py-4">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <a href="{{ route('admin.treatments.edit', $treatment) }}"
                                                           class="px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700
                                                                  hover:bg-yellow-200 transition">
                                                            Edit
                                                        </a>

                                                        <form method="POST"
                                                              action="{{ route('admin.treatments.destroy', $treatment) }}"
                                                              onsubmit="return confirm('Yakin ingin menghapus tindakan ini?');">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="px-3 py-2 rounded-lg bg-red-100 text-red-700
                                                                           hover:bg-red-200 transition">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @empty
                    <div class="px-5 py-12 text-center">
                        <p class="text-slate-500">Belum ada data tarif tindakan.</p>
                        <a href="{{ route('admin.treatments.create') }}"
                           class="inline-block mt-3 text-blue-600 font-semibold hover:text-blue-700">
                            + Tambah Tindakan
                        </a>
                    </div>
                @endforelse

                <div id="noCategoryResult" class="hidden px-5 py-10 text-center text-slate-500">
                    Kategori tidak ditemukan. Coba kata kunci lain.
                </div>
            </div>
        </div>

        <p class="text-xs text-slate-500">
            Rentang harga merupakan referensi tarif. Harga akhir tindakan perlu dikonfirmasi
            sesuai kondisi pasien dan kebijakan klinik.
        </p>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchButton = document.getElementById('toggleCategorySearch');
            const searchPanel = document.getElementById('categorySearchPanel');
            const searchInput = document.getElementById('categorySearchInput');
            const resetButton = document.getElementById('resetCategorySearch');
            const searchButtonText = document.getElementById('searchButtonText');
            const resultText = document.getElementById('categorySearchResult');
            const noResult = document.getElementById('noCategoryResult');

            const groups = Array.from(
                document.querySelectorAll('.category-group')
            );

            // Buka dan tutup setiap kategori
            document.querySelectorAll('.category-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const section = button.closest('.category-group');
                    const content = section.querySelector('.category-content');
                    const chevron = button.querySelector('.category-chevron');
                    const isOpening = content.classList.contains('hidden');

                    content.classList.toggle('hidden', !isOpening);
                    button.setAttribute('aria-expanded', String(isOpening));
                    chevron.classList.toggle('rotate-180', isOpening);
                });
            });

            // Pencarian kategori
            function filterCategories() {
                const keyword = searchInput.value.trim().toLocaleLowerCase();
                let visibleCount = 0;

                groups.forEach(function (group) {
                    const category = group.dataset.categoryGroup || '';
                    const matches = category.includes(keyword);

                    group.classList.toggle('hidden', !matches);

                    if (matches) {
                        visibleCount++;

                        // Saat mencari, buka kategori yang cocok
                        if (keyword !== '') {
                            const content = group.querySelector('.category-content');
                            const button = group.querySelector('.category-toggle');
                            const chevron = button.querySelector('.category-chevron');

                            content.classList.remove('hidden');
                            button.setAttribute('aria-expanded', 'true');
                            chevron.classList.add('rotate-180');
                        }
                    }
                });

                noResult.classList.toggle('hidden', visibleCount > 0);

                resultText.textContent = keyword === ''
                    ? 'Menampilkan ' + visibleCount + ' kategori.'
                    : visibleCount + ' kategori ditemukan.';
            }

            searchButton.addEventListener('click', function () {
                const opening = searchPanel.classList.contains('hidden');

                searchPanel.classList.toggle('hidden', !opening);
                searchButton.setAttribute('aria-expanded', String(opening));
                searchButtonText.textContent = opening
                    ? 'Tutup Pencarian'
                    : 'Cari Kategori';

                if (opening) {
                    searchInput.focus();
                } else {
                    searchInput.value = '';
                    filterCategories();
                }
            });

            searchInput.addEventListener('input', filterCategories);

            resetButton.addEventListener('click', function () {
                searchInput.value = '';
                filterCategories();
                searchInput.focus();
            });

            filterCategories();
        });
    </script>
</x-admin-layout>
