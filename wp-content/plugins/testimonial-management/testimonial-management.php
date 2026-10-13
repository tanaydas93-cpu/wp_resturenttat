<?php
/**
 * Plugin Name: Testimonial Management
 * Plugin URI:  https://yourwebsite.com
 * Description: Manage customer testimonials dynamically on the website.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL-2.0+
 * Text Domain: testimonial-management
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// CONSTANTS
// ─────────────────────────────────────────
define( 'TM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// ─────────────────────────────────────────
// ADMIN MENU REGISTRATION
// ─────────────────────────────────────────
add_action( 'admin_menu', 'tm_register_admin_menu' );

function tm_register_admin_menu() {

    // Top-level Menu
    add_menu_page(
        'Testimonial Management',   // Page title
        'Testimonials',             // Menu title
        'manage_options',           // Capability
        'testimonial-management',   // Menu slug
        'tm_list_page',             // Callback function
        'dashicons-format-quote',   // Icon
        32                          // Position
    );

    // Submenu → All Testimonials (same as parent)
    add_submenu_page(
        'testimonial-management',   // Parent slug
        'All Testimonials',         // Page title
        'All Testimonials',         // Menu title
        'manage_options',           // Capability
        'testimonial-management',   // Menu slug (same as parent = no duplicate)
        'tm_list_page'              // Callback function
    );

    // Submenu → Add / Edit Testimonial
    add_submenu_page(
        'testimonial-management',   // Parent slug
        'Add / Edit Testimonial',   // Page title
        'Add New Testimonial',      // Menu title
        'manage_options',           // Capability
        'testimonial-form',         // Menu slug
        'tm_form_page'              // Callback function
    );
}


// ─────────────────────────────────────────
// PAGE CALLBACKS
// ─────────────────────────────────────────

// Loads admin/testimonial-list.php
function tm_list_page() {
    require_once TM_PLUGIN_DIR . 'admin/testimonial-list.php';
}

// Loads admin/testimonial-form.php
function tm_form_page() {
    require_once TM_PLUGIN_DIR . 'admin/testimonial-form.php';
}


// ─────────────────────────────────────────
// ENQUEUE ADMIN SCRIPTS
// ─────────────────────────────────────────
add_action( 'admin_enqueue_scripts', 'tm_enqueue_admin_scripts' );

function tm_enqueue_admin_scripts( $hook ) {
//  error_log( 'Current Hook: ' . $hook );

    // Load only on our form page
    if ( $hook !== 'testimonials_page_testimonial-form' ) {
        return;
    }

    // Enqueue WP Media Uploader
    wp_enqueue_media();

    wp_enqueue_script(
        'testimonial-form-js',                                   // Handle
        TM_PLUGIN_URL . 'admin/js/testimonial-form.js',         // Path
        [ 'jquery', 'media-upload', 'media-views' ],            // Dependencies
        '1.0.0',                                                 // Version
        true                                                     // Load in footer
    );



}

