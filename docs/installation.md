# Installation

This guide will help you install and set up the Laravel Responses package in your Laravel project.

## Requirements

- PHP 8.1 or higher
- Laravel 9.0 or higher
- Composer

## Installation via Composer

Install the package using Composer:

```bash
composer require eborio/laravel-responses
```

## Service Provider Registration

The package will be auto-discovered by Laravel if you're using Laravel 5.5+ with package discovery. If you need to register it manually, add the service provider to your `config/app.php`:

```php
'providers' => [
    // ... other providers
    Eborio\LaravelResponses\ServiceProvider::class,
],
```

## Publishing Configuration

The package includes a configuration file that allows you to customize default messages, JSON encoding options, and other behaviors. To publish the configuration file:

```bash
php artisan vendor:publish --provider='Eborio\LaravelResponses\ServiceProvider' --tag='config'
```

This will create `config/laravel-responses.php` in your application.

## Available Interfaces

After installation, you can use the package through three different interfaces:

### 1. Global Helper Functions

The package provides global helper functions that are available throughout your application:

```php
laravel_responses_ok(['data' => 'value']);
laravel_responses_failed(['error' => 'details']);
```

### 2. ResponseFactory Macros

When Laravel's response factory is available, the package registers macros:

```php
response()->ok(['data' => 'value']);
response()->failed(['error' => 'details']);
```

### 3. Static Methods

Use the `Responses` class directly:

```php
use Eborio\LaravelResponses\Responses;

Responses::ok(['data' => 'value']);
Responses::failed(['error' => 'details']);
```

## Testing Installation

To verify the installation is working correctly, you can run the included tests:

```bash
vendor/bin/phpunit
```

All tests should pass, indicating the package is properly installed and configured.

## Next Steps

- Read the [Quick Start](quick-start.md) guide for basic usage examples
- Check the [Configuration](configuration.md) guide to customize the package
- Review the [API Reference](api-reference.md) for complete method documentation