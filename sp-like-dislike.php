<?php

/**
 * Plugin Name:       SP Like Dislike
 * Description:       WordPress Like & Dislike Post
 * Version:           1.0.0
 * Author:            Salman Patnee
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       spld
 */

if (!defined('WPINC')) {
    die;
}

if (!defined('SPLD_PLUGIN_VERSION')) {
    define('SPLD_PLUGIN_VERSION', '1.0.0');
}

if (!defined('SPLD_PLUGIN_DIR_URL')) {
    define('SPLD_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
}

if (!defined('SPLD_PLUGIN_DIR')) {
    define('SPLD_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

if (!defined('SPLD_TABLE_NAME')) {
    global $wpdb;
    define('SPLD_TABLE_NAME', sprintf("%sspld_post_like_dislike", $wpdb->prefix));
}

// Includes
require SPLD_PLUGIN_DIR . '/inc/activation.php';
require SPLD_PLUGIN_DIR . '/inc/enqueue.php';
require SPLD_PLUGIN_DIR . '/inc/admin/menu.php';
require SPLD_PLUGIN_DIR . '/inc/admin/settings.php';
require SPLD_PLUGIN_DIR . '/inc/content.php';
require SPLD_PLUGIN_DIR . '/inc/process/like_dislike.php';

// Hooks
register_activation_hook(__FILE__, 'spld_activation');
add_action('wp_enqueue_scripts', 'spld_enqueue_scripts');
add_action('admin_menu', 'spld_register_menu_page');
add_action('admin_init', 'spld_register_settings');
add_filter('the_content', 'spld_add_like_dislike_btns');
add_action('wp_ajax_spld_handle_like_dislike', 'spld_handle_like_dislike');
add_action('wp_ajax_nopriv_spld_handle_like_dislike', 'spld_handle_like_dislike');




