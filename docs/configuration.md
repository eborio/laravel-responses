# Configuration

This guide explains how to configure the Laravel Responses package to customize its behavior.

## Publishing the Configuration File

First, publish the configuration file:

```bash
php artisan vendor:publish --provider='Eborio\LaravelResponses\ServiceProvider' --tag='config'
```

This creates `config/laravel-responses.php` in your application.

## Configuration Options

### JSON Options

Control how JSON responses are encoded:

```php
'json_options' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
```

Available options:
- `JSON_UNESCAPED_UNICODE` - Don't escape Unicode characters
- `JSON_UNESCAPED_SLASHES` - Don't escape forward slashes
- `JSON_PRETTY_PRINT` - Pretty-print JSON (useful for development)
- `JSON_NUMERIC_CHECK` - Convert numeric strings to numbers

### Include Stack Traces

Enable stack traces in error responses during development:

```php
'include_stack_trace' => env('APP_DEBUG', false),
```

When enabled, failed responses will include exception stack traces in the data.

### Default Messages

Customize default messages for each HTTP status code:

```php
'default_messages' => [
    \Eborio\LaravelResponses\Enums\Codes::OK->value => 'Success',
    \Eborio\LaravelResponses\Enums\Codes::UNAUTHENTICATED_USER->value => 'Authentication required',
    \Eborio\LaravelResponses\Enums\Codes::FORBIDDEN_RESOURCE->value => 'Access denied',
    \Eborio\LaravelResponses\Enums\Codes::RESOURCE_NOT_FOUND->value => 'Resource not found',
    \Eborio\LaravelResponses\Enums\Codes::VALIDATION_ERRORS->value => 'Validation failed',
    \Eborio\LaravelResponses\Enums\Codes::SERVER_ERROR->value => 'Internal server error',
    \Eborio\LaravelResponses\Enums\Codes::MAINTENANCE->value => 'Service temporarily unavailable',
],
```

## Environment-Specific Configuration

Use Laravel's environment configuration to customize behavior per environment:

### Development Configuration

```php
// config/laravel-responses.php
return [
    'json_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,
    'include_stack_trace' => true,
    'default_messages' => [
        // Custom development messages
    ],
];
```

### Production Configuration

```php
// config/laravel-responses.php
return [
    'json_options' => JSON_UNESCAPED_UNICODE,
    'include_stack_trace' => false,
    'default_messages' => [
        // User-friendly production messages
    ],
];
```

## Custom Configuration Examples

### Localized Messages

Use Laravel's localization features:

```php
'default_messages' => [
    Codes::OK->value => __('responses.success'),
    Codes::RESOURCE_NOT_FOUND->value => __('responses.not_found'),
    Codes::VALIDATION_ERRORS->value => __('responses.validation_failed'),
    // ...
],
```

### API Version-Specific Messages

```php
'default_messages' => [
    Codes::OK->value => 'v2.0 - Operation completed successfully',
    Codes::SERVER_ERROR->value => 'v2.0 - An unexpected error occurred',
    // ...
],
```

### Custom Status Messages

```php
'default_messages' => [
    Codes::OK->value => '✅ Success',
    Codes::SERVER_ERROR->value => '❌ Something went wrong',
    Codes::RESOURCE_NOT_FOUND->value => '🔍 Resource not available',
    // ...
],
```

## Advanced Configuration

### Custom Response Classes

Extend the package with custom response logic:

```php
<?php

namespace App\Responses;

use Eborio\LaravelResponses\Responses;

class CustomResponses extends Responses
{
    public static function customSuccess($data, $message = null)
    {
        $message = $message ?: config('laravel-responses.custom_success_message');
        return parent::ok($data, $message);
    }

    public static function customError($data, $message = null)
    {
        $message = $message ?: config('laravel-responses.custom_error_message');
        return parent::failed($data, $message);
    }
}
```

Add to configuration:

```php
// config/laravel-responses.php
'custom_success_message' => 'Operation completed',
'custom_error_message' => 'Operation failed',
```

### Middleware Configuration

Create middleware to modify responses globally:

```php
<?php

namespace App\Http\Middleware;

use Closure;

class ApiResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Eborio\LaravelResponses\Responses) {
            // Add custom headers or modify response
            $jsonResponse = $response->toResponse($request);
            $jsonResponse->headers->set('X-API-Version', config('app.api_version'));

            return $jsonResponse;
        }

        return $response;
    }
}
```

## Configuration Validation

The package includes configuration validation. If you modify the configuration file, ensure:

1. All required keys are present
2. HTTP codes match the `Codes` enum values
3. JSON options are valid PHP constants
4. Messages are strings or callables

## Troubleshooting

### Configuration Not Loading

If your configuration changes aren't taking effect:

1. Clear the configuration cache: `php artisan config:clear`
2. Restart your web server
3. Check that the file is in the correct location: `config/laravel-responses.php`

### Default Messages Not Working

If default messages aren't being used:

1. Verify the configuration file is published
2. Check that you're not overriding messages in your code
3. Ensure the HTTP codes match exactly with the `Codes` enum

### JSON Encoding Issues

If you experience JSON encoding problems:

1. Check your `json_options` configuration
2. Ensure data passed to responses is JSON-serializable
3. Use `JSON_PARTIAL_OUTPUT_ON_ERROR` for debugging

## Best Practices

1. **Environment-Specific Settings**: Use different configurations for development and production
2. **Localization**: Use Laravel's localization features for multi-language support
3. **Versioning**: Include API version information in messages for versioned APIs
4. **Consistency**: Keep message styles consistent across your application
5. **Documentation**: Document custom configuration options for your team
6. **Testing**: Test configuration changes in all environments

## Next Steps

- Read the [Usage Guide](usage.md) for implementation examples
- Check the [API Reference](api-reference.md) for available methods
- Review the [Testing](testing.md) guide for configuration testing