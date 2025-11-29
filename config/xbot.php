<?php

use Al3x5\LaravelPsr16Cache;

return [
    'token' => env('BOT_TOKEN', ''),
    'admins' => env('ADMIN_TELEGRAM_ID', []),
    'cache' => new LaravelPsr16Cache,
    'debug' => env('APP_DEBUG', true),
    'abs_path' => base_path(),
];
