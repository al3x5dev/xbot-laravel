<?php

use Al3x5\LaravelPsr16Cache;

return [
    'token' => env('BOT_TOKEN'),
    'admins' => [],
    'cache' => new LaravelPsr16Cache,
    'debug' => true,
    'abs_path' => base_path(),
];
