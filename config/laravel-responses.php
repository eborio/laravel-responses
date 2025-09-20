<?php

use Eborio\LaravelResponses\Enums\Codes;

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
    | Default messages
    |--------------------------------------------------------------------------
    |
    | Default human friendly messages for common HTTP codes. These
    | values are fallbacks and can be overridden when calling the helpers.
    |
    */
    'default_messages' => [
        Codes::OK->value => Codes::OK->getFriendlyName(),
        Codes::UNAUTHENTICATED_USER->value => Codes::UNAUTHENTICATED_USER->getFriendlyName(),
        Codes::FORBIDDEN_RESOURCE->value => Codes::FORBIDDEN_RESOURCE->getFriendlyName(),
        Codes::RESOURCE_NOT_FOUND->value => Codes::RESOURCE_NOT_FOUND->getFriendlyName(),
        Codes::VALIDATION_ERRORS->value => Codes::VALIDATION_ERRORS->getFriendlyName(),
        Codes::SERVER_ERROR->value => Codes::SERVER_ERROR->getFriendlyName(),
        Codes::MAINTENANCE->value => Codes::MAINTENANCE->getFriendlyName(),
    ],
];
