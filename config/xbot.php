<?php

use Al3x5\LaravelPsr16Cache;

return [
    'token' => env('BOT_TOKEN', ''),
    'secret' => env('BOT_SECRET', null),
    'admins' => array_filter(array_map('trim', explode(',', env('ADMIN_TELEGRAM_ID', '')))),
    'cache' => new LaravelPsr16Cache(app('cache')->store()),
    'debug' => env('APP_DEBUG', true),
    'abs_path' => base_path(),
    'webhook' => env('BOT_WEBHOOK_URL', null),
];
