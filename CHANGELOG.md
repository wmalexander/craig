# Changelog

All notable changes to the FloydFest 2025 Countdown WordPress Plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.0] - 2025-01-09

### Added
- Improved WordPress integration with `wp_body_open` hook
- Better theme compatibility with body classes and fallback positioning
- Enhanced JavaScript with DOM state checks and cleanup
- Theme override protection with z-index enforcement
- Automatic countdown visibility checks
- Proper cleanup of intervals and observers

### Changed
- Moved countdown HTML output from `wp_head` to `wp_body_open` for better positioning
- Split style and HTML output into separate methods for better organization
- Enhanced CSS with theme-specific body classes for better compatibility
- Improved JavaScript initialization with ready state checks
- Better timezone handling in JavaScript

### Fixed
- Theme compatibility issues with CSS overrides
- Proper body padding only when countdown is in top position
- JavaScript cleanup to prevent memory leaks
- Better handling of themes without `wp_body_open` support

## [0.2.0] - 2025-01-09

### Added
- Complete JavaScript countdown timer functionality
  - Real-time countdown to July 23, 2025 10:00 AM EST
  - Multiple display formats (full, days only, compact)
  - Proper timezone handling
  - Shows "FloydFest 2025 has begun!" when event starts
- Full CSS styling for countdown display
  - Fixed top bar positioning with sticky behavior
  - Floating corner option
  - Responsive design for mobile devices
  - WordPress admin bar compatibility
  - Smooth animations and transitions
  - Color customization support
- Dynamic body class for floating mode
- Loading state while JavaScript initializes

## [0.1.0] - 2025-01-09

### Added
- Core plugin structure with main plugin file
- Basic activation/deactivation hooks
- Plugin directory structure (assets, admin, includes, languages)
- Placeholder files for CSS and JavaScript
- Basic admin class structure
- Plugin constants and configuration

## [0.0.0] - 2025-01-09

### Added
- Initial project setup
- Development planning documentation
- Project structure and roadmap
- Git repository initialization

### Notes
- This is the initial commit establishing the project foundation
- No functional code yet, only planning documentation

[0.3.0]: https://github.com/wmalexander/craig/releases/tag/v0.3.0
[0.2.0]: https://github.com/wmalexander/craig/releases/tag/v0.2.0
[0.1.0]: https://github.com/wmalexander/craig/releases/tag/v0.1.0
[0.0.0]: https://github.com/wmalexander/craig/releases/tag/v0.0.0