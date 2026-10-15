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
                value="Nama Lengkap"/>

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"/>

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"/>
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label
                for="email"
                value="Alamat Email"/>

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="contoh@gmail.com"
                required
                autocomplete="email"/>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"/>
        </div>

        <!-- Nomor HP -->
        <div class="mt-4">
            <x-input-label
                for="phone"
                value="Nomor HP"/>

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
                autocomplete="tel"/>

            <p class="mt-1 text-xs text-gray-500">
                Gunakan nomor HP aktif yang diawali 08.
            </p>

            <x-input-error
                :messages="$errors->get('phone')"
                class="mt-2"/>
        </div>

                <!-- NIK -->
        <div class="mt-4">
            <x-input-label
                for="nik"
                value="Nomor Induk Kependudukan (NIK)"/>

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
                required/>

            <p class="mt-1 text-xs text-gray-500">
                Masukkan 16 digit NIK sesuai KTP.
            </p>

            <x-input-error
                :messages="$errors->get('nik')"
                class="mt-2"/>
        </div>


        <!-- TEMPAT LAHIR -->
        <div class="mt-4">

            <x-input-label
                for="birth_place"
                value="Tempat Lahir"/>

            <x-text-input
                id="birth_place"
                class="block mt-1 w-full"
                type="text"
                name="birth_place"
                :value="old('birth_place')"
                placeholder="Contoh: Jakarta"
                required
                autocomplete="address-level2"/>

            <x-input-error
                :messages="$errors->get('birth_place')"
                class="mt-2"/>

        </div>


        <!-- TANGGAL LAHIR -->
        <div class="mt-4">

            <x-input-label
                for="birth_date"
                value="Tanggal Lahir"/>

            <x-text-input
                id="birth_date"
                class="block mt-1 w-full"
                type="date"
                name="birth_date"
                :value="old('birth_date')"
                max="{{ date('Y-m-d') }}"
                required/>

            <x-input-error
                :messages="$errors->get('birth_date')"
                class="mt-2"/>

        </div>


        <!-- JENIS KELAMIN -->
        <div class="mt-4">

            <x-input-label
                for="gender"
                value="Jenis Kelamin"/>

            <select
                id="gender"
                name="gender"
                required
                class="block mt-1 w-full rounded-md
                       border-gray-300
                       dark:border-gray-700
                       dark:bg-gray-900
                       dark:text-gray-300
                       focus:border-indigo-500
                       focus:ring-indigo-500">

                <option value="">
                    Pilih jenis kelamin
                </option>

                <option
                    value="male"
                    {{ old('gender') === 'male' ? 'selected' : '' }}>
                    Laki-laki
                </option>

                <option
                    value="female"
                    {{ old('gender') === 'female' ? 'selected' : '' }}>
                    Perempuan
                </option>

            </select>

            <x-input-error
                :messages="$errors->get('gender')"
                class="mt-2"/>

        </div>


        <!-- ALAMAT -->
        <div class="mt-4">

            <x-input-label
                for="address"
                value="Alamat"/>

            <textarea
                id="address"
                name="address"
                rows="3"
                required
                placeholder="Masukkan alamat lengkap"
                class="block mt-1 w-full rounded-md
                       border-gray-300
                       dark:border-gray-700
                       dark:bg-gray-900
                       dark:text-gray-300
                       focus:border-indigo-500
                       focus:ring-indigo-500">{{ old('address') }}</textarea>

            <x-input-error
                :messages="$errors->get('address')"
                class="mt-2"/>
        </div>

        
{{-- Password --}}
<div class="mt-4">
    <x-input-label for="password" value="Password" />

    <div class="relative mt-1">
        <x-text-input
            id="password"
            name="password"
            type="password"
            class="block w-full pr-20"
            required
            autocomplete="new-password"
        />

        <button
    type="button"
    onclick="togglePassword('password', this)"
    class="absolute inset-y-0 right-3 flex items-center justify-center text-gray-600 hover:text-teal-700"
    aria-label="Tampilkan password"
    aria-pressed="false"
