# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]
- Refactor: Replace all usage of 'title' with 'message' in Responses class and documentation
- Feature: Use default_messages from config/laravel-responses.php for HTTP codes when no message is provided
- Docs: Update README.md to explain default message usage and correct examples
- Tests: Add tests to verify default and custom message behavior in Responses

## [1.0.1] - 2025-08-25
- Refactor: getFriendlyName now generates labels automatically from enum case names, removing dependency on translation helpers
- Docs: Update documentation to reflect new getFriendlyName logic and usage
- Config: Use getFriendlyName in config for default_messages
- Tests: All tests pass with new logic

## [1.0.0] - 2025-08-24
- Standardize JSON payload format: status, code, message, data
- Add response helpers and response factory macros
- Add configuration file `config/laravel-responses.php`
- Add PHPUnit tests and basic test coverage
- Improve PHPDocBlocks and enum documentation
- Ensure package is usable without full Laravel container during tests
