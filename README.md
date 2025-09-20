# Laravel Responses Documentation

This is the official documentation for the Laravel Responses package, a unified JSON response helper for Laravel projects.

## Table of Contents

- [Installation](docs/installation.md) - How to install and set up the package
- [Quick Start](docs/quick-start.md) - Basic usage examples
- [Usage Guide](docs/usage.md) - Detailed usage patterns and examples
- [Configuration](docs/configuration.md) - Configuration options and customization
- [API Reference](docs/api-reference.md) - Complete API documentation
- [Testing](docs/testing.md) - Testing guide and coverage information
- [Contributing](docs/contributing.md) - How to contribute to the project

## Overview

Laravel Responses provides a standardized way to create consistent JSON API responses in Laravel applications. The package offers multiple interfaces:

- **Global helper functions** for quick response creation
- **ResponseFactory macros** for fluent response building
- **Static factory methods** on the Responses class for programmatic use

All response methods follow the same JSON structure:
```json
{
  "status": "OK|ERROR|FAILED",
  "code": 200,
  "message": "Success message",
  "data": {}
}
```

## Quick Example

```php
use Eborio\LaravelResponses\Responses;

// Using static methods
return Responses::ok(['user' => $user]);

// Using helpers
return laravel_responses_ok(['user' => $user]);

// Using response macros
return response()->ok(['user' => $user]);
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
