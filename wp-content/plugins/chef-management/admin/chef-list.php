<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET all chefs
function chef_get_all() {
    global $wpdb;
    return $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}chefs ORDER BY sort_order ASC"
    );
}

// DELETE chef by ID
function chef_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        "{$wpdb->prefix}chefs",
        [ 'id' => absint( $id ) ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// HANDLE DELETE ACTION
// ─────────────────────────────────────────
$chef_message      = '';
$chef_message_type = 'success';

if (
    isset( $_GET['action'] ) &&
    $_GET['action'] === 'delete' &&
    isset( $_GET['id'] )
) {
    $delete_id = absint( $_GET['id'] );

    // Verify nonce
    if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'chef_delete_' . $delete_id ) ) {
        $chef_message      = 'Security check failed. Please try again.';
        $chef_message_type = 'error';

    } else {
        $result = chef_delete( $delete_id );

        if ( $result ) {
            $chef_message      = 'Chef deleted successfully!';
            $chef_message_type = 'success';
        } else {
            $chef_message      = 'Failed to delete chef. Please try again.';
            $chef_message_type = 'error';
        }
    }
}


// ─────────────────────────────────────────
// FETCH ALL CHEFS
// ─────────────────────────────────────────
$chefs = chef_get_all();
?>


<div class="wrap">

    <h1 class="wp-heading-inline">All Chefs</h1>

    <a href="<?php echo esc_url( admin_url( 'admin.php?page=chef-form' ) ); ?>"
       class="page-title-action">
        Add New Chef
    </a>

    <hr class="wp-header-end">

    <?php if ( $chef_message ) : ?>
        <div class="notice notice-<?php echo $chef_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $chef_message ); ?></p>
        </div>
    <?php endif; ?>


    <?php if ( empty( $chefs ) ) : ?>

        <p>No chefs found. <a href="<?php echo esc_url( admin_url( 'admin.php?page=chef-form' ) ); ?>">Add your first chef</a>.</p>

    <?php else : ?>

        <table class="wp-list-table widefat fixed striped">

            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:80px;">Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th style="width:80px;">Order</th>
                    <th style="width:80px;">Status</th>
                    <th style="width:150px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ( $chefs as $index => $chef ) : ?>
                    <tr>

                        <!-- Serial Number -->
                        <td><?php echo esc_html( $index + 1 ); ?></td>

                        <!-- Profile Image -->
                        <td>
                            <?php if ( $chef->profile_image_id ) : ?>
                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $chef->profile_image_id, 'thumbnail' ) ); ?>"
                                     style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                            <?php else : ?>
                                —
                            <?php endif; ?>
                        </td>

                        <!-- Name -->
                        <td><?php echo esc_html( $chef->name ); ?></td>

                        <!-- Designation -->
                        <td><?php echo esc_html( $chef->designation ); ?></td>

                        <!-- Sort Order -->
                        <td><?php echo esc_html( $chef->sort_order ); ?></td>

                        <!-- Status -->
                        <td>
                            <?php if ( $chef->status == 1 ) : ?>
                                <span style="color:green; font-weight:600;">Active</span>
                            <?php else : ?>
                                <span style="color:red; font-weight:600;">Inactive</span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td>

                            <!-- Edit -->
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=chef-form&id=' . $chef->id ) ); ?>"
                               class="button button-small">
                                Edit
                            </a>

                            &nbsp;

                            <!-- Delete -->
                            <a href="<?php echo esc_url(
                                        wp_nonce_url(
                                            admin_url( 'admin.php?page=chef-management&action=delete&id=' . $chef->id ),
                                            'chef_delete_' . $chef->id
                                        )
                                    ); ?>"
                               class="button button-small"
                               style="color:red;"
                               onclick="return confirm('Are you sure you want to delete <?php echo esc_js( $chef->name ); ?>?');">
                                Delete
                            </a>

                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>

        </table>

    <?php endif; ?>

</div><!-- .wrap -->