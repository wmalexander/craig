# FloydFest 2025 Countdown WordPress Plugin - Development Plan

## Project Overview
Create a WordPress plugin that displays a countdown timer for FloydFest 2025, which runs from July 23-27, 2025 in Floyd, VA.

## Key Information
- **Event**: FloydFest 2025 (FloydFest 25~Aurora)
- **Start Date**: July 23, 2025 (Wednesday, 10:00 AM for VIP)
- **End Date**: July 27, 2025 (Sunday)
- **Location**: Blue Ridge Mountains, Floyd, VA

## Development Tasks

### Phase 1: Core Plugin Structure ✅
- [x] Research WordPress plugin development structure
- [x] Create plugin folder: `floydfest-countdown`
- [x] Create main plugin file: `floydfest-countdown.php`
- [x] Set up basic plugin headers and activation hooks

### Phase 2: Frontend Countdown Implementation
- [ ] Create JavaScript countdown timer functionality
  - [ ] Calculate time until July 23, 2025
  - [ ] Update display every second
  - [ ] Handle timezone considerations
- [ ] Design CSS for countdown display
  - [ ] Sticky top bar positioning
  - [ ] Responsive design for mobile
  - [ ] Default styling (can be customized later)

### Phase 3: WordPress Integration
- [ ] Hook into WordPress to display countdown
  - [ ] Use `wp_head` for CSS
  - [ ] Use `wp_footer` for JavaScript
  - [ ] Add countdown HTML to site header
- [ ] Ensure compatibility with common themes

### Phase 4: Admin Interface
- [ ] Create settings page in WordPress admin
- [ ] Add options:
  - [ ] Enable/disable countdown
  - [ ] Background color picker
  - [ ] Text color picker
  - [ ] Font size adjustment
  - [ ] Position options (top, floating)
- [ ] Save settings using WordPress Options API

### Phase 5: Extended Features
- [ ] Implement shortcode `[floydfest_countdown]`
- [ ] Create WordPress widget for sidebar placement
- [ ] Add display format options:
  - [ ] Full format: "X days, Y hours, Z minutes"
  - [ ] Days only: "X days until FloydFest!"
  - [ ] Compact format for mobile
- [ ] Custom message when countdown reaches zero

### Phase 6: Polish & Testing
- [ ] Test on different WordPress versions (5.0+)
- [ ] Test with popular themes (Twenty Twenty-One, etc.)
- [ ] Mobile responsiveness testing
- [ ] Cross-browser compatibility
- [ ] Performance optimization

### Phase 7: Documentation
- [ ] Create readme.txt for WordPress.org
- [ ] Write installation instructions
- [ ] Document shortcode usage
- [ ] Add FAQ section

## Technical Specifications

### File Structure
```
floydfest-countdown/
├── floydfest-countdown.php      # Main plugin file
├── assets/
│   ├── css/
│   │   ├── countdown.css        # Frontend styles
│   │   └── admin.css           # Admin styles
│   └── js/
│       ├── countdown.js         # Countdown logic
│       └── admin.js            # Admin panel JS
├── includes/
│   ├── class-countdown.php      # Main countdown class
│   ├── class-admin.php         # Admin functionality
│   ├── class-shortcode.php     # Shortcode handler
│   └── class-widget.php        # Widget class
├── languages/                   # Translation files
├── readme.txt                   # WordPress.org readme
└── uninstall.php               # Cleanup on uninstall
```

### Key Features
1. **Automatic Display**: Countdown appears at top of every page
2. **Customizable**: Colors, fonts, and position can be adjusted
3. **Responsive**: Works on all device sizes
4. **Performance**: Lightweight, no external dependencies
5. **Flexible**: Can be placed via shortcode or widget

### Development Notes
- Use WordPress coding standards
- Implement proper sanitization and escaping
- Add nonce verification for admin forms
- Use WordPress translation functions for text
- Minimize JavaScript and CSS for production

## Timeline Estimate
- Phase 1-2: 2 hours
- Phase 3-4: 3 hours
- Phase 5: 2 hours
- Phase 6-7: 2 hours
- **Total**: ~9 hours

## Next Steps
1. Create the plugin folder structure
2. Start with the main plugin file and basic countdown functionality
3. Build incrementally, testing each phase