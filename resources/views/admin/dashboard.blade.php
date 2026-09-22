<x-admin-layout>

    <x-slot name="header">
        Dashboard Admin
    </x-slot>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


        {{-- Dokter --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Dokter
                    </p>

                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalDoctors }}
                    </h3>

                </div>

                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-2xl">
                    👨‍⚕️
                </div>

            </div>

        </div>


        {{-- Pasien --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Pasien
                    </p>

                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalPatients }}
                    </h3>

                </div>

                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-2xl">
                    👥
                </div>

            </div>

        </div>


        {{-- Appointment --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Janji Temu
                    </p>

                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalAppointments }}
                    </h3>

                </div>

                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-2xl">
                    📅
                </div>

            </div>

        </div>


        {{-- Pendapatan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Pendapatan
                    </p>

                    <h3 class="text-2xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-2xl">
                    💰
                </div>

            </div>

        </div>

    </div>


    {{-- Appointment Status --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">


        {{-- Status Appointment --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <h3 class="text-lg font-bold text-gray-900">
                Status Janji Temu
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Ringkasan appointment pasien
            </p>


            <div class="grid grid-cols-2 gap-4 mt-6">


                <div class="bg-yellow-50 rounded-lg p-4">

                    <p class="text-sm text-yellow-700">
                        Pending
                    </p>

                    <p class="text-2xl font-bold text-yellow-800 mt-1">
                        {{ $pendingAppointments }}
                    </p>

                </div>


                <div class="bg-blue-50 rounded-lg p-4">

                    <p class="text-sm text-blue-700">
                        Confirmed
                    </p>

                    <p class="text-2xl font-bold text-blue-800 mt-1">
                        {{ $confirmedAppointments }}
                    </p>

                </div>


                <div class="bg-green-50 rounded-lg p-4">

                    <p class="text-sm text-green-700">
                        Completed
                    </p>

                    <p class="text-2xl font-bold text-green-800 mt-1">
                        {{ $completedAppointments }}
                    </p>

                </div>


                <div class="bg-red-50 rounded-lg p-4">

                    <p class="text-sm text-red-700">
                        Cancelled
                    </p>

                    <p class="text-2xl font-bold text-red-800 mt-1">
                        {{ $cancelledAppointments }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Billing --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <h3 class="text-lg font-bold text-gray-900">
                Informasi Tagihan
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Ringkasan pembayaran pasien
            </p>


            <div class="space-y-4 mt-6">


                <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">

                    <span class="text-green-700">
                        Tagihan Lunas
                    </span>

                    <span class="font-bold text-green-800">
                        {{ $paidBillings }}
                    </span>

                </div>


                <div class="flex justify-between items-center p-4 bg-red-50 rounded-lg">

                    <span class="text-red-700">
                        Belum Dibayar
                    </span>

                    <span class="font-bold text-red-800">
                        {{ $unpaidBillings }}
                    </span>

                </div>


                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">

                    <span class="text-gray-700">
                        Total Tagihan
                    </span>

                    <span class="font-bold text-gray-900">
                        {{ $totalBillings }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>