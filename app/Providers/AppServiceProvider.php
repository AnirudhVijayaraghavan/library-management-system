<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\User;
use Inertia\Inertia;
use App\Policies\BookPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('isLibrarian', function (User $user) {
            // dd($user->role === 'librarian');
            return $user->role === 'librarian';
        });
    }
}
