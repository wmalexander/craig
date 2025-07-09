<?php
/**
 * Admin functionality for FloydFest Countdown
 *
 * @package FloydFest_Countdown
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin class
 */
class FloydFest_Countdown_Admin {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('FloydFest Countdown Settings', 'floydfest-countdown'),
            __('FloydFest Countdown', 'floydfest-countdown'),
            'manage_options',
            'floydfest-countdown',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('floydfest_countdown_settings', 'floydfest_countdown_options');
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p><?php _e('Settings page will be implemented in Phase 4.', 'floydfest-countdown'); ?></p>
        </div>
        <?php
    }
}

// Initialize admin
new FloydFest_Countdown_Admin();