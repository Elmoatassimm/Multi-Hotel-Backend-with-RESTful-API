<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendWelcomeEmail;
use App\Events\UserRegistered;


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
        Gate::define('isAdmin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::define('isUser', function (User $user) {
            return $user->role == 'guest';
        });


        Event::listen(
            UserRegistered::class,
            SendWelcomeEmail::class,
        );

    }
}
