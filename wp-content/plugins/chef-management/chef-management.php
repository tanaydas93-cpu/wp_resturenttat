<?php
/**
 * Plugin Name: Chef Management
 * Plugin URI:  https://yourwebsite.com
 * Description: Manage chefs dynamically on the website.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL-2.0+
 * Text Domain: chef-management
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─────────────────────────────────────────
// CONSTANTS
// ─────────────────────────────────────────
define( 'CHEF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CHEF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// ─────────────────────────────────────────
// ADMIN MENU REGISTRATION
// ─────────────────────────────────────────
add_action( 'admin_menu', 'chef_register_admin_menu' );

function chef_register_admin_menu() {

    // Top-level Menu
    add_menu_page(
        'Chef Management',          // Page title
        'Chef Management',          // Menu title
        'manage_options',           // Capability
        'chef-management',          // Menu slug
        'chef_list_page',           // Callback function
        'dashicons-food',           // Icon
        30                          // Position
    );

    // Submenu → All Chefs (same as parent)
    add_submenu_page(
        'chef-management',          // Parent slug
        'All Chefs',                // Page title
        'All Chefs',                // Menu title
        'manage_options',           // Capability
        'chef-management',          // Menu slug (same as parent = no duplicate)
        'chef_list_page'            // Callback function
    );

    // Submenu → Add / Edit Chef
    add_submenu_page(
        'chef-management',          // Parent slug
        'Add / Edit Chef',          // Page title
        'Add New Chef',             // Menu title
        'manage_options',           // Capability
        'chef-form',                // Menu slug
        'chef_form_page'            // Callback function
    );
}


// ─────────────────────────────────────────
// PAGE CALLBACKS
// ─────────────────────────────────────────

// Loads admin/chef-list.php
function chef_list_page() {
    require_once CHEF_PLUGIN_DIR . 'admin/chef-list.php';
}

// Loads admin/chef-form.php
function chef_form_page() {
    require_once CHEF_PLUGIN_DIR . 'admin/chef-form.php';
}

// ─────────────────────────────────────────
// ENQUEUE ADMIN SCRIPTS
// ─────────────────────────────────────────
add_action( 'admin_enqueue_scripts', 'chef_enqueue_admin_scripts' );

function chef_enqueue_admin_scripts( $hook ) {

    // Load only on our form page
    if ( $hook !== 'chef-management_page_chef-form' ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'chef-form-js',                                          // Handle
        CHEF_PLUGIN_URL . 'admin/js/chef-form.js',              // Path
        [ 'jquery', 'media-upload', 'media-views' ],            // Dependencies
        '1.0.0',                                                 // Version
        true                                                     // Load in footer
    );
}

