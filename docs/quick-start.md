# Quick Start

This guide provides basic usage examples to get you started with Laravel Responses quickly.

## Basic Response Structure

All responses follow a consistent JSON structure:

```json
{
  "status": "OK|ERROR|FAILED",
  "code": 200,
  "message": "Response message",
  "data": {}
}
```

## Success Responses

### OK Response (200)

```php
// Using helper function
return laravel_responses_ok(['user' => $user]);

// Using response macro
return response()->ok(['user' => $user]);

// Using static method
return Responses::ok(['user' => $user])->toResponse(request());
```

## Error Responses

### Validation Errors (422)

```php
$errors = [
    'email' => ['The email field is required.'],
    'password' => ['The password must be at least 8 characters.']
];

return laravel_responses_validation_errors($errors);
```

### Not Found (404)

```php
return response()->notFound([], 'User not found');
```

### Forbidden (403)

```php
return Responses::forbidden([], 'Access denied');
```

### Server Error (500)

```php
return laravel_responses_failed(['error' => 'Database connection failed']);
```

### Authentication Required (401)

```php
return response()->unauthenticated([], 'Please log in to continue');
```

## Custom Messages

You can override default messages by passing a custom message:

```php
// Custom success message
return laravel_responses_ok(['token' => $token], 'Login successful');

// Custom error message
return response()->notFound([], 'The requested resource could not be found');
```

## Response Data

Pass any serializable data in the data parameter:

```php
$userData = [
    'id' => 123,
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'roles' => ['admin', 'user']
];

return response()->ok($userData);
```

## Using in Controllers

Here's a complete controller example:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Eborio\LaravelResponses\Responses;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return Responses::notFound([], 'User not found');
        }

        return Responses::ok($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($validated);

        return Responses::ok($user, 'User created successfully');
    }
}
```

## Using in API Routes

```php
<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/users/{id}', function ($id) {
    $user = User::find($id);

    return $user
        ? laravel_responses_ok($user)
        : laravel_responses_not_found([], 'User not found');
});

Route::post('/users', function (Request $request) {
    // Validation and creation logic
    $user = User::create($request->validated());

    return laravel_responses_ok($user, 'User created');
});
```

## Next Steps

- Learn about [Configuration](configuration.md) options
- Explore detailed [Usage Guide](usage.md) patterns
- Check the complete [API Reference](api-reference.md)