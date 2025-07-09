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
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
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
        register_setting(
            'floydfest_countdown_settings',
            'floydfest_countdown_options',
            array($this, 'sanitize_options')
        );
        
        // Add settings sections
        add_settings_section(
            'floydfest_countdown_general',
            __('General Settings', 'floydfest-countdown'),
            array($this, 'general_section_callback'),
            'floydfest-countdown'
        );
        
        add_settings_section(
            'floydfest_countdown_appearance',
            __('Appearance Settings', 'floydfest-countdown'),
            array($this, 'appearance_section_callback'),
            'floydfest-countdown'
        );
        
        // Add settings fields
        add_settings_field(
            'enabled',
            __('Enable Countdown', 'floydfest-countdown'),
            array($this, 'enabled_field_callback'),
            'floydfest-countdown',
            'floydfest_countdown_general'
        );
        
        add_settings_field(
            'position',
            __('Position', 'floydfest-countdown'),
            array($this, 'position_field_callback'),
            'floydfest-countdown',
            'floydfest_countdown_general'
        );
        
        add_settings_field(
            'display_format',
            __('Display Format', 'floydfest-countdown'),
            array($this, 'display_format_field_callback'),
            'floydfest-countdown',
            'floydfest_countdown_general'
        );
        
        add_settings_field(
            'background_color',
            __('Background Color', 'floydfest-countdown'),
            array($this, 'background_color_field_callback'),
            'floydfest-countdown',
            'floydfest_countdown_appearance'
        );
        
        add_settings_field(
            'text_color',
            __('Text Color', 'floydfest-countdown'),
            array($this, 'text_color_field_callback'),
            'floydfest-countdown',
            'floydfest_countdown_appearance'
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if ('settings_page_floydfest-countdown' !== $hook) {
            return;
        }
        
        // Enqueue WordPress color picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // Enqueue admin CSS
        wp_enqueue_style(
            'floydfest-countdown-admin',
            FLOYDFEST_COUNTDOWN_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            FLOYDFEST_COUNTDOWN_VERSION
        );
        
        // Enqueue admin JavaScript
        wp_enqueue_script(
            'floydfest-countdown-admin',
            FLOYDFEST_COUNTDOWN_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'wp-color-picker'),
            FLOYDFEST_COUNTDOWN_VERSION,
            true
        );
    }
    
    /**
     * General section callback
     */
    public function general_section_callback() {
        echo '<p>' . __('Configure the basic settings for your FloydFest countdown.', 'floydfest-countdown') . '</p>';
    }
    
    /**
     * Appearance section callback
     */
    public function appearance_section_callback() {
        echo '<p>' . __('Customize the appearance of your countdown timer.', 'floydfest-countdown') . '</p>';
    }
    
    /**
     * Enabled field callback
     */
    public function enabled_field_callback() {
        $options = get_option('floydfest_countdown_options');
        $enabled = isset($options['enabled']) ? $options['enabled'] : true;
        ?>
        <input type="checkbox" id="enabled" name="floydfest_countdown_options[enabled]" value="1" <?php checked($enabled, true); ?> />
        <label for="enabled"><?php _e('Show countdown on your website', 'floydfest-countdown'); ?></label>
        <?php
    }
    
    /**
     * Position field callback
     */
    public function position_field_callback() {
        $options = get_option('floydfest_countdown_options');
        $position = isset($options['position']) ? $options['position'] : 'top';
        ?>
        <select id="position" name="floydfest_countdown_options[position]">
            <option value="top" <?php selected($position, 'top'); ?>><?php _e('Top of page (fixed bar)', 'floydfest-countdown'); ?></option>
            <option value="floating" <?php selected($position, 'floating'); ?>><?php _e('Floating corner', 'floydfest-countdown'); ?></option>
        </select>
        <p class="description"><?php _e('Choose where to display the countdown timer.', 'floydfest-countdown'); ?></p>
        <?php
    }
    
    /**
     * Display format field callback
     */
    public function display_format_field_callback() {
        $options = get_option('floydfest_countdown_options');
        $display_format = isset($options['display_format']) ? $options['display_format'] : 'full';
        ?>
        <select id="display_format" name="floydfest_countdown_options[display_format]">
            <option value="full" <?php selected($display_format, 'full'); ?>><?php _e('Full format (Days, Hours, Minutes, Seconds)', 'floydfest-countdown'); ?></option>
            <option value="days" <?php selected($display_format, 'days'); ?>><?php _e('Days only', 'floydfest-countdown'); ?></option>
            <option value="compact" <?php selected($display_format, 'compact'); ?>><?php _e('Compact format (1d 2h 3m 4s)', 'floydfest-countdown'); ?></option>
        </select>
        <p class="description"><?php _e('Choose how to display the countdown timer.', 'floydfest-countdown'); ?></p>
        <?php
    }
    
    /**
     * Background color field callback
     */
    public function background_color_field_callback() {
        $options = get_option('floydfest_countdown_options');
        $background_color = isset($options['background_color']) ? $options['background_color'] : '#FF6B6B';
        ?>
        <input type="text" id="background_color" name="floydfest_countdown_options[background_color]" value="<?php echo esc_attr($background_color); ?>" class="color-picker" />
        <p class="description"><?php _e('Choose the background color for the countdown timer.', 'floydfest-countdown'); ?></p>
        <?php
    }
    
    /**
     * Text color field callback
     */
    public function text_color_field_callback() {
        $options = get_option('floydfest_countdown_options');
        $text_color = isset($options['text_color']) ? $options['text_color'] : '#FFFFFF';
        ?>
        <input type="text" id="text_color" name="floydfest_countdown_options[text_color]" value="<?php echo esc_attr($text_color); ?>" class="color-picker" />
        <p class="description"><?php _e('Choose the text color for the countdown timer.', 'floydfest-countdown'); ?></p>
        <?php
    }
    
    /**
     * Sanitize options
     */
    public function sanitize_options($input) {
        $sanitized = array();
        
        // Sanitize enabled
        $sanitized['enabled'] = isset($input['enabled']) ? true : false;
        
        // Sanitize position
        $sanitized['position'] = isset($input['position']) && in_array($input['position'], array('top', 'floating')) ? $input['position'] : 'top';
        
        // Sanitize display format
        $sanitized['display_format'] = isset($input['display_format']) && in_array($input['display_format'], array('full', 'days', 'compact')) ? $input['display_format'] : 'full';
        
        // Sanitize colors
        $sanitized['background_color'] = isset($input['background_color']) ? sanitize_hex_color($input['background_color']) : '#FF6B6B';
        $sanitized['text_color'] = isset($input['text_color']) ? sanitize_hex_color($input['text_color']) : '#FFFFFF';
        
        return $sanitized;
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Show success message
        if (isset($_GET['settings-updated'])) {
            add_settings_error(
                'floydfest_countdown_messages',
                'floydfest_countdown_message',
                __('Settings saved successfully!', 'floydfest-countdown'),
                'updated'
            );
        }
        
        settings_errors('floydfest_countdown_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="floydfest-countdown-admin-header">
                <h2><?php _e('FloydFest 2025 Countdown Settings', 'floydfest-countdown'); ?></h2>
                <p><?php _e('Configure your countdown timer for FloydFest 2025 (July 23-27, 2025)', 'floydfest-countdown'); ?></p>
            </div>
            
            <div class="floydfest-countdown-admin-content">
                <div class="floydfest-countdown-settings-form">
                    <form action="options.php" method="post">
                        <?php
                        settings_fields('floydfest_countdown_settings');
                        do_settings_sections('floydfest-countdown');
                        submit_button(__('Save Settings', 'floydfest-countdown'));
                        ?>
                    </form>
                </div>
                
                <div class="floydfest-countdown-preview">
                    <h3><?php _e('Preview', 'floydfest-countdown'); ?></h3>
                    <div id="countdown-preview">
                        <div id="preview-container">
                            <div class="preview-inner">
                                <div class="preview-content">
                                    <span class="preview-label"><?php _e('FloydFest 2025 starts in:', 'floydfest-countdown'); ?></span>
                                    <div id="preview-timer" class="preview-timer">
                                        <span class="preview-loading"><?php _e('Loading preview...', 'floydfest-countdown'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="floydfest-countdown-admin-info">
                <h3><?php _e('Event Information', 'floydfest-countdown'); ?></h3>
                <ul>
                    <li><strong><?php _e('Event:', 'floydfest-countdown'); ?></strong> <?php _e('FloydFest 2025 (FloydFest 25~Aurora)', 'floydfest-countdown'); ?></li>
                    <li><strong><?php _e('Start Date:', 'floydfest-countdown'); ?></strong> <?php _e('July 23, 2025 at 10:00 AM EST', 'floydfest-countdown'); ?></li>
                    <li><strong><?php _e('Location:', 'floydfest-countdown'); ?></strong> <?php _e('Floyd, VA', 'floydfest-countdown'); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }
}

// Initialize admin
new FloydFest_Countdown_Admin();