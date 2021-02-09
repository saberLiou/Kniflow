<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Eloquent relationships: custom polymorphic types.
        Relation::morphMap([
            User::TABLE => 'App\Models\User',
        ]);

        // Override default model of Sanctum.
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
