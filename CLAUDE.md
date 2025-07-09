# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress plugin called "FloydFest 2025 Countdown" that displays a countdown timer for FloydFest 2025 (July 23-27, 2025). The plugin is currently at version 0.2.0 with core functionality implemented but missing admin interface and advanced features.

## Key Event Information

- **Event**: FloydFest 2025 (FloydFest 25~Aurora)
- **Start Date**: July 23, 2025, 10:00 AM EST
- **Location**: Floyd, VA

## Development Status

Current implementation (Phases 1-2 complete):
- ✅ Core plugin structure
- ✅ JavaScript countdown timer with multiple display formats
- ✅ CSS styling with responsive design
- ✅ WordPress integration (hooks, asset loading)

Pending features (see planning.md for details):
- ❌ Admin settings interface (Phase 4)
- ❌ Shortcode support (Phase 5)
- ❌ Widget functionality (Phase 5)
- ❌ Theme compatibility testing (Phase 3/6)

## Architecture

### Plugin Structure
The plugin follows WordPress plugin conventions with a singleton pattern for the main class:

```
floydfest-countdown/
├── floydfest-countdown.php    # Main plugin file with FloydFest_Countdown class
├── admin/class-admin.php      # Admin functionality (placeholder)
├── assets/
│   ├── css/countdown.css      # Frontend styles
│   └── js/countdown.js        # Countdown timer logic
└── uninstall.php             # Cleanup on uninstall
```

### Key Technical Details

1. **No Build Process**: This is a vanilla PHP/JavaScript plugin without npm/composer dependencies
2. **Options Storage**: Uses WordPress Options API with 'floydfest_countdown_options' key
3. **Display Formats**: 'full' (default), 'days', 'compact'
4. **Position Options**: 'top' (fixed bar), 'floating' (corner)
5. **Version Constant**: FLOYDFEST_COUNTDOWN_VERSION (update in main plugin file)

### JavaScript Architecture
- Self-contained IIFE in countdown.js
- Reads configuration from `window.floydFestCountdown` object
- Updates DOM every second with setInterval
- Handles timezone conversion to EST

### CSS Architecture
- Fixed positioning with z-index: 999999
- Body padding adjustments to prevent content overlap
- WordPress admin bar compatibility (32px/46px offsets)
- Mobile breakpoints at 768px and 480px

## Common Development Tasks

### Testing the Plugin
1. Copy `floydfest-countdown/` folder to WordPress `/wp-content/plugins/`
2. Activate via WordPress admin
3. Countdown should appear automatically at top of site

### Updating Version
When releasing, update version in:
1. `floydfest-countdown.php` header comment (Version: X.X.X)
2. `FLOYDFEST_COUNTDOWN_VERSION` constant
3. `CHANGELOG.md`

### Adding New Features
- Admin features go in `/admin/` directory
- Frontend features update `assets/js/countdown.js` and `assets/css/countdown.css`
- New classes should follow pattern: `class-{feature}.php` in `/includes/`

## Important Constants

```php
FLOYDFEST_COUNTDOWN_VERSION       # Plugin version
FLOYDFEST_COUNTDOWN_PLUGIN_DIR    # Plugin directory path
FLOYDFEST_COUNTDOWN_PLUGIN_URL    # Plugin URL
FLOYDFEST_START_DATE             # '2025-07-23 10:00:00'
FLOYDFEST_TIMEZONE               # 'America/New_York'
```

## WordPress Hooks Used

- `init` - Include required files
- `wp_enqueue_scripts` - Load CSS/JS
- `wp_head` - Output countdown HTML
- `plugins_loaded` - Load text domain
- `admin_menu` - Add settings page (Phase 4)

## Pending Implementation Notes

When implementing Phase 4 (Admin Interface), the options structure is:
```php
[
    'enabled' => true,
    'background_color' => '#FF6B6B',
    'text_color' => '#FFFFFF',
    'position' => 'top',
    'display_format' => 'full'
]
```

The JavaScript already supports these options via `window.floydFestCountdown.options`.