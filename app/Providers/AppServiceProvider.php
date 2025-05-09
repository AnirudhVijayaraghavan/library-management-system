<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Inertia::share([

            // share only these flash keys
            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'failure' => Session::get('failure'),
                ];
            },
            'auth.user' => fn() => Auth::user()
                ? ['id' => Auth::id(), 'name' => Auth::user()->name, 'role' => Auth::user()->role]
                : null,
        ]);
    }
}
