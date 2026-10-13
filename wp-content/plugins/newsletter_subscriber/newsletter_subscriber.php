<?php
/*
Plugin Name: Newsletter Subscribers
Description: View newsletter subscribers from wp_newsletter_subscribers table.
Version: 1.0
Author: Guru
*/

add_action('admin_menu', function () {
    add_menu_page(
        'Newsletter Subscribers',
        'Email Subscribers list',
        'manage_options',
        'newsletter-subscribers',
        'render_newsletter_subscribers_page',
        'dashicons-email',
        25
    );
});

function render_newsletter_subscribers_page() {
    global $wpdb;

    $table = $wpdb->prefix . 'newsletter_subscribers';

    $subscribers = $wpdb->get_results(
        "SELECT * FROM {$table} ORDER BY created_at DESC"
    );

    echo '<div class="wrap">';
    echo '<h1>Newsletter Subscribers</h1>';

    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Status</th>
                <th>Subscribed On</th>
            </tr>
          </thead><tbody>';

    foreach ($subscribers as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->email) . '</td>';
        echo '<td>' . ($row->status ? 'Active' : 'Inactive') . '</td>';
        echo '<td>' . esc_html($row->created_at) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}