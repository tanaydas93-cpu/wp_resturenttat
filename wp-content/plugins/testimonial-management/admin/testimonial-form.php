<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET single testimonial by ID
function tm_get_single( $id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}testimonials WHERE id = %d", $id )
    );
}

// INSERT new testimonial
function tm_insert( $data ) {
    global $wpdb;
    $wpdb->insert(
        "{$wpdb->prefix}testimonials",
        [
            'author_name' => sanitize_text_field( $data['author_name'] ),
            'location'    => sanitize_text_field( $data['location'] ),
            'rating'      => absint( $data['rating'] ),
            'description' => sanitize_textarea_field( $data['description'] ),
            'image_id'    => absint( $data['image_id'] ),
            'sort_order'  => absint( $data['sort_order'] ),
            'status'      => absint( $data['status'] ),
        ],
        [ '%s', '%s', '%d', '%s', '%d', '%d', '%d' ]
    );
    return $wpdb->insert_id;
}

// UPDATE existing testimonial
function tm_update( $id, $data ) {
    global $wpdb;
    return $wpdb->update(
        "{$wpdb->prefix}testimonials",
        [
            'author_name' => sanitize_text_field( $data['author_name'] ),
            'location'    => sanitize_text_field( $data['location'] ),
            'rating'      => absint( $data['rating'] ),
            'description' => sanitize_textarea_field( $data['description'] ),
            'image_id'    => absint( $data['image_id'] ),
            'sort_order'  => absint( $data['sort_order'] ),
            'status'      => absint( $data['status'] ),
        ],
        [ 'id' => absint( $id ) ],
        [ '%s', '%s', '%d', '%s', '%d', '%d', '%d' ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// FORM HANDLING
// ─────────────────────────────────────────

$tm_message      = '';
$tm_message_type = 'success'; // 'success' or 'error'

if ( isset( $_POST['tm_form_submit'] ) ) {

    // Verify nonce
    if ( ! isset( $_POST['tm_nonce'] ) || ! wp_verify_nonce( $_POST['tm_nonce'], 'tm_save_action' ) ) {
        $tm_message      = 'Security check failed. Please try again.';
        $tm_message_type = 'error';

    } else {

        $post_id = isset( $_POST['tm_id'] ) ? absint( $_POST['tm_id'] ) : 0;

        $data = [
            'author_name' => $_POST['tm_author_name'] ?? '',
            'location'    => $_POST['tm_location']    ?? '',
            'rating'      => $_POST['tm_rating']      ?? 5,
            'description' => $_POST['tm_description'] ?? '',
            'image_id'    => $_POST['tm_image_id']     ?? 0,
            'sort_order'  => $_POST['tm_sort_order']  ?? 0,
            'status'      => $_POST['tm_status']      ?? 0,
        ];

        if ( $post_id > 0 ) {
            // UPDATE
            $result = tm_update( $post_id, $data );
            $tm_message      = ( $result !== false ) ? 'Testimonial updated successfully!' : 'Failed to update testimonial. Please try again.';
            $tm_message_type = ( $result !== false ) ? 'success' : 'error';

        } else {
            // INSERT
            $result = tm_insert( $data );
            $tm_message      = ( $result > 0 ) ? 'Testimonial added successfully!' : 'Failed to add testimonial. Please try again.';
            $tm_message_type = ( $result > 0 ) ? 'success' : 'error';

            // Reset post_id so form clears after insert
            if ( $result > 0 ) {
                $post_id = 0;
            }
        }
    }
}


// ─────────────────────────────────────────
// LOAD EXISTING DATA (Edit Mode)
// ─────────────────────────────────────────

$tm_id      = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : ( $post_id ?? 0 );
$testimonial = ( $tm_id > 0 ) ? tm_get_single( $tm_id ) : null;
$is_edit    = ! empty( $testimonial );
$page_title = $is_edit ? 'Edit Testimonial' : 'Add New Testimonial';


// ─────────────────────────────────────────
// HELPER: safe field value
// ─────────────────────────────────────────
function tm_field( $testimonial, $field, $default = '' ) {
    return $testimonial ? esc_attr( $testimonial->$field ) : $default;
}
?>


<div class="wrap">

    <h1><?php echo esc_html( $page_title ); ?></h1>

    <a href="<?php echo esc_url( admin_url( 'admin.php?page=testimonial-management' ) ); ?>">
        &larr; Back to All Testimonials
    </a>

    <br><br>

    <?php if ( $tm_message ) : ?>
        <div class="notice notice-<?php echo $tm_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $tm_message ); ?></p>
        </div>
    <?php endif; ?>


    <!-- ─────────────────────────────────────────
         FORM
    ───────────────────────────────────────── -->
    <form method="post" action="">

        <?php wp_nonce_field( 'tm_save_action', 'tm_nonce' ); ?>

        <!-- Hidden ID for edit mode -->
        <input type="hidden" name="tm_id"
               value="<?php echo esc_attr( $tm_id ); ?>">

        <table class="form-table">

            <!-- Author Name -->
            <tr>
                <th><label for="tm_author_name">Author Name <span style="color:red;">*</span></label></th>
                <td>
                    <input type="text"
                           id="tm_author_name"
                           name="tm_author_name"
                           class="regular-text"
                           value="<?php echo tm_field( $testimonial, 'author_name' ); ?>"
                           required>
                </td>
            </tr>

            <!-- Location -->
            <tr>
                <th><label for="tm_location">Location</label></th>
                <td>
                    <input type="text"
                           id="tm_location"
                           name="tm_location"
                           class="regular-text"
                           value="<?php echo tm_field( $testimonial, 'location' ); ?>"
                           placeholder="New York">
                </td>
            </tr>

            <!-- Rating -->
            <tr>
                <th><label for="tm_rating">Rating <span style="color:red;">*</span></label></th>
                <td>
                    <?php $current_rating = tm_field( $testimonial, 'rating', '5' ); ?>
                    <select id="tm_rating" name="tm_rating" required>
                        <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
                            <option value="<?php echo esc_attr( $i ); ?>"
                                <?php selected( $current_rating, $i ); ?>>
                                <?php echo esc_html( $i ); ?> Star<?php echo $i > 1 ? 's' : ''; ?>
                                — <?php echo str_repeat( '★', $i ) . str_repeat( '☆', 5 - $i ); ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>

            <!-- Description -->
            <tr>
                <th><label for="tm_description">Description <span style="color:red;">*</span></label></th>
                <td>
                    <textarea id="tm_description"
                              name="tm_description"
                              class="large-text"
                              rows="4"
                              required><?php echo $testimonial ? esc_textarea( $testimonial->description ) : ''; ?></textarea>
                </td>
            </tr>

            <!-- Author Image -->
            <tr>
                <th><label>Author Image</label></th>
                <td>
                    <input type="hidden"
                           id="tm_image_id"
                           name="tm_image_id"
                           value="<?php echo tm_field( $testimonial, 'image_id', '0' ); ?>">

                    <div id="tm_image_preview">
                        <?php if ( $is_edit && $testimonial->image_id ) : ?>
                            <img src="<?php echo esc_url( wp_get_attachment_image_url( $testimonial->image_id, 'thumbnail' ) ); ?>"
                                 style="max-width:100px; display:block; margin-bottom:8px; border-radius:50%;">
                        <?php endif; ?>
                    </div>

                    <button type="button"
                            class="button"
                            id="tm_image_btn">
                        <?php echo $is_edit && $testimonial->image_id ? 'Change Image' : 'Upload Image'; ?>
                    </button>

                    <?php if ( $is_edit && $testimonial->image_id ) : ?>
                        <button type="button"
                                class="button"
                                id="tm_image_remove">
                            Remove
                        </button>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- Sort Order -->
            <tr>
                <th><label for="tm_sort_order">Sort Order</label></th>
                <td>
                    <input type="number"
                           id="tm_sort_order"
                           name="tm_sort_order"
                           class="small-text"
                           value="<?php echo tm_field( $testimonial, 'sort_order', '0' ); ?>"
                           min="0">
                    <p class="description">Lower number = shown first.</p>
                </td>
            </tr>

            <!-- Status -->
            <tr>
                <th><label for="tm_status">Status</label></th>
                <td>
                    <select id="tm_status" name="tm_status">
                        <option value="1" <?php selected( tm_field( $testimonial, 'status', '1' ), '1' ); ?>>Active</option>
                        <option value="0" <?php selected( tm_field( $testimonial, 'status', '1' ), '0' ); ?>>Inactive</option>
                    </select>
                </td>
            </tr>

        </table>

        <?php submit_button( $is_edit ? 'Update Testimonial' : 'Add Testimonial', 'primary', 'tm_form_submit' ); ?>

    </form>

</div><!-- .wrap -->