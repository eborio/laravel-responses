# Usage Guide

This guide covers advanced usage patterns and detailed examples for the Laravel Responses package.

## Response Types and HTTP Codes

The package provides responses for common HTTP scenarios:

| Response Type | HTTP Code | Status | Use Case |
|---------------|-----------|--------|----------|
| OK | 200 | OK | Successful operations |
| Unauthenticated | 401 | ERROR | Authentication required |
| Forbidden | 403 | ERROR | Authorization failed |
| Not Found | 404 | ERROR | Resource not found |
| Validation Errors | 422 | ERROR | Input validation failed |
| Server Error | 500 | FAILED | Internal server errors |
| Maintenance | 503 | FAILED | Service unavailable |

## Advanced Data Handling

### Nested Data Structures

```php
$data = [
    'user' => [
        'id' => 123,
        'profile' => [
            'name' => 'John Doe',
            'avatar' => 'https://example.com/avatar.jpg'
        ]
    ],
    'permissions' => ['read', 'write', 'delete'],
    'metadata' => [
        'created_at' => now(),
        'version' => '1.0'
    ]
];

return response()->ok($data);
```

### Pagination Data

```php
$users = User::paginate(20);

return laravel_responses_ok([
    'users' => $users->items(),
    'pagination' => [
        'current_page' => $users->currentPage(),
        'last_page' => $users->lastPage(),
        'per_page' => $users->perPage(),
        'total' => $users->total(),
    ]
]);
```

### Error Details

```php
try {
    // Some operation that might fail
    $result = $this->processPayment($paymentData);
    return response()->ok(['transaction_id' => $result->id]);
} catch (PaymentException $e) {
    return Responses::failed([
        'error_code' => $e->getCode(),
        'error_details' => $e->getMessage(),
        'reference_id' => $this->generateReferenceId()
    ], 'Payment processing failed');
}
```

## Message Handling

### Using Default Messages

The package automatically generates default messages from enum names:

```php
// Uses "Resource Not Found" as default message
return laravel_responses_not_found();

// Uses "Validation Errors" as default message
return response()->validationErrors($errors);
```

### Custom Messages

Override defaults with custom messages:

```php
return Responses::notFound([], 'The user you are looking for does not exist');

// Localized messages
return laravel_responses_ok($data, __('messages.user.created'));
```

### Message from Data

You can include a `message` key in your data array:

```php
return response()->ok([
    'message' => 'Custom success message',
    'user' => $user,
    'token' => $token
]);
```

### Payload Structure

Use the `payload` key to separate message from data:

```php
return laravel_responses_ok([
    'payload' => [
        'message' => 'This will be ignored as message',
        'user' => $user,
        'other_data' => $additionalData
    ]
], 'This will be the actual message');
```

## Error Handling Patterns

### Validation Errors

```php
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return response()->validationErrors(
            $validator->errors()->toArray(),
            'Please correct the following errors'
        );
    }

    // Create user...
    return response()->ok($user, 'User created successfully');
}
```

### Exception Handling

```php
public function show($id)
{
    try {
        $user = User::findOrFail($id);
        return response()->ok($user);
    } catch (ModelNotFoundException $e) {
        return Responses::notFound([], 'User not found');
    } catch (Exception $e) {
        Log::error('User lookup failed', ['id' => $id, 'error' => $e->getMessage()]);
        return laravel_responses_failed([], 'An unexpected error occurred');
    }
}
```

### Authorization

```php
public function update(Request $request, Post $post)
{
    if ($request->user()->cannot('update', $post)) {
        return response()->forbidden([], 'You do not have permission to edit this post');
    }

    // Update post...
    return response()->ok($post, 'Post updated successfully');
}
```

## API Resource Integration

### Using Laravel API Resources

```php
use App\Http\Resources\UserResource;

public function show(User $user)
{
    return response()->ok(new UserResource($user));
}

public function index()
{
    $users = User::paginate();
    return response()->ok([
        'users' => UserResource::collection($users),
        'pagination' => [
            'current_page' => $users->currentPage(),
            'total' => $users->total(),
        ]
    ]);
}
```

### Custom Response Classes

```php
<?php

namespace App\Responses;

use Eborio\LaravelResponses\Responses;

class ApiResponse
{
    public static function success($data, string $message = ''): Responses
    {
        return Responses::ok($data, $message ?: 'Operation successful');
    }

    public static function error(string $message, array $errors = [], int $code = 400): Responses
    {
        // Custom logic for different error codes
        return match($code) {
            404 => Responses::notFound($errors, $message),
            403 => Responses::forbidden($errors, $message),
            422 => Responses::validationErrors($errors, $message),
            default => Responses::failed($errors, $message)
        };
    }
}

// Usage
return ApiResponse::success($user);
return ApiResponse::error('Invalid request', $validationErrors, 422);
```

## Testing Responses

### Testing Response Structure

```php
public function test_user_creation_returns_correct_response()
{
    $userData = ['name' => 'John', 'email' => 'john@example.com'];

    $response = $this->postJson('/api/users', $userData);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'code',
                 'message',
                 'data' => [
                     'id',
                     'name',
                     'email'
                 ]
             ])
             ->assertJson([
                 'status' => 'OK',
                 'code' => 200,
                 'message' => 'User created successfully'
             ]);
}
```

### Testing Error Responses

```php
public function test_invalid_data_returns_validation_errors()
{
    $response = $this->postJson('/api/users', []);

    $response->assertStatus(422)
             ->assertJson([
                 'status' => 'ERROR',
                 'code' => 422,
                 'message' => 'Validation Errors'
             ]);
}
```

## Middleware Integration

### Response Transformation Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TransformApiResponses
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Transform Laravel Responses to your custom format
        if ($response instanceof \Eborio\LaravelResponses\Responses) {
            $data = $response->toResponse($request)->getData(true);

            // Apply custom transformations
            $data['timestamp'] = now()->toISOString();
            $data['request_id'] = $request->header('X-Request-ID');

            return response()->json($data, $response->getStatusCode());
        }

        return $response;
    }
}
```

## Performance Considerations

### Response Caching

```php
public function index()
{
    $users = Cache::remember('users.list', 3600, function () {
        return User::all();
    });

    return response()->ok($users)->withHeaders([
        'Cache-Control' => 'public, max-age=3600'
    ]);
}
```

### Lazy Loading

```php
public function show(User $user)
{
    // Avoid N+1 queries
    $user->load(['posts', 'comments']);

    return response()->ok($user);
}
```

## Best Practices

1. **Consistent Error Handling**: Use the same response types across your API
2. **Meaningful Messages**: Provide clear, actionable error messages
3. **Structured Data**: Use consistent data structures in responses
4. **HTTP Status Codes**: Use appropriate HTTP status codes for different scenarios
5. **Localization**: Use Laravel's localization features for messages
6. **Documentation**: Document your API responses clearly
7. **Testing**: Write tests for all response scenarios

## Next Steps

- Review the [API Reference](api-reference.md) for complete method documentation
- Learn about [Configuration](configuration.md) options
- Check the [Testing](testing.md) guide for comprehensive testing information