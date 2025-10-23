<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ParticipantAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Extend auth untuk participant tanpa password hashing
        Auth::provider('participant', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends \Illuminate\Auth\EloquentUserProvider {
                public function validateCredentials($user, array $credentials)
                {
                    // Untuk participant, bandingkan password plain dengan NIM
                    if (isset($credentials['password']) && $user instanceof \App\Models\Participant) {
                        return $credentials['password'] === $user->nim;
                    }

                    return parent::validateCredentials($user, $credentials);
                }
            };
        });
    }
}
