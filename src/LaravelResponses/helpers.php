<?php

/**
 * Return a failed JSON response (500).
 *
 * @param array $data Response data or error details
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_failed(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::failed($data, $title)->toResponse($request);
}

/**
 * Return a forbidden JSON response (403).
 *
 * @param array $data Response data payload
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_forbidden(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::forbidden($data, $title)->toResponse($request);
}

/**
 * Return a not found JSON response (404).
 *
 * @param array $data Response data payload
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_not_found(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::notFound($data, $title)->toResponse($request);
}

/**
 * Return a successful JSON response.
 *
 * This helper is a thin wrapper that constructs a package response and
 * converts it to a JsonResponse. The caller is responsible for translating
 * the title if necessary.
 *
 * @param array $data Response data payload
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_ok(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::ok($data)->toResponse($request);
}

/**
 * Return an unauthenticated JSON response (401).
 *
 * @param array $data Response data payload
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_unauthenticated(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::unauthenticated($data, $title)->toResponse($request);
}

/**
 * Return validation errors JSON response (422).
 *
 * @param array $data Validation error details
 * @param string $title Optional message/title
 * @return \Illuminate\Http\JsonResponse
 */
function laravel_responses_validation_errors(array $data = [], string $title = ''): \Illuminate\Http\JsonResponse
{
    $request = function_exists('request') ? request() : null;

    return \Eborio\LaravelResponses\Responses::validationErrors($data, $title)->toResponse($request);
}
