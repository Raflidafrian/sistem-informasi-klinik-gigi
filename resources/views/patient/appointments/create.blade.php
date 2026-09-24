
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Booking Appointment - DentalCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen">

    <main class="max-w-2xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-8">

            <h1 class="text-2xl font-bold mb-6">
                Booking Appointment
            </h1>

            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 mb-5 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('pasien.appointments.store') }}"
                method="POST"
                class="space-y-5">
                @csrf

                <div>
                    <label class="block font-medium mb-2">
                        Pilih Dokter
                    </label>

                    <select
                        name="doctor_id"
                        id="doctor_id"
                        required
                        class="w-full border rounded-lg p-3">
                        <option value="">Pilih dokter</option>

                        @foreach ($doctors as $doctor)
                            <option
                                value="{{ $doctor->id }}"
                                @selected(old('doctor_id') == $doctor->id)>
                                {{ $doctor->user->name ?? 'Dokter' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-2">
                        Tanggal Pemeriksaan
                    </label>

                    <input
                        type="date"
                        name="appointment_date"
                        id="appointment_date"
                        min="{{ now()->toDateString() }}"
                        value="{{ old('appointment_date') }}"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label for="appointment_time"
                            class="block font-medium mb-2">
                        Jam Pemeriksaan
                    </label>

                    <select
                        name="appointment_time"
                        id="appointment_time"
                        value="{{ old('appointment_time') }}"
                        required
                        class="w-full border rounded-lg p-3">

                        <option value="">
                            Pilih dokter dan tanggal dahulu
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-2">
                        Keluhan
                    </label>

                    <textarea
                        name="complaint"
                        rows="4"
                        required
                        class="w-full border rounded-lg p-3"
                        placeholder="Tuliskan keluhan Anda..."
                    >{{ old('complaint') }}</textarea>
                </div>

                <button
                    type="submit"
                    class="w-full bg-cyan-700 text-white
                           rounded-lg p-3 font-semibold">
                    Booking Sekarang
                </button>
            </form>

        </div>

    </main>




<script>
    const doctorInput =
        document.getElementById('doctor_id');

    const dateInput =
        document.getElementById('appointment_date');

    const timeInput =
        document.getElementById('appointment_time');

    const oldTime = @json(old('appointment_time'));

    let requestController = null;

    async function loadAvailableTimes() {

        // Batalkan permintaan sebelumnya
        if (requestController) {
            requestController.abort();
        }

        timeInput.disabled = true;
        timeInput.innerHTML =
            '<option value="">Pilih dokter dan tanggal dahulu</option>';

        if (!doctorInput.value || !dateInput.value) {
            return;
        }

        requestController = new AbortController();
        const currentRequest = requestController;

        timeInput.innerHTML =
            '<option value="">Memuat jadwal...</option>';

        const url = new URL(
            "{{ route('pasien.appointments.available-times') }}"
        );

        url.searchParams.set(
            'doctor_id',
            doctorInput.value
        );

        url.searchParams.set(
            'date',
            dateInput.value
        );

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                },
                signal: currentRequest.signal
            });

            if (!response.ok) {
                throw new Error(
                    'HTTP ' + response.status
                );
            }

            const times = await response.json();

            if (currentRequest !== requestController) {
                return;
            }

            timeInput.innerHTML = '';

            if (times.length === 0) {
                timeInput.add(
                    new Option('Tidak ada jam tersedia', '')
                );
                return;
            }

            timeInput.add(
                new Option('Pilih jam pemeriksaan', '')
            );

            times.forEach(time => {
                timeInput.add(
                    new Option(time, time)
                );
            });

            if (times.includes(oldTime)) {
                timeInput.value = oldTime;
            }

            timeInput.disabled = false;

        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            console.error(
                'Gagal memuat jadwal:',
                error
            );

            timeInput.innerHTML =
                '<option value="">Gagal memuat jadwal</option>';

        }
    }

    doctorInput.addEventListener(
        'change',
        loadAvailableTimes
    );

    dateInput.addEventListener(
        'change',
        loadAvailableTimes
    );

    if (doctorInput.value && dateInput.value) {
        loadAvailableTimes();
    }
</script>

</body>
</html>