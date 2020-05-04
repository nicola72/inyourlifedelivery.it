<?php

use App\Model\Cms\UserCms;
use App\User;

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'cms' => [
            'driver' => 'session',
            'provider' => 'users_cms',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'users_cms' => [
            'driver' => 'eloquent',
            'model' => App\Model\Cms\UserCms::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'users_cms' => [
            'provider' => 'users_cms',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
