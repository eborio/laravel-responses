# API Reference

This document provides complete API reference for the Laravel Responses package.

## Classes

### Responses

The main response class that implements `Responsable` interface.

#### Static Methods

##### `ok(array $data = [], string $message = ''): static`

Creates a successful (200) response.

**Parameters:**
- `$data` (array): Response payload data
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::ok(['user' => $user]);
Responses::ok(['user' => $user], 'User retrieved successfully');
```

##### `failed(array $data = [], string $message = ''): static`

Creates a server error (500) response.

**Parameters:**
- `$data` (array): Error details or payload data
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::failed(['error' => 'Database connection failed']);
```

##### `forbidden(array $data = [], string $message = ''): static`

Creates a forbidden (403) response.

**Parameters:**
- `$data` (array): Optional payload data
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::forbidden([], 'Access denied');
```

##### `notFound(array $data = [], string $message = ''): static`

Creates a not found (404) response.

**Parameters:**
- `$data` (array): Optional payload data
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::notFound([], 'User not found');
```

##### `unauthenticated(array $data = [], string $message = ''): static`

Creates an unauthenticated (401) response.

**Parameters:**
- `$data` (array): Optional payload data
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::unauthenticated([], 'Please log in');
```

##### `validationErrors(array $data = [], string $message = ''): static`

Creates a validation errors (422) response.

**Parameters:**
- `$data` (array): Validation errors array
- `$message` (string): Optional custom message

**Returns:** Responses instance

**Example:**
```php
Responses::validationErrors($validator->errors()->toArray());
```

#### Instance Methods

##### `getData(bool $assoc = false): array`

Returns the full response payload as an array.

**Parameters:**
- `$assoc` (bool): Whether to return as associative array (unused for compatibility)

**Returns:** array - The full payload

**Example:**
```php
$response = Responses::ok(['user' => $user]);
$data = $response->getData(); // Returns ['status' => 'OK', 'code' => 200, 'message' => 'Ok', 'data' => ['user' => $user]]
```

##### `getStatusCode(): int`

Returns the HTTP status code of the response.

**Returns:** int - The HTTP status code

**Example:**
```php
$response = Responses::ok(['user' => $user]);
$code = $response->getStatusCode(); // Returns 200
```

##### `toResponse($request): JsonResponse`

Converts the response to a Laravel JsonResponse.

**Parameters:**
- `$request` (mixed): The incoming request instance

**Returns:** JsonResponse

**Example:**
```php
$response = Responses::ok(['data' => 'value']);
return $response->toResponse(request());
```

#### Constructor

##### `__construct(int|Codes $httpCode, array $data = [], string $message = '')`

Creates a new Responses instance.

**Parameters:**
- `$httpCode` (int|Codes): HTTP status code or Codes enum case
- `$data` (array): Response payload data
- `$message` (string): Optional message

**Example:**
```php
new Responses(200, ['data' => 'value'], 'Success');
new Responses(Codes::OK, ['data' => 'value']);
```

## Enums

### Codes

HTTP status codes enum.

#### Cases

- `OK = 200` - Successful request
- `UNAUTHENTICATED_USER = 401` - Authentication required
- `FORBIDDEN_RESOURCE = 403` - Access denied
- `RESOURCE_NOT_FOUND = 404` - Resource not found
- `VALIDATION_ERRORS = 422` - Validation failed
- `SERVER_ERROR = 500` - Internal server error
- `MAINTENANCE = 503` - Service unavailable

#### Methods

##### `statusFromHttpCode(int $code): Status`

Maps HTTP status code to semantic status.

**Parameters:**
- `$code` (int): HTTP status code

**Returns:** Status enum case

**Example:**
```php
Codes::statusFromHttpCode(200); // Returns Status::OK
Codes::statusFromHttpCode(404); // Returns Status::ERROR
```

##### `toStatus(): Status`

Gets semantic status for this code.

**Returns:** Status enum case

**Example:**
```php
Codes::OK->toStatus(); // Returns Status::OK
Codes::SERVER_ERROR->toStatus(); // Returns Status::FAILED
```

##### `getFriendlyName(): string`

Returns human-friendly name for the code.

**Returns:** string

**Example:**
```php
Codes::OK->getFriendlyName(); // "Ok"
Codes::RESOURCE_NOT_FOUND->getFriendlyName(); // "Resource Not Found"
```

### Status

Semantic status enum.

#### Cases

- `OK` - Successful operation
- `ERROR` - Client or validation error
- `FAILED` - Server error

## Global Helper Functions

### Success Responses

#### `laravel_responses_ok(array $data = [], string $message = ''): Responses`

Creates OK response using helper.

**Parameters:**
- `$data` (array): Response payload
- `$message` (string): Optional message

**Returns:** Responses instance

#### `laravel_responses_failed(array $data = [], string $message = ''): Responses`

Creates failed response using helper.

**Parameters:**
- `$data` (array): Error payload
- `$message` (string): Optional message

**Returns:** Responses instance

### Error Responses

#### `laravel_responses_forbidden(array $data = [], string $message = ''): Responses`

Creates forbidden response using helper.

**Parameters:**
- `$data` (array): Optional payload
- `$message` (string): Optional message

**Returns:** Responses instance

#### `laravel_responses_not_found(array $data = [], string $message = ''): Responses`

Creates not found response using helper.

**Parameters:**
- `$data` (array): Optional payload
- `$message` (string): Optional message

**Returns:** Responses instance

#### `laravel_responses_unauthenticated(array $data = [], string $message = ''): Responses`

Creates unauthenticated response using helper.

**Parameters:**
- `$data` (array): Optional payload
- `$message` (string): Optional message

**Returns:** Responses instance

#### `laravel_responses_validation_errors(array $data = [], string $message = ''): Responses`

Creates validation errors response using helper.

**Parameters:**
- `$data` (array): Validation errors
- `$message` (string): Optional message

**Returns:** Responses instance

## ResponseFactory Macros

When available, the package registers macros on Laravel's ResponseFactory.

### Success Macros

#### `response()->ok(array $data = [], string $message = ''): Responses`

Creates OK response using macro.

#### `response()->failed(array $data = [], string $message = ''): Responses`

Creates failed response using macro.

### Error Macros

#### `response()->forbidden(array $data = [], string $message = ''): Responses`

Creates forbidden response using macro.

#### `response()->notFound(array $data = [], string $message = ''): Responses`

Creates not found response using macro.

#### `response()->unauthenticated(array $data = [], string $message = ''): Responses`

Creates unauthenticated response using macro.

#### `response()->validationErrors(array $data = [], string $message = ''): Responses`

Creates validation errors response using macro.

## Response Structure

All responses follow this JSON structure:

```json
{
  "status": "OK|ERROR|FAILED",
  "code": 200,
  "message": "Response message",
  "data": {}
}
```

### Field Descriptions

- **status** (string): Semantic status - "OK", "ERROR", or "FAILED"
- **code** (int): HTTP status code
- **message** (string): Human-readable message
- **data** (array): Response payload data

## Configuration Reference

### Configuration File: `config/laravel-responses.php`

```php
return [
    /*
    |--------------------------------------------------------------------------
    | JSON options
    |--------------------------------------------------------------------------
    */
    'json_options' => JSON_UNESCAPED_UNICODE,

    /*
    |--------------------------------------------------------------------------
    | Include stack traces
    |--------------------------------------------------------------------------
    */
    'include_stack_trace' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Default messages
    |--------------------------------------------------------------------------
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
```

## Exceptions

The package may throw the following exceptions:

### `ValueError`

Thrown when an invalid HTTP code is passed to `Codes::from()`.

### `Throwable`

Configuration-related exceptions when Laravel's `config()` helper is unavailable.

## Type Definitions

### Method Signatures

```php
interface Responsable
{
    public function toResponse($request): JsonResponse;
}
```

### Data Types

- All response data must be JSON-serializable
- Messages must be strings
- HTTP codes must be valid integers or `Codes` enum cases
- Status values are automatically determined from HTTP codes

## Examples

### Basic Usage

```php
// Static methods
Responses::ok(['user' => $user]);
Responses::notFound([], 'User not found');

// Helpers
laravel_responses_ok(['data' => 'value']);
laravel_responses_failed(['error' => 'message']);

// Macros
response()->ok(['data' => 'value']);
response()->validationErrors($errors);
```

### Advanced Usage

```php
// Custom messages
Responses::ok(['user' => $user], 'User retrieved successfully');

// Complex data
Responses::ok([
    'user' => $user,
    'permissions' => ['read', 'write'],
    'metadata' => ['version' => '1.0']
]);

// Error with details
Responses::failed([
    'error_code' => 'DATABASE_ERROR',
    'error_details' => 'Connection timeout',
    'reference_id' => 'ref_123456'
], 'Database operation failed');
```

## See Also

- [Installation](installation.md)
- [Quick Start](quick-start.md)
- [Usage Guide](usage.md)
- [Configuration](configuration.md)
- [Testing](testing.md)