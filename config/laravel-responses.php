<?php

return [
    /*
    |--------------------------------------------------------------------------
    | JSON options
    |--------------------------------------------------------------------------
    |
    | Options forwarded to json_encode when building responses. You can set
    | JSON_PRETTY_PRINT for local development if desired.
    |
    */
    'json_options' => JSON_UNESCAPED_UNICODE,

    /*
    |--------------------------------------------------------------------------
    | Include stack traces
    |--------------------------------------------------------------------------
    |
    | When enabled (usually in local or debug environments) the package will
    | include exception stack traces in failed responses. Disabled by default.
    |
    */
    'include_stack_trace' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Default titles
    |--------------------------------------------------------------------------
    |
    | Default human friendly titles/messages for common HTTP codes. These
    | values are fallbacks and can be overridden when calling the helpers.
    |
    */
    'default_titles' => [
        200 => 'OK',
        401 => 'Unauthenticated user',
        403 => 'Forbidden resource',
        404 => 'Item not found',
        422 => 'Incomplete form',
        500 => 'Server error',
        503 => 'Maintenance',
    ],
];
