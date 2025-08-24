
# Laravel Responses

Unified JSON response helper for Laravel projects.

This package provides a small, framework-friendly API to build
consistent JSON responses across your application. It exposes:

- Global helper functions (helpers)
- ResponseFactory macros (when Laravel's response factory is present)
- A central {@see \Eborio\LaravelResponses\Responses} class with
	static factory methods for common response patterns

All example code in this README assumes you will pass translated
message titles from your application code (do not call translation
helpers from inside the package).

## Installation

Install the package via Composer (replace the package name if needed):

```bash
composer require eborio/laravel-responses
```

Optionally publish the configuration file:

```bash
php artisan vendor:publish --provider="Eborio\LaravelResponses\ServiceProvider" --tag="config"
```

## Quick usage

Below are the common ways to create responses using macros, helpers
and the static methods provided by the `Responses` class.

### Helpers (global functions)

The package exposes small helper functions that return a
`\Eborio\LaravelResponses\Responses` instance. Helpers are useful in
routes and controllers for short, readable code:

```php
// return JSON 200
return laravel_responses_ok(['user' => $user]);

// return JSON 422 with a custom title (already translated by caller)
return laravel_responses_validation_errors(['errors' => $errors], _i('Please check the form'));
```

Helper names are alphabetical and follow the pattern
`laravel_responses_{action}` (for example: `laravel_responses_ok`).

### ResponseFactory macros

When Laravel's `Illuminate\Contracts\Routing\ResponseFactory` is
available, the package registers macros so you can use the familiar
`response()` helper in a fluent way:

```php
// returns the same as laravel_responses_ok([...])
return response()->ok(['foo' => 'bar']);

// other macros: failed(), forbidden(), notFound(), unauthenticated(), validationErrors()
```

Macros are registered conditionally to avoid errors in non-Laravel
environments or during isolated unit tests.

### Static factory methods

You can also use the central `Responses` static methods directly:

```php
use Eborio\LaravelResponses\Responses;

return Responses::ok(['data' => $payload]);

return Responses::failed([], _i('Unexpected server error'));
```

## Available helpers, macros and static methods

This section lists the helpers, response factory macros and static
methods provided by the package so you can quickly discover the
available API surface.

### Helpers (global functions)

All helper functions return a `\Illuminate\Http\JsonResponse` and are
safe to call from routes and controllers. Helpers are autoloaded from
the package `helpers.php` file.

- `laravel_responses_failed(array $data = [], string $title = '')`
	- Return a 500 server error response.
- `laravel_responses_forbidden(array $data = [], string $title = '')`
	- Return a 403 forbidden response.
- `laravel_responses_not_found(array $data = [], string $title = '')`
	- Return a 404 not found response.
- `laravel_responses_ok(array $data = [], string $title = '')`
	- Return a 200 OK response.
- `laravel_responses_unauthenticated(array $data = [], string $title = '')`
	- Return a 401 unauthenticated response.
- `laravel_responses_validation_errors(array $data = [], string $title = '')`
	- Return a 422 validation errors response.

Example (helpers):

```php
return laravel_responses_ok(['user' => $user]);
```

### ResponseFactory macros

When the framework response factory is present the provider registers
the following macros on `response()` so you can write `response()->ok(...)`:

- `ok(array $data = [], string $title = '')`
- `failed(array $data = [], string $title = '')`
- `forbidden(array $data = [], string $title = '')`
- `notFound(array $data = [], string $title = '')`
- `unauthenticated(array $data = [], string $title = '')`
- `validationErrors(array $data = [], string $title = '')`

Example (macro):

```php
return response()->validationErrors(['errors' => $errors], _i('Please check the form'));
```

### Responses static methods

The main `Responses` class exposes a set of static factory methods that
return configured `Responses` instances. You can use them directly and
call `toResponse()` or return the instance from a controller (it is
`Responsable`).

- `Responses::ok(array $data): Responses` — successful (200) response.
- `Responses::failed(array $data = [], string $title = 'Server error'): Responses` — server error (500).
- `Responses::forbidden(array $data = [], string $title = 'Forbidden resource'): Responses` — 403 forbidden.
- `Responses::notFound(array $data = [], string $title = 'Item not found'): Responses` — 404 not found.
- `Responses::unauthenticated(array $data = [], string $title = 'Unauthenticated user'): Responses` — 401 unauthenticated.
- `Responses::validationErrors(array $data = [], string $title = 'Incomplete form'): Responses` — 422 validation errors.

Example (static method):

```php
use Eborio\LaravelResponses\Responses;

return Responses::forbidden([], _i('You do not have access'));
```

## Response payload format

All responses follow the same JSON structure:

```json
{
	"status": "ok|failed|error",
	"code": 200,
	"message": "A short message or title",
	"data": { /* payload */ }
}
```

The `status` value is derived from the HTTP code and represented by the
package `Status` enum. The `code` is the numeric HTTP status code.

If you pass an array with a `title` key inside the data payload, that
title will become the `message` and will be removed from the `data`
section in the final payload.

## Configuration

The package ships with a `config/laravel-responses.php` file that
allows you to change JSON encoding options and default titles. After
publishing the config you can set options like `json_options`.

## Testing

The package includes PHPUnit tests. To run them locally:

```bash
composer install --dev
vendor/bin/phpunit
```

When writing tests for code that uses `Responses`, prefer asserting on
the produced array payload by calling the `toArray()` method on the
instance (or by returning the `Responses` object and asserting the
`JsonResponse` content in integration tests).

Example assertion using PHPUnit:

```php
use Eborio\LaravelResponses\Responses;

$response = Responses::ok(['user' => ['id' => 1, 'name' => 'Alice']]);
$payload = $response->toArray();

$this->assertSame('ok', $payload['status']);
$this->assertSame(200, $payload['code']);
```

## Contributing

Contributions are welcome. Please follow the repository coding
standards: English code + docblocks, descriptive PHPDocBlocks, and
alphabetical ordering for helper functions.

Before submitting a pull request, run:

```bash
composer install
composer test
```

## Changelog

See `CHANGELOG.md` for notable changes and release notes.

