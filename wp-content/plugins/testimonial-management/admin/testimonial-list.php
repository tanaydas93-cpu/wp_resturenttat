<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET all testimonials
function tm_get_all() {
    global $wpdb;
    return $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}testimonials ORDER BY sort_order ASC"
    );
}

// DELETE testimonial by ID
function tm_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        "{$wpdb->prefix}testimonials",
        [ 'id' => absint( $id ) ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// HANDLE DELETE ACTION
// ─────────────────────────────────────────
$tm_message      = '';
$tm_message_type = 'success';

if (
    isset( $_GET['action'] ) &&
    $_GET['action'] === 'delete' &&
    isset( $_GET['id'] )
) {
    $delete_id = absint( $_GET['id'] );

    // Verify nonce
    if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'tm_delete_' . $delete_id ) ) {
        $tm_message      = 'Security check failed. Please try again.';
        $tm_message_type = 'error';

    } else {
        $result = tm_delete( $delete_id );

        if ( $result ) {
            $tm_message      = 'Testimonial deleted successfully!';
            $tm_message_type = 'success';
        } else {
            $tm_message      = 'Failed to delete testimonial. Please try again.';
            $tm_message_type = 'error';
        }
    }
}


// ─────────────────────────────────────────
// FETCH ALL TESTIMONIALS
// ─────────────────────────────────────────
$testimonials = tm_get_all();
?>


<div class="wrap">

    <h1 class="wp-heading-inline">All Testimonials</h1>

    <a href="<?php echo esc_url( admin_url( 'admin.php?page=testimonial-form' ) ); ?>"
       class="page-title-action">
        Add New Testimonial
    </a>

    <hr class="wp-header-end">

    <?php if ( $tm_message ) : ?>
        <div class="notice notice-<?php echo $tm_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $tm_message ); ?></p>
        </div>
    <?php endif; ?>


    <?php if ( empty( $testimonials ) ) : ?>

        <p>No testimonials found. <a href="<?php echo esc_url( admin_url( 'admin.php?page=testimonial-form' ) ); ?>">Add your first testimonial</a>.</p>

    <?php else : ?>

        <table class="wp-list-table widefat fixed striped">

            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:80px;">Image</th>
                    <th>Author</th>
                    <th>Location</th>
                    <th style="width:120px;">Rating</th>
                    <th>Description</th>
                    <th style="width:80px;">Order</th>
                    <th style="width:80px;">Status</th>
                    <th style="width:150px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ( $testimonials as $index => $testimonial ) : ?>
                    <tr>

                        <!-- Serial Number -->
                        <td><?php echo esc_html( $index + 1 ); ?></td>

                        <!-- Author Image -->
                        <td>
                            <?php if ( $testimonial->image_id ) : ?>
                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $testimonial->image_id, 'thumbnail' ) ); ?>"
                                     style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                            <?php else : ?>
                                —
                            <?php endif; ?>
                        </td>

                        <!-- Author Name -->
                        <td><?php echo esc_html( $testimonial->author_name ); ?></td>

                        <!-- Location -->
                        <td><?php echo esc_html( $testimonial->location ?: '—' ); ?></td>

                        <!-- Rating -->
                        <td>
                            <?php
                            $rating = absint( $testimonial->rating );
                            echo str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating );
                            ?>
                        </td>

                        <!-- Description (excerpt) -->
                        <td>
                            <?php
                            $desc = $testimonial->description;
                            echo esc_html( mb_strlen( $desc ) > 60 ? mb_substr( $desc, 0, 60 ) . '...' : $desc );
                            ?>
                        </td>

                        <!-- Sort Order -->
                        <td><?php echo esc_html( $testimonial->sort_order ); ?></td>

                        <!-- Status -->
                        <td>
                            <?php if ( $testimonial->status == 1 ) : ?>
                                <span style="color:green; font-weight:600;">Active</span>
                            <?php else : ?>
                                <span style="color:red; font-weight:600;">Inactive</span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td>

                            <!-- Edit -->
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=testimonial-form&id=' . $testimonial->id ) ); ?>"
                               class="button button-small">
                                Edit
                            </a>

                            &nbsp;

                            <!-- Delete -->
                            <a href="<?php echo esc_url(
                                        wp_nonce_url(
                                            admin_url( 'admin.php?page=testimonial-management&action=delete&id=' . $testimonial->id ),
                                            'tm_delete_' . $testimonial->id
                                        )
                                    ); ?>"
                               class="button button-small"
                               style="color:red;"
                               onclick="return confirm('Are you sure you want to delete testimonial by <?php echo esc_js( $testimonial->author_name ); ?>?');">
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
                    <th>Author</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>

        </table>

    <?php endif; ?>

</div><!-- .wrap -->