<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
    public function boot()
    {
        Validator::extend('unique_email_except_current', function ($attribute, $value, $parameters, $validator) {
            // Retrieve the current user
            $user = auth()->user();

            // Check if any other user with the given email exists
            return \App\Models\User::where('email', $value)
                            ->where('id', '!=', $user->id)
                            ->doesntExist();
        });
    }
}
