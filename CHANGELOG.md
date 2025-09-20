# Changelog

All notable changes to this project will be documented in this file.

## Release v1.2.1

Release date: 2025-09-19

### Fixed
- Corrected enum case names in configuration file (UNAUTHENTICATED_USER, FORBIDDEN_RESOURCE, RESOURCE_NOT_FOUND, SERVER_ERROR)

### Added
- Comprehensive documentation suite in `docs/` directory
- Installation guide, usage examples, API reference, testing guide, and contribution guidelines
- Updated README.md as documentation index

### Changed
- Improved documentation structure and organization
- Enhanced developer experience with detailed guides and examples

### Integrity
Tag: `v1.2.1`

## Release v1.2.0

Release date: 2025-09-19

### Added
- Comprehensive test suite achieving 100% code coverage (40 tests, 58 assertions)
- Tests for all public methods, constructor variations, and edge cases in Responses class
- Tests for all enum methods and HTTP code mappings in Codes class

### Changed
- Updated PHPDocBlocks in Codes.php and Responses.php for improved documentation and type safety
- Enhanced test coverage to include reflection-based testing for protected methods

### Integrity
Tag: `v1.2.0`

## Release v1.1.0

Release date: 2025-08-25

### Added
- Implemented getFriendlyName in codes enumerator for default message generation and fallback usage in controller.
- Improved documentation and PHPDocBlocks for new and updated methods.
- Added new tests to cover getFriendlyName logic and fallback scenarios.

### Changed
- Refactored logic to avoid duplication between default_messages and controller, now using getFriendlyName for message generation.
- Updated configuration to use $messages instead of $titles.
- Removed _i helper usage from getFriendlyName as requested.
- Updated CHANGELOG and documentation to reflect new features and changes.

### Removed
- Deprecated variable $title and related logic.
- Eliminated duplicated message logic from controller and config.

### Integrity
Tag: `v1.1.0`

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
