# Testing

This guide covers testing strategies and examples for applications using the Laravel Responses package.

## Test Coverage

The package includes comprehensive test coverage (100%) with 40 tests covering:

- All public methods and constructors
- Edge cases and error conditions
- Configuration handling
- Enum functionality
- Response structure validation

## Running Tests

Run the package tests:

```bash
vendor/bin/phpunit
```

Run tests with coverage report:

```bash
vendor/bin/phpunit --coverage-html=reports/coverage
```

## Testing Response Structure

### Testing Successful Responses

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Eborio\LaravelResponses\Responses;

class UserApiTest extends TestCase
{
    public function test_user_creation_returns_correct_structure()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'created_at'
                     ]
                 ])
                 ->assertJson([
                     'status' => 'OK',
                     'code' => 200
                 ]);
    }
}
```

### Testing Error Responses

```php
public function test_invalid_data_returns_validation_error_structure()
{
    $response = $this->postJson('/api/users', []);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'status',
                 'code',
                 'message',
                 'data' => [
                     'name',
                     'email'
                 ]
             ])
             ->assertJson([
                 'status' => 'ERROR',
                 'code' => 422,
                 'message' => 'Validation Errors'
             ]);
}
```

### Testing Specific Response Types

```php
public function test_not_found_returns_correct_response()
{
    $response = $this->getJson('/api/users/999');

    $response->assertStatus(404)
             ->assertJson([
                 'status' => 'ERROR',
                 'code' => 404,
                 'message' => 'Resource Not Found',
                 'data' => []
             ]);
}
```

## Testing with Response Helpers

### Testing Helper Functions

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Eborio\LaravelResponses\Responses;

class ResponseHelperTest extends TestCase
{
    public function test_helper_functions_return_correct_responses()
    {
        // Test helper function
        $response = laravel_responses_ok(['test' => 'data']);
        $jsonResponse = $response->toResponse(request());

        $this->assertEquals(200, $jsonResponse->getStatusCode());
        $this->assertEquals([
            'status' => 'OK',
            'code' => 200,
            'message' => 'Ok',
            'data' => ['test' => 'data']
        ], $jsonResponse->getData(true));
    }
}
```

### Testing Response Macros

```php
public function test_response_macros_work_correctly()
{
    // Test response macro
    $response = response()->ok(['user' => ['id' => 1, 'name' => 'John']]);
    $jsonResponse = $response->toResponse(request());

    $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $jsonResponse);
    $this->assertEquals(200, $jsonResponse->getStatusCode());

    $data = $jsonResponse->getData(true);
    $this->assertEquals('OK', $data['status']);
    $this->assertEquals(['user' => ['id' => 1, 'name' => 'John']], $data['data']);
}
```

## Testing Custom Messages

```php
public function test_custom_messages_override_defaults()
{
    $response = Responses::ok(['data' => 'value'], 'Custom success message');
    $jsonResponse = $response->toResponse(request());

    $data = $jsonResponse->getData(true);
    $this->assertEquals('Custom success message', $data['message']);
}
```

## Testing Configuration

### Testing Default Messages

```php
public function test_default_messages_are_used_when_no_custom_message_provided()
{
    $response = Responses::notFound();
    $jsonResponse = $response->toResponse(request());

    $data = $jsonResponse->getData(true);
    $this->assertEquals('Resource Not Found', $data['message']);
}
```

### Testing JSON Options

```php
public function test_json_options_are_applied()
{
    // Test pretty printing in development
    config(['laravel-responses.json_options' => JSON_PRETTY_PRINT]);

    $response = Responses::ok(['test' => 'data']);
    $jsonResponse = $response->toResponse(request());

    $content = $jsonResponse->getContent();
    $this->assertStringContains('    ', $content); // Contains indentation
}
```

## Testing Edge Cases

### Testing Empty Data

```php
public function test_responses_work_with_empty_data()
{
    $response = Responses::ok([]);
    $jsonResponse = $response->toResponse(request());

    $data = $jsonResponse->getData(true);
    $this->assertEquals([], $data['data']);
    $this->assertEquals('OK', $data['status']);
}
```

### Testing Large Data Sets

