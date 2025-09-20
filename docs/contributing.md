# Contributing

Thank you for your interest in contributing to the Laravel Responses package! This document provides guidelines and information for contributors.

## Code of Conduct

This project follows Laravel's code of conduct. By participating, you agree to uphold this code.

## How to Contribute

### 1. Reporting Issues

- Use the GitHub issue tracker to report bugs
- Provide detailed steps to reproduce the issue
- Include your PHP version, Laravel version, and package version
- Add code examples and error messages when possible

### 2. Feature Requests

- Open an issue describing the feature you'd like to see
- Explain the use case and why it would be valuable
- Be open to discussion and feedback

### 3. Contributing Code

#### Development Setup

1. Fork the repository
2. Clone your fork: `git clone https://github.com/your-username/laravel-responses.git`
3. Install dependencies: `composer install`
4. Create a feature branch: `git checkout -b feature/your-feature-name`

#### Code Standards

This project follows PSR-12 coding standards and Laravel conventions:

- Use 4 spaces for indentation
- Use camelCase for variables and methods
- Use PascalCase for classes
- Add PHPDocBlocks for all public methods
- Keep lines under 120 characters
- Use meaningful variable and method names

#### Testing

- Write tests for all new features
- Maintain 100% code coverage
- Run tests before submitting: `vendor/bin/phpunit`
- Add tests for edge cases and error conditions

#### Commit Messages

Use clear, descriptive commit messages:

```
feat: add support for custom response headers
fix: correct validation error message formatting
docs: update installation instructions
test: add coverage for error response scenarios
```

### 4. Pull Request Process

1. Ensure your code follows the coding standards
2. Update documentation if needed
3. Add tests for new functionality
4. Update CHANGELOG.md if applicable
5. Ensure all tests pass
6. Submit a pull request with a clear description

## Development Workflow

### Setting Up Development Environment

```bash
# Clone repository
git clone https://github.com/eborio/laravel-responses.git
cd laravel-responses

# Install dependencies
composer install

# Run tests
vendor/bin/phpunit

# Run tests with coverage
vendor/bin/phpunit --coverage-html=reports/coverage
```

### Running Quality Checks

```bash
# Run PHPStan for static analysis
vendor/bin/phpstan analyse

# Run PHP CS Fixer for code style
vendor/bin/php-cs-fixer fix --dry-run

# Fix code style issues
vendor/bin/php-cs-fixer fix
```

## Project Structure

```
src/
├── LaravelResponses/
│   ├── Responses.php          # Main response class
│   ├── ServiceProvider.php    # Laravel service provider
│   └── Enums/
│       ├── Codes.php          # HTTP status codes enum
│       └── Status.php         # Semantic status enum
config/
├── laravel-responses.php     # Configuration file
tests/
├── ResponsesTest.php          # Main test file
├── CodesTest.php             # Enum tests
└── ...
docs/                         # Documentation
├── installation.md
├── usage.md
├── api-reference.md
└── ...
```

## Adding New Features

### 1. Response Types

When adding new response types:

1. Add the HTTP code to the `Codes` enum
2. Add the mapping in `Codes::statusFromHttpCode()`
3. Add the friendly name method if needed
4. Add the static method to `Responses` class
5. Add helper function
6. Add ResponseFactory macro
7. Update configuration
8. Add comprehensive tests
9. Update documentation

### 2. Configuration Options

When adding configuration options:

1. Add to `config/laravel-responses.php`
2. Update the `Responses` class to use the configuration
3. Add validation if needed
4. Update documentation
5. Add tests for the new configuration

### 3. Helper Functions

When adding helper functions:

1. Add to the service provider registration
2. Follow naming convention: `laravel_responses_*`
3. Add PHPDocBlocks
4. Add tests
5. Update documentation

## Testing Guidelines

### Unit Tests

- Test all public methods
- Test edge cases and error conditions
- Use descriptive test names
- Test configuration variations
- Mock external dependencies when needed

### Feature Tests

- Test API endpoints that use the package
- Test response structure and content
- Test different scenarios (success, error, edge cases)
- Use Laravel's testing helpers

### Test Coverage

- Maintain 100% code coverage
- Cover all branches and edge cases
- Test configuration variations
- Test error conditions

## Documentation

### Updating Documentation

1. Update relevant `.md` files in `docs/`
2. Update README.md if needed
3. Ensure examples are correct and complete
4. Test documentation examples
5. Keep API reference up to date

### Documentation Standards

- Use Markdown format
- Include code examples
- Provide clear explanations
- Keep examples runnable
- Update table of contents

## Release Process

### Version Numbering

This project follows [Semantic Versioning](https://semver.org/):

- **MAJOR**: Breaking changes
- **MINOR**: New features (backward compatible)
- **PATCH**: Bug fixes (backward compatible)

### Creating Releases

1. Update CHANGELOG.md with new version
2. Update version numbers if applicable
3. Run full test suite
4. Create annotated git tag
5. Push tag to GitHub
6. Create GitHub release

## Getting Help

- **Issues**: Use GitHub issues for bugs and feature requests
- **Discussions**: Use GitHub discussions for questions
- **Documentation**: Check the docs first
- **Community**: Join Laravel communities for general questions

## Recognition

Contributors will be recognized in CHANGELOG.md and potentially in future release notes. Significant contributions may be acknowledged in the main README.

Thank you for contributing to Laravel Responses! 🎉