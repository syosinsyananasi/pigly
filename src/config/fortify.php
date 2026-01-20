<?php

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;

return [

    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'email' => 'email',

    'lowercase_usernames' => true,

    'home' => '/weight_logs',

    'prefix' => '',

    'domain' => null,

    'middleware' => ['web'],

    'limiters' => [
        'login' => null,
        'two-factor' => null,
    ],

    'views' => true,

    'features' => [
        Features::registration(),
    ],

];
