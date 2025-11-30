<?php

use App\Models\Usuario; // Importar el modelo Usuario

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios', // Usamos 'usuarios' aquí también para los resets (aunque no los implementemos)
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Aquí se define el "guard" por defecto ('web'). Le decimos que use el
    | 'provider' llamado 'usuarios' que definiremos más abajo.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios', // CLAVE: Usa el proveedor 'usuarios' que apunta a tu modelo.
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Este es el proveedor que le dice a Laravel qué modelo (tabla) usar.
    |
    */

    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => Usuario::class, // CLAVE: Apunta a tu modelo App\Models\Usuario
        ],
        // Puedes dejar el provider 'users' original comentado si lo deseas
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configuramos el reseteo de contraseña para usar el provider 'usuarios'.
    |
    */

    'passwords' => [
        'usuarios' => [ // Usamos 'usuarios' en lugar de 'users'
            'provider' => 'usuarios',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
