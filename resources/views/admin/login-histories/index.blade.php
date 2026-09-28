<x-admin-layout>
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Riwayat Login
        </h1>

        <p class="mt-1 text-slate-500">
            Pantau aktivitas login dan logout pengguna DentalCare.
        </p>
    </div>

    {{-- Admin terakhir login --}}
    <div class="rounded-xl border border-blue-100
                bg-blue-50 p-6">

        <h2 class="mb-3 font-bold text-blue-900">
            Admin Terakhir Login
        </h2>

        @if($lastAdminLogin)
            <p class="text-xl font-bold text-slate-900">
                {{ $lastAdminLogin->user?->name ?? 'Akun dihapus' }}
            </p>

            <p class="text-slate-600">
                {{ $lastAdminLogin->user?->email ?? '-' }}
            </p>

            <p class="mt-3 text-sm text-slate-600">
                Login:
                {{ $lastAdminLogin->created_at->format('d/m/Y H:i:s') }}
            </p>

            <p class="text-sm text-slate-600">
                IP: {{ $lastAdminLogin->ip_address ?? '-' }}
            </p>
        @else
            <p class="text-slate-500">
                Belum ada riwayat login admin.
            </p>
        @endif
    </div>

    {{-- Filter --}}
    <form method="GET"
          action="{{ route('admin.login-histories.index') }}"
          class="grid gap-4 rounded-xl border bg-white
                 p-5 md:grid-cols-4">

        <select name="role"
                class="rounded-lg border border-slate-300 p-3">
            <option value="">Semua Role</option>

            @foreach(['admin', 'dokter', 'pasien'] as $role)
                <option value="{{ $role }}"
                        @selected(request('role') === $role)>
                    {{ ucfirst($role) }}
                </option>
            @endforeach
        </select>

        <select name="user_id"
                class="rounded-lg border border-slate-300 p-3">
            <option value="">Semua Pengguna</option>

            @foreach($users as $user)
                <option value="{{ $user->id }}"
                        @selected(request('user_id') == $user->id)>
                    {{ $user->name }} ({{ $user->role }})
                </option>
            @endforeach
        </select>

        <input type="date"
               name="date"
               value="{{ request('date') }}"
               class="rounded-lg border border-slate-300 p-3">

        <button type="submit"
                class="rounded-lg bg-blue-600 px-5 py-3
                       font-semibold text-white hover:bg-blue-700">
            Filter
        </button>
    </form>

    {{-- Tabel riwayat --}}
    <div class="overflow-x-auto rounded-xl border
                bg-white shadow-sm">

        <table class="min-w-full text-left text-sm">

            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="p-4">Pengguna</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Aktivitas</th>
                    <th class="p-4">Waktu</th>
                    <th class="p-4">IP Address</th>
                    <th class="p-4">Perangkat</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($histories as $history)
                    <tr>
                        <td class="p-4">
                            <p class="font-semibold text-slate-900">
                                {{ $history->user?->name ?? '-' }}
                            </p>

                            <p class="text-slate-500">
                                {{ $history->user?->email ?? '-' }}
                            </p>
                        </td>

                        <td class="p-4">
                            {{ ucfirst($history->user?->role ?? '-') }}
                        </td>

                        <td class="p-4">
                            @if($history->event === 'login')
                                <span class="rounded-full bg-green-100
                                             px-3 py-1 text-green-700">
                                    Login
                                </span>
                            @else
                                <span class="rounded-full bg-slate-100
                                             px-3 py-1 text-slate-700">
                                    Logout
                                </span>
                            @endif
                        </td>

                        <td class="p-4 whitespace-nowrap">
                            {{ $history->created_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td class="p-4">
                            {{ $history->ip_address ?? '-' }}
                        </td>

                        <td class="p-4 max-w-xs break-words text-slate-500">
                            {{ $history->user_agent ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="p-10 text-center text-slate-500">
                            Belum ada riwayat login.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{ $histories->links() }}

</div>
</x-admin-layout>