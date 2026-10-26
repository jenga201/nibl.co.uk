<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Data cache
    |--------------------------------------------------------------------------
    |
    | Driver used to cache news responses: "apcu", "redis" or "array".
    |
    */

    'data_cache' => env('NIBL_DATA_CACHE', 'apcu'),

    'redis' => [
        'host' => env('NIBL_REDIS_HOST', '127.0.0.1'),
        'port' => (int) env('NIBL_REDIS_PORT', 6379),
        'prefix' => env('NIBL_REDIS_PREFIX', 'nibl'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP caching
    |--------------------------------------------------------------------------
    |
    | Browser cache lifetime (seconds) applied to every HTML response.
    |
    */

    'http_cache_max_age' => (int) env('NIBL_HTTP_CACHE_MAX_AGE', 86400),

];
