<?php

namespace App\Providers;

use App\Models\LoginHistory;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mencatat aktivitas login
        Event::listen(Login::class, function (Login $event) {
            LoginHistory::create([
                'user_id' => $event->user->getAuthIdentifier(),
                'event' => 'login',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        // Mencatat aktivitas logout
        Event::listen(Logout::class, function (Logout $event) {
            if (!$event->user) {
                return;
            }

            LoginHistory::create([
                'user_id' => $event->user->getAuthIdentifier(),
                'event' => 'logout',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}