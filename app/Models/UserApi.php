<?php

namespace App\Models;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;


class UserApi extends SanctumPersonalAccessToken
{
 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}