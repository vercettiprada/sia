<?php

namespace App\Providers;

// Remove the line: use App\Models\User; (unless used elsewhere)
use App\Auth\HardcodedUserProvider; // <-- Keep this line from our previous step
use Illuminate\Support\Facades\Auth; // <-- Keep this line (or use Illuminate\Support\Facades\Auth;)
// Remove the line: use Illuminate\Support\Facades\Gate; (unless used elsewhere)
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // --- REMOVE THIS ENTIRE BLOCK ---
        /*
        $this->app['auth']->viaRequest('api', function ($request) {
           if ($request->input('api_token')) {
               return User::where('api_token', $request->input('api_token'))->first();
           }
        });
        */
        // --- END OF REMOVAL ---


        // --- KEEP THIS BLOCK FROM OUR PREVIOUS STEP ---
        // This registers our custom driver logic.
        Auth::provider('custom_hardcoded', function ($app, array $config) {
            // Return an instance of our custom user provider,
            // passing the configuration array ($config) from config/auth.php
            // for the 'hardcoded_user_provider'.
            return new HardcodedUserProvider($config);
        });
        // --- END OF BLOCK TO KEEP ---
    }
}