
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Appointment Saya - DentalCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen">

    <main class="max-w-5xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Appointment Saya
            </h1>

            <a
                href="{{ route('pasien.appointments.create') }}"
                class="bg-cyan-700 text-white px-5 py-3 rounded-lg"
            >
                + Booking Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Jam</th>
                        <th class="p-4">Dokter</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr class="border-t">
                            <td class="p-4">
                                {{ $appointment->appointment_date->format('d-m-Y') }}
                            </td>

                            <td class="p-4">
                                {{ $appointment->appointment_time }}
                            </td>

                            <td class="p-4">
                                {{ $appointment->doctor->user->name ?? '-' }}
                            </td>

                            <td class="p-4">
                                {{ ucfirst($appointment->status) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center">
                                Belum ada appointment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </main>

</body>
</html>