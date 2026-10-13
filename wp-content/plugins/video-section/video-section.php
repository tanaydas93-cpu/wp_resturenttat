<?php
/**
 * Plugin Name: Video Section
 * Plugin URI:  https://yourwebsite.com
 * Description: Manage the video section URL dynamically on the website.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL-2.0+
 * Text Domain: video-section
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// CONSTANTS
// ─────────────────────────────────────────
define( 'VS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// ─────────────────────────────────────────
// ENQUEUE ADMIN SCRIPTS
// ─────────────────────────────────────────
add_action( 'admin_enqueue_scripts', 'vs_enqueue_admin_scripts' );

function vs_enqueue_admin_scripts( $hook ) {

    // Load only on our plugin page
    if ( $hook !== 'toplevel_page_video-section' ) {
        return;
    }

    // Enqueue WP Media Uploader
    wp_enqueue_media();

    wp_enqueue_script(
        'vs-form-js',                                        // Handle
        VS_PLUGIN_URL . 'admin/js/video-form.js',           // Path
        [ 'jquery', 'media-upload', 'media-views' ],        // Dependencies
        '1.0.0',                                             // Version
        true                                                 // Load in footer
    );
}
// ─────────────────────────────────────────
// ADMIN MENU REGISTRATION
// ─────────────────────────────────────────
add_action( 'admin_menu', 'vs_register_admin_menu' );

function vs_register_admin_menu() {

    add_menu_page(
        'Video Section',            // Page title
        'Video Section',            // Menu title
        'manage_options',           // Capability
        'video-section',            // Menu slug
        'vs_form_page',             // Callback function
        'dashicons-video-alt3',     // Icon
        33                          // Position
    );
}


// ─────────────────────────────────────────
// PAGE CALLBACK
// ─────────────────────────────────────────
function vs_form_page() {
    require_once VS_PLUGIN_DIR . 'admin/video-form.php';
}