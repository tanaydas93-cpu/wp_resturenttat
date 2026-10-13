<?php
/**
 * Plugin Name: Restaurant Info
 * Plugin URI:  https://yourwebsite.com
 * Description: Manage restaurant information dynamically on the website.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL-2.0+
 * Text Domain: restaurant-info
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// CONSTANTS
// ─────────────────────────────────────────
define( 'RI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// ─────────────────────────────────────────
// ADMIN MENU REGISTRATION
// ─────────────────────────────────────────
add_action( 'admin_menu', 'ri_register_admin_menu' );

function ri_register_admin_menu() {

    add_menu_page(
        'Restaurant Info',          // Page title
        'Restaurant Info',          // Menu title
        'manage_options',           // Capability
        'restaurant-info',          // Menu slug
        'ri_form_page',             // Callback function
        'dashicons-store',          // Icon
        31                          // Position
    );
}


// ─────────────────────────────────────────
// PAGE CALLBACK
// ─────────────────────────────────────────
function ri_form_page() {
    require_once RI_PLUGIN_DIR . 'admin/restaurant-form.php';
}


// ─────────────────────────────────────────
// ENQUEUE ADMIN SCRIPTS
// ─────────────────────────────────────────
add_action( 'admin_enqueue_scripts', 'ri_enqueue_admin_scripts' );


function ri_enqueue_admin_scripts( $hook ) {

    // Load only on our plugin page
    if ( $hook !== 'toplevel_page_restaurant-info' ) {
        return;
    }

    // Enqueue WP Media Uploader
    wp_enqueue_media();

    wp_enqueue_script(
        'ri-form-js',
        RI_PLUGIN_URL . 'admin/js/restaurant-form.js',
        [ 'jquery', 'media-upload', 'media-views' ],   // ← Added media deps
        '1.0.0',
        true
    );
}