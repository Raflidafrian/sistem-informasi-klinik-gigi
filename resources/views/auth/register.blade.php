<x-guest-layout>

    <!-- Judul Form -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Daftar Akun Pasien
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Lengkapi data diri untuk membuat akun DentalCare.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label
                for="name"
                value="Nama Lengkap"
            />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label
                for="email"
                value="Alamat Email"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="contoh@gmail.com"
                required
                autocomplete="email"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Nomor HP -->
        <div class="mt-4">
            <x-input-label
                for="phone"
                value="Nomor HP"
            />

            <x-text-input
                id="phone"
                class="block mt-1 w-full"
                type="tel"
                name="phone"
                :value="old('phone')"
                placeholder="Contoh: 081234567890"
                minlength="10"
                maxlength="13"
                pattern="08[0-9]{8,11}"
                inputmode="numeric"
                required
                autocomplete="tel"
            />

            <p class="mt-1 text-xs text-gray-500">
                Gunakan nomor HP aktif yang diawali 08.
            </p>

            <x-input-error
                :messages="$errors->get('phone')"
                class="mt-2"
            />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label
                for="nik"
                value="Nomor Induk Kependudukan (NIK)"
            />

            <x-text-input
                id="nik"
                class="block mt-1 w-full"
                type="text"
                name="nik"
                :value="old('nik')"
                placeholder="Masukkan 16 digit NIK"
                minlength="16"
                maxlength="16"
                pattern="[0-9]{16}"
                inputmode="numeric"
                required
            />

            <p class="mt-1 text-xs text-gray-500">
                Masukkan 16 digit NIK sesuai KTP.
            </p>

            <x-input-error
                :messages="$errors->get('nik')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                value="Password"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <!-- Tombol Daftar -->
        <div class="mt-6">
            <x-primary-button
                class="w-full justify-center py-3"
            >
                Daftar Sekarang
            </x-primary-button>
        </div>

        <!-- Link Login -->
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Sudah memiliki akun?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-blue-600
                           hover:text-blue-800
                           dark:text-blue-400"
                >
                    Masuk di sini
                </a>
            </p>
        </div>

    </form>

</x-guest-layout>