```php
public function test_large_data_sets_are_handled_correctly()
{
    $largeData = [];
    for ($i = 0; $i < 1000; $i++) {
        $largeData["item_$i"] = "value_$i";
    }

    $response = Responses::ok($largeData);
    $jsonResponse = $response->toResponse(request());

    $data = $jsonResponse->getData(true);
    $this->assertCount(1000, $data['data']);
    $this->assertEquals('OK', $data['status']);
}
```

### Testing Special Characters

```php
public function test_special_characters_are_handled_correctly()
{
    $data = [
        'message' => 'Hello 🌍 with émojis and spëcial chärs',
        'data' => 'Tëst data'
    ];

    $response = Responses::ok($data);
    $jsonResponse = $response->toResponse(request());

    $responseData = $jsonResponse->getData(true);
    $this->assertEquals($data, $responseData['data']);
}
```

## Testing Exception Scenarios

### Testing with Mocked Exceptions

```php
public function test_responses_handle_exceptions_gracefully()
{
    // Test with invalid data that might cause JSON encoding issues
    $invalidData = [
        'invalid' => fopen('php://memory', 'r') // Resource that can't be JSON encoded
    ];

    $this->expectException(\Exception::class);
    Responses::ok($invalidData)->toResponse(request());
}
```

## Integration Testing

### Testing API Endpoints

```php
<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;

class UserApiTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function test_user_api_returns_paginated_results()
    {
        User::factory()->count(25)->create();

        $response = $this->getJson('/api/users?page=2&per_page=10');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message',
                     'data' => [
                         'users' => [
                             '*' => ['id', 'name', 'email']
                         ],
                         'pagination' => [
                             'current_page',
                             'last_page',
                             'per_page',
                             'total'
                         ]
                     ]
                 ]);
    }
}
```

## Performance Testing

### Testing Response Time

```php
public function test_api_response_time_is_acceptable()
{
    $startTime = microtime(true);

    $response = $this->getJson('/api/users');

    $endTime = microtime(true);
    $responseTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

    $this->assertLessThan(500, $responseTime, 'Response time should be less than 500ms');
    $response->assertStatus(200);
}
```

## Testing Best Practices

1. **Test Response Structure**: Always verify the JSON structure matches expectations
2. **Test HTTP Status Codes**: Ensure correct status codes are returned
3. **Test Data Integrity**: Verify that data is returned correctly
4. **Test Error Scenarios**: Cover all error conditions
5. **Test Edge Cases**: Test with empty data, large data, special characters
6. **Test Configuration**: Verify configuration changes work as expected
7. **Use Descriptive Test Names**: Make test intentions clear
8. **Test Performance**: Ensure responses are reasonably fast
9. **Test Localization**: If using i18n, test different locales
10. **Continuous Integration**: Run tests on every commit

## Test Organization

### Directory Structure

```
tests/
├── Feature/
│   ├── Api/
│   │   ├── UserApiTest.php
│   │   └── ProductApiTest.php
│   └── ResponseTest.php
├── Unit/
│   ├── ResponsesTest.php
│   ├── CodesTest.php
│   └── HelpersTest.php
└── TestCase.php
```

### Test Naming Conventions

- `test_user_creation_returns_correct_response()`
- `test_invalid_input_returns_validation_errors()`
- `test_not_found_returns_404_status()`
- `test_response_contains_required_fields()`

## Debugging Failed Tests

### Common Issues

1. **Wrong Status Code**: Check that you're testing the correct endpoint
2. **Missing JSON Structure**: Verify your model/api includes all required fields
3. **Incorrect Data**: Check that your factory or seeder creates correct data
4. **Authentication Issues**: Ensure proper authentication in feature tests

### Debugging Tools

```php
// Dump response for debugging
$response = $this->getJson('/api/users');
dd($response->getContent());

// Pretty print JSON response
$response->dump();

// Get response headers
$headers = $response->headers();
```

## Continuous Integration

### GitHub Actions Example

```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: vendor/bin/phpunit --coverage-text
```

## See Also

- [Installation](installation.md)
- [Usage Guide](usage.md)
- [API Reference](api-reference.md)
- [Configuration](configuration.md)