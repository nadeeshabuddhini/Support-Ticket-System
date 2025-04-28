<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
    // Inertia::share(function () {
    //     return [
    //         'auth' => [
    //             'user' => Auth::user() ? array_merge(
    //                 Auth::user()->only('id', 'name', 'email'),
    //                 [
    //                     'roles' => Auth::user()->getRoleNames(),
    //                 ]
    //             ) : null,
    //         ],
    //     ];
    // });
}
}
