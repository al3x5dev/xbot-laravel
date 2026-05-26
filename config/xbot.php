<?php

return [
    'token' => env('BOT_TOKEN', ''),
    'secret' => env('BOT_SECRET', null),
    'admins' => array_filter(array_map('trim', explode(',', env('ADMIN_TELEGRAM_ID', '')))),
    'debug' => env('APP_DEBUG', true),
    'abs_path' => base_path(),
];
