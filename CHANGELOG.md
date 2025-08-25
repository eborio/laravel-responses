# Changelog

All notable changes to this project will be documented in this file.

## Release v1.0.1
Release date: 2025-08-25

### Added
- Documentation updated to explain automatic friendly name generation for HTTP codes
- Tests to verify the new getFriendlyName logic

### Changed
- Refactor: getFriendlyName now generates labels automatically from enum case names, removing dependency on translation helpers and manual arrays
- Configuration uses getFriendlyName for default_messages
- README.md updated to reflect new logic and usage

### Removed
- All manual arrays and translation helpers for default messages

### Integrity
Tag: `v1.0.1`

## Release v1.0.0
Release date: 2025-08-24

### Added
- Standardize JSON payload format: status, code, message, data
- Response helpers and response factory macros
- Configuration file `config/laravel-responses.php`
- PHPUnit tests and basic test coverage
- PHPDocBlocks and enum documentation

### Changed
- Ensure package is usable without full Laravel container during tests

### Removed
- Deprecated code and unused helpers

### Integrity
Tag: `v1.0.0`
