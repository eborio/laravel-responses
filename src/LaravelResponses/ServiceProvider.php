<?php

namespace Eborio\LaravelResponses;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
    * Bootstrap the package: publish configuration and register helper macros.
    *
    * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/laravel-responses.php' => config_path('laravel-responses.php'),
        ], 'config');

        $this->registerMacros();
    }

    /**
    * Register bindings and merge package configuration.
    *
    * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravel-responses.php',
            'laravel-responses'
        );
    }

    /**
     * Register response macros (response()->ok(...)).
     *
     * This registers a set of macros on the framework ResponseFactory so
     * consumers can call `response()->ok(...)` and similar helpers.
     *
     * Public so tests can call it without bootstrapping the full provider lifecycle.
     *
     * @return void
     */
    public function registerMacros(): void
    {
        if (! class_exists(\Illuminate\Routing\ResponseFactory::class)) {
            return;
        }

        if (! method_exists(\Illuminate\Routing\ResponseFactory::class, 'macro')) {
            return;
        }

        \Illuminate\Routing\ResponseFactory::macro('ok', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::ok($data, $title)->toResponse($request);
        });

        \Illuminate\Routing\ResponseFactory::macro('failed', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::failed($data, $title)->toResponse($request);
        });

        \Illuminate\Routing\ResponseFactory::macro('forbidden', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::forbidden($data, $title)->toResponse($request);
        });

        \Illuminate\Routing\ResponseFactory::macro('notFound', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::notFound($data, $title)->toResponse($request);
        });

        \Illuminate\Routing\ResponseFactory::macro('unauthenticated', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::unauthenticated($data, $title)->toResponse($request);
        });

        \Illuminate\Routing\ResponseFactory::macro('validationErrors', function (array $data = [], string $title = '') {
            $request = function_exists('request') ? request() : null;

            return \Eborio\LaravelResponses\Responses::validationErrors($data, $title)->toResponse($request);
        });
    }
}
