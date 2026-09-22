<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'DentalCare' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-900 text-white fixed inset-y-0 left-0">

            {{-- LOGO --}}
            <div class="h-20 flex items-center px-6 border-b border-slate-700">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-xl">
                        🦷
                    </div>

                    <div>
                        <h1 class="font-bold text-lg">
                            DentalCare
                        </h1>

                        <p class="text-xs text-slate-400">
                            Klinik Gigi
                        </p>
                    </div>

                </div>

            </div>


           {{-- MENU --}}
<nav class="p-4 space-y-2">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.dashboard')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>📊</span>
        <span>Dashboard</span>

    </a>


    {{-- Data Dokter --}}
    <a href="{{ route('admin.doctors.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 
       {{ request()->routeIs('admin.doctors.*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>👨‍⚕️</span>
        <span>Data Dokter</span>

    </a>


    {{-- Data Pasien --}}
    <a href="{{ route('admin.patients.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.patients.*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

            <span>👥</span>
            <span>Data Pasien</span>
    </a>


    {{-- Jadwal Praktik --}}
    <a href="{{ route('admin.schedules.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 
       {{ request()->routeIs('admin.schedules*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>🗓️</span>
        <span>Jadwal Praktik</span>

    </a>


    {{-- Appointment --}}
    <a href="{{ route('admin.appointments.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.appointments*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>📅</span>
        <span>Appointment</span>

    </a>


    {{-- Rekam Medis --}}
    <a href="{{ route('admin.dental-records.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.dental-records*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>📋</span>
        <span>Rekam Medis</span>

    </a>


    {{-- Tarif Tindakan --}}
    <a href="{{ route('admin.treatments.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.treatments*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>💰</span>
        <span>Tarif Tindakan</span>

    </a>


    {{-- Data Obat --}}
    <a href="{{ route('admin.medicines.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.medicines*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>💊</span>
        <span>Data Obat</span>

    </a>


    {{-- Tagihan --}}
    <a href="{{ route('admin.billings.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.billings*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>🧾</span>
        <span>Tagihan</span>

    </a>


    {{-- Pembayaran --}}
    <a href="{{ route('admin.payments.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
       {{ request()->routeIs('admin.payments*')
            ? 'bg-blue-600 text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800' }}">

        <span>💳</span>
        <span>Pembayaran</span>

    </a>

</nav>


            {{-- USER --}}
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="overflow-hidden">

                        <p class="font-semibold truncate">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-slate-400">
                            Administrator
                        </p>

                    </div>

                </div>


                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg text-slate-300 hover:bg-red-600 hover:text-white">

                        🚪 Logout

                    </button>

                </form>

            </div>

        </aside>


        {{-- CONTENT --}}
        <main class="ml-64 flex-1 min-h-screen">

            {{-- TOPBAR --}}
            <header class="bg-white border-b border-gray-200 h-20 flex items-center justify-between px-8">

                <div>
                    <h2 class="text-xl font-bold">
                        {{ $header ?? 'Dashboard' }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        Sistem Manajemen Praktik Dokter Gigi
                    </p>
                </div>


                <div class="text-right">

                    <p class="font-semibold">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Admin
                    </p>

                </div>

            </header>


            {{-- PAGE CONTENT --}}
            <section class="p-8">

                {{ $slot }}

            </section>

        </main>

    </div>

</body>
</html>