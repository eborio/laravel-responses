# Laravel Responses

Unified JSON response helper for Laravel projects.

This package provides a small, framework-friendly API to build consistent JSON responses across your application. It exposes:

- Global helper functions (helpers)
- ResponseFactory macros (when Laravel's response factory is present)
- A central {@see \Eborio\LaravelResponses\Responses} class with static factory methods for common response patterns

All example code in this README assumes you will pass translated messages from your application code (do not call translation helpers from inside the package).

## Installation

Install the package via Composer:

```bash
composer require eborio/laravel-responses
```

Optionally publish the configuration file:

```bash
php artisan vendor:publish --provider='Eborio\LaravelResponses\ServiceProvider' --tag='config'
```

## Quick usage

Below are the common ways to create responses using macros, helpers and the static methods provided by the `Responses` class.

### Helpers (global functions)

The package exposes small helper functions that return a `\Eborio\LaravelResponses\Responses` instance. Helpers are useful in routes and controllers for short, readable code:

```php
// return JSON 200
return laravel_responses_ok(['user' => $user]);

// return JSON 422 with a custom message
return laravel_responses_validation_errors(['errors' => $errors], 'Please check the form');
```

Helper names are alphabetical and follow the pattern `laravel_responses_{action}` (for example: `laravel_responses_ok`).

### ResponseFactory macros

When Laravel's `Illuminate\Contracts\Routing\ResponseFactory` is available, the package registers macros so you can use the familiar `response()` helper in a fluent way:

```php
// returns the same as laravel_responses_ok([...])
response()->laravel_responses_ok(['user' => $user]);
```

### Default messages

Default messages for HTTP codes are now generated automatically from the enum case name using the `getFriendlyName()` method. The configuration file uses `Codes::getFriendlyName()` to populate the `default_messages` array. The `Responses` class will use the configured message if available, or fallback to the enum's friendly name.

You can override these defaults by passing a custom message.

```php
// Uses the default message for 404 from Codes enum
return laravel_responses_not_found();

// Uses a custom message
return laravel_responses_not_found([], 'Custom not found message');
```

## Configuration

The configuration file allows you to customize default messages, JSON options, and other behaviors. See `config/laravel-responses.php` for details.

## License

MIT