>
    <svg xmlns="http://www.w3.org/2000/svg"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">
        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
</button>
    </div>

    <p id="password-strength" class="mt-1 text-sm"></p>

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

{{-- Konfirmasi Password --}}
<div class="mt-4">
    <x-input-label for="password_confirmation"
                   value="Ulangi Password" />

    <div class="relative mt-1">
        <x-text-input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            class="block w-full pr-20"
            required
            autocomplete="new-password"
        />

        <button
    type="button"
    onclick="togglePassword('password_confirmation', this)"
    class="absolute inset-y-0 right-3 flex items-center justify-center text-gray-600 hover:text-teal-700"
    aria-label="Tampilkan konfirmasi password"
    aria-pressed="false"
>
    <svg xmlns="http://www.w3.org/2000/svg"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">
        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
</button>
    </div>

    <p id="password-match" class="mt-1 text-sm"></p>

    <x-input-error
        :messages="$errors->get('password_confirmation')"
        class="mt-2"
    />
</div>


        <!-- Tombol Daftar -->
        <div class="mt-6">
            <x-primary-button
                class="w-full justify-center py-3">
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
                           dark:text-blue-400">
                    Masuk di sini
                </a>
            </p>
        </div>

    </form>

    
<script>
    function togglePassword(id, button) {
    const input = document.getElementById(id);

    if (!input) return;

    const showPassword = input.type === 'password';

    input.type = showPassword ? 'text' : 'password';

    button.setAttribute(
        'aria-label',
        showPassword
            ? 'Sembunyikan password'
            : 'Tampilkan password'
    );

    button.setAttribute('aria-pressed', String(showPassword));

    if (showPassword) {
        // Ikon mata tercoret: password sedang ditampilkan.
        button.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="20" height="20"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M3 3l18 18"/>
                <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5
                         c6.4 0 10 7 10 7a16 16 0 0 1-4 4.8"/>
                <path d="M6.2 6.2C3.5 8 2 12 2 12
                         s3.6 7 10 7a10.5 10.5 0 0 0 4-.8"/>
            </svg>
        `;
    } else {
        // Ikon mata normal: password disembunyikan.
        button.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="20" height="20"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        `;
    }
}

    document.addEventListener('DOMContentLoaded', function () {
        const password = document.getElementById('password');
        const confirmation =
            document.getElementById('password_confirmation');

        const strengthMessage =
            document.getElementById('password-strength');
        const matchMessage =
            document.getElementById('password-match');

        function checkPasswords() {
            const value = password.value;
            const confirmValue = confirmation.value;

            // Indikator panjang password
            if (value.length === 0) {
                strengthMessage.textContent = '';
            } else if (value.length < 8) {
                strengthMessage.textContent =
                    'Password minimal 8 karakter.';
                strengthMessage.className = 'mt-1 text-sm text-red-600';
            } else {
                strengthMessage.textContent =
                    '✓ Panjang password memenuhi syarat.';
                strengthMessage.className = 'mt-1 text-sm text-green-600';
            }

            // Indikator kecocokan password
            if (confirmValue.length === 0) {
                matchMessage.textContent = '';
                confirmation.classList.remove(
                    'border-green-500',
                    'border-red-500'
                );
                return;
            }

            if (value === confirmValue) {
                matchMessage.textContent =
                    '✓ Password cocok!';
                matchMessage.className =
                    'mt-1 text-sm font-medium text-green-600';

                confirmation.classList.remove('border-red-500');
                confirmation.classList.add('border-green-500');
            } else {
                matchMessage.textContent =
                    '✗ Password belum cocok.';
                matchMessage.className =
                    'mt-1 text-sm text-red-600';

                confirmation.classList.remove('border-green-500');
                confirmation.classList.add('border-red-500');
            }
        }

        password.addEventListener('input', checkPasswords);
        confirmation.addEventListener('input', checkPasswords);
    });
</script>


</x-guest-layout>