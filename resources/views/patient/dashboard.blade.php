
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pasien - DentalCare</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm px-6 py-5">

        <div class="max-w-5xl mx-auto flex flex-wrap
                    items-center justify-between gap-4">

            <!-- LOGO -->
            <a href="{{ url('/') }}"
               class="text-2xl font-bold text-cyan-700">
                🦷 DentalCare
            </a>

            <!-- MENU NAVBAR -->
            <div class="flex items-center gap-4">

                <a href="{{ url('/') }}"
                   class="text-gray-600 hover:text-cyan-700
                          font-medium transition">
                    Beranda
                </a>

                <!-- LOGOUT -->
                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700
                                   text-white px-5 py-2
                                   rounded-lg font-medium
                                   transition">
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </nav>

    <!-- KONTEN UTAMA -->
    <main class="max-w-5xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-2xl font-bold">
                Selamat Datang,
                {{ auth()->user()->name }}
            </h2>

            <p class="text-gray-600 mt-3">
                Anda berhasil masuk ke dashboard pasien.
            </p>

            <!-- INFORMASI DASHBOARD -->
            <div class="mt-6 bg-cyan-50 p-5 rounded-lg">

                <h3 class="font-semibold">
                    Dashboard Pasien
                </h3>

                <p class="mt-2">
                    Kelola appointment dan lihat
                    riwayat pemeriksaan gigi Anda.
                </p>

            </div>

            <!-- TOMBOL APPOINTMENT -->
            <div class="mt-6 flex flex-wrap gap-3">

                <a
                    href="{{ route('pasien.appointments.create') }}"
                    class="bg-cyan-700 hover:bg-cyan-800
                           text-white px-5 py-3 rounded-lg
                           transition"
                >
                    + Booking Appointment
                </a>

                <a
                    href="{{ route('pasien.appointments.index') }}"
                    class="bg-white border border-gray-300
                           hover:bg-gray-100 px-5 py-3
                           rounded-lg transition"
                >
                    Riwayat Appointment
                </a>

            </div>

        </div>

    </main>

</body>
</html>