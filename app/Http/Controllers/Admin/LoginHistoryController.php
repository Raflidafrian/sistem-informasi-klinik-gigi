<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginHistory::with('user');

        if ($request->filled('role')) {
            $role = $request->input('role');

            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        if ($request->filled('user_id')) {
            $query->where(
                'user_id',
                $request->input('user_id')
            );
        }

        if ($request->filled('date')) {
            $query->whereDate(
                'created_at',
                $request->input('date')
            );
        }

        $histories = $query
            ->latest('created_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $users = User::orderBy('name')->get([
            'id', 'name', 'email', 'role'
        ]);

        $lastAdminLogin = LoginHistory::with('user')
            ->where('event', 'login')
            ->whereHas('user', function ($q) {
                $q->where('role', 'admin');
            })
            ->latest('created_at')
            ->latest('id')
            ->first();

        return view(
            'admin.login-histories.index',
            compact('histories', 'users', 'lastAdminLogin')
        );
    }
}