<?php
/*
Plugin Name: Restaurant Bookings Admin
Description: View restaurant bookings from wp_restaurant_bookings table.
Version: 1.0
Author: Guru
*/

if (!defined('ABSPATH')) {
    exit;
}
add_action('admin_enqueue_scripts', 'rba_admin_assets');

function rba_admin_assets($hook) {

    // Optional: load only on your bookings page
    if (isset($_GET['page']) && $_GET['page'] === 'restaurant-bookings') {

        wp_enqueue_style(
            'rba-admin-style',
            plugin_dir_url(__FILE__) . 'assets/admin-style.css',
            [],
            '1.0'
        );
    }
}


// Add Admin Menu
add_action('admin_menu', 'rba_admin_menu');

function rba_admin_menu() {
    add_menu_page(
        'Restaurant Bookings',
        'Table Bookings List',
        'manage_options',
        'restaurant-bookings',
        'rba_bookings_page',
        'dashicons-calendar-alt',
        25
    );
}

// Display Bookings
function rba_bookings_page() {

    global $wpdb;
// Delete booking
if (
    isset($_GET['action']) &&
    $_GET['action'] === 'delete' &&
    isset($_GET['booking_id']) &&
    isset($_GET['_wpnonce']) &&
    wp_verify_nonce($_GET['_wpnonce'], 'delete_booking')
) {

    $booking_id = intval($_GET['booking_id']);

    $wpdb->delete(
        $wpdb->prefix . 'restaurant_bookings',
        ['id' => $booking_id],
        ['%d']
    );

    echo '<div class="notice notice-success is-dismissible"><p>Booking deleted successfully.</p></div>';
}
    $table_name = $wpdb->prefix . 'restaurant_bookings';

    // Pagination
$per_page = 10;
$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$offset = ($current_page - 1) * $per_page;

// Total records
$total_items = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$table_name}"
);

$total_pages = ceil($total_items / $per_page);

// Fetch current page records
$bookings = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$table_name} ORDER BY id DESC LIMIT %d OFFSET %d",
        $per_page,
        $offset
    )
);

    ?>
    <div class="wrap">
        <h1>Restaurant Bookings</h1>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>serial no</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Persons</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php if (!empty($bookings)) : ?>
            <?php $i = (($current_page - 1) * $per_page) + 1; ?>
                <?php foreach ($bookings as $key=>$booking) : ?>

                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo esc_html($booking->name); ?></td>
                        <td><?php echo esc_html($booking->phone); ?></td>
                        <td><?php echo esc_html($booking->persons); ?></td>
                        <td><?php echo esc_html($booking->date); ?></td>
                        <td><?php echo esc_html($booking->time); ?></td>
                        <td><?php echo esc_html($booking->message); ?></td>
                        <td><button style="background-color:red">Approve</button></td>
                        <td>
    <a
        href="<?php echo wp_nonce_url(
            admin_url('admin.php?page=restaurant-bookings&action=delete&booking_id=' . $booking->id),
            'delete_booking'
        ); ?>"
        class="button button-danger"
        onclick="return confirm('Are you sure you want to delete this booking?');"
        style="background:#dc3232;color:#fff;border-color:#dc3232;"
    >
        Delete
    </a>
</td>
                    </tr>

                <?php endforeach; ?>

            <?php else : ?>

                <tr>
                    <td colspan="7">No bookings found.</td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>
        
<div class="tablenav bottom">
<div class="pagination-wrapper">
    <?php
    echo paginate_links([
        'base'      => admin_url('admin.php?page=restaurant-bookings&paged=%#%'),
        'current'   => $current_page,
        'total'     => $total_pages,
        'prev_text' => '« Previous',
        'next_text' => 'Next »',
    ]);
    ?>
</div>
</div>

    </div>
    <?php
}

