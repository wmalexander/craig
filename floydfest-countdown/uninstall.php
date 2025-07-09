<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package FloydFest_Countdown
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('floydfest_countdown_options');

// Delete any transients we might have set
delete_transient('floydfest_countdown_cache');

// Clear any cached data
wp_cache_flush();