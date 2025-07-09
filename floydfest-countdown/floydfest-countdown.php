<?php
/**
 * Plugin Name: FloydFest 2025 Countdown
 * Plugin URI: https://github.com/wmalexander/craig
 * Description: Displays a countdown timer for FloydFest 2025 (July 23-27, 2025) at the top of your website
 * Version: 0.3.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: floydfest-countdown
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FLOYDFEST_COUNTDOWN_VERSION', '0.3.0');
define('FLOYDFEST_COUNTDOWN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FLOYDFEST_COUNTDOWN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FLOYDFEST_COUNTDOWN_PLUGIN_BASENAME', plugin_basename(__FILE__));

// FloydFest 2025 start date (July 23, 2025 10:00 AM EST)
define('FLOYDFEST_START_DATE', '2025-07-23 10:00:00');
define('FLOYDFEST_TIMEZONE', 'America/New_York');

/**
 * Main plugin class
 */
class FloydFest_Countdown {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Get instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Activation/Deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Action hooks
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('wp_body_open', array($this, 'add_countdown_html'), 1);
        add_action('wp_head', array($this, 'add_custom_styles'));
        add_filter('body_class', array($this, 'add_body_classes'));
        
        // Load text domain
        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $default_options = array(
            'enabled' => true,
            'background_color' => '#FF6B6B',
            'text_color' => '#FFFFFF',
            'position' => 'top',
            'display_format' => 'full'
        );
        
        if (!get_option('floydfest_countdown_options')) {
            add_option('floydfest_countdown_options', $default_options);
        }
        
        // Clear any cached data
        wp_cache_flush();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up any temporary data
        wp_cache_flush();
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Include required files
        $this->includes();
    }
    
    /**
     * Include required files
     */
    private function includes() {
        // Include admin functionality if in admin
        if (is_admin()) {
            require_once FLOYDFEST_COUNTDOWN_PLUGIN_DIR . 'admin/class-admin.php';
        }
        
        // Include other classes as they're created
        // require_once FLOYDFEST_COUNTDOWN_PLUGIN_DIR . 'includes/class-shortcode.php';
        // require_once FLOYDFEST_COUNTDOWN_PLUGIN_DIR . 'includes/class-widget.php';
    }
    
    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'floydfest-countdown',
            false,
            dirname(FLOYDFEST_COUNTDOWN_PLUGIN_BASENAME) . '/languages/'
        );
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_frontend_assets() {
        $options = get_option('floydfest_countdown_options');
        
        // Only enqueue if countdown is enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return;
        }
        
        // Enqueue CSS
        wp_enqueue_style(
            'floydfest-countdown',
            FLOYDFEST_COUNTDOWN_PLUGIN_URL . 'assets/css/countdown.css',
            array(),
            FLOYDFEST_COUNTDOWN_VERSION
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'floydfest-countdown',
            FLOYDFEST_COUNTDOWN_PLUGIN_URL . 'assets/js/countdown.js',
            array(),
            FLOYDFEST_COUNTDOWN_VERSION,
            true
        );
        
        // Pass data to JavaScript
        wp_localize_script('floydfest-countdown', 'floydFestCountdown', array(
            'targetDate' => FLOYDFEST_START_DATE,
            'timezone' => FLOYDFEST_TIMEZONE,
            'options' => $options,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('floydfest_countdown_nonce')
        ));
    }
    
    /**
     * Add custom styles to the page head
     */
    public function add_custom_styles() {
        $options = get_option('floydfest_countdown_options');
        
        // Only add styles if enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return;
        }
        
        // Custom CSS based on options
        $custom_css = sprintf(
            '#floydfest-countdown-container { background-color: %s; color: %s; }',
            esc_attr($options['background_color']),
            esc_attr($options['text_color'])
        );
        
        echo '<style type="text/css">' . $custom_css . '</style>';
    }
    
    /**
     * Add body classes for countdown styling
     */
    public function add_body_classes($classes) {
        $options = get_option('floydfest_countdown_options');
        
        // Only add classes if enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return $classes;
        }
        
        // Add base class
        $classes[] = 'has-floydfest-countdown';
        
        // Add position-specific class
        if ($options['position'] === 'top') {
            $classes[] = 'floydfest-countdown-top-active';
        } elseif ($options['position'] === 'floating') {
            $classes[] = 'floydfest-countdown-floating-active';
        }
        
        return $classes;
    }
    
    /**
     * Add countdown HTML to the page
     */
    public function add_countdown_html() {
        $options = get_option('floydfest_countdown_options');
        
        // Only display if enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return;
        }
        
        // Fallback for themes without wp_body_open support
        if (!did_action('wp_body_open')) {
            add_action('wp_footer', array($this, 'add_countdown_html_fallback'), 1);
            return;
        }
        
        $this->output_countdown_html($options);
    }
    
    /**
     * Fallback method for themes without wp_body_open
     */
    public function add_countdown_html_fallback() {
        // Prevent double output
        if (did_action('wp_body_open')) {
            return;
        }
        
        $options = get_option('floydfest_countdown_options');
        $this->output_countdown_html($options);
    }
    
    /**
     * Output the countdown HTML
     */
    private function output_countdown_html($options) {
        // Output countdown container
        echo '<div id="floydfest-countdown-container" class="floydfest-countdown-' . esc_attr($options['position']) . '">';
        echo '<div class="floydfest-countdown-inner">';
        echo '<div class="floydfest-countdown-content">';
        echo '<span class="floydfest-countdown-label">' . esc_html__('FloydFest 2025 starts in:', 'floydfest-countdown') . '</span>';
        echo '<div id="floydfest-countdown-timer" class="floydfest-countdown-timer">';
        echo '<span class="countdown-loading">' . esc_html__('Loading...', 'floydfest-countdown') . '</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Initialize the plugin
FloydFest_Countdown::get_instance();