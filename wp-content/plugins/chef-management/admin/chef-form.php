<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET single chef by ID
function chef_get_single( $id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}chefs WHERE id = %d", $id )
    );
}

// INSERT new chef
function chef_insert( $data ) {
    global $wpdb;
    $wpdb->insert(
        "{$wpdb->prefix}chefs",
        [
            'name'             => sanitize_text_field( $data['name'] ),
            'designation'      => sanitize_text_field( $data['designation'] ),
            'bio'              => sanitize_textarea_field( $data['bio'] ),
            'profile_image_id' => absint( $data['profile_image_id'] ),
            'hover_image_id'   => absint( $data['hover_image_id'] ),
            'facebook_url'     => esc_url_raw( $data['facebook_url'] ),
            'twitter_url'      => esc_url_raw( $data['twitter_url'] ),
            'dribbble_url'     => esc_url_raw( $data['dribbble_url'] ),
            'linkedin_url'     => esc_url_raw( $data['linkedin_url'] ),
            'sort_order'       => absint( $data['sort_order'] ),
            'status'           => absint( $data['status'] ),
        ],
        [ '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d', '%d' ]
    );
    return $wpdb->insert_id;
}

// UPDATE existing chef
function chef_update( $id, $data ) {
    global $wpdb;
    return $wpdb->update(
        "{$wpdb->prefix}chefs",
        [
            'name'             => sanitize_text_field( $data['name'] ),
            'designation'      => sanitize_text_field( $data['designation'] ),
            'bio'              => sanitize_textarea_field( $data['bio'] ),
            'profile_image_id' => absint( $data['profile_image_id'] ),
            'hover_image_id'   => absint( $data['hover_image_id'] ),
            'facebook_url'     => esc_url_raw( $data['facebook_url'] ),
            'twitter_url'      => esc_url_raw( $data['twitter_url'] ),
            'dribbble_url'     => esc_url_raw( $data['dribbble_url'] ),
            'linkedin_url'     => esc_url_raw( $data['linkedin_url'] ),
            'sort_order'       => absint( $data['sort_order'] ),
            'status'           => absint( $data['status'] ),
        ],
        [ 'id' => absint( $id ) ],
        [ '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d', '%d' ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// FORM HANDLING
// ─────────────────────────────────────────

$chef_message = '';
$chef_message_type = 'success'; // 'success' or 'error'

if ( isset( $_POST['chef_form_submit'] ) ) {

    // Verify nonce
    if ( ! isset( $_POST['chef_nonce'] ) || ! wp_verify_nonce( $_POST['chef_nonce'], 'chef_save_action' ) ) {
        $chef_message      = 'Security check failed. Please try again.';
        $chef_message_type = 'error';

    } else {

        $post_id = isset( $_POST['chef_id'] ) ? absint( $_POST['chef_id'] ) : 0;

        $data = [
            'name'             => $_POST['chef_name']             ?? '',
            'designation'      => $_POST['chef_designation']      ?? '',
            'bio'              => $_POST['chef_bio']              ?? '',
            'profile_image_id' => $_POST['chef_profile_image_id'] ?? 0,
            'hover_image_id'   => $_POST['chef_hover_image_id']   ?? 0,
            'facebook_url'     => $_POST['chef_facebook']         ?? '',
            'twitter_url'      => $_POST['chef_twitter']          ?? '',
            'dribbble_url'     => $_POST['chef_dribbble']         ?? '',
            'linkedin_url'     => $_POST['chef_linkedin']         ?? '',
            'sort_order'       => $_POST['chef_sort_order']       ?? 0,
            'status'           => $_POST['chef_status']           ?? 0,
        ];

        if ( $post_id > 0 ) {
            // UPDATE
            $result = chef_update( $post_id, $data );
            $chef_message = ( $result !== false )
                ? 'Chef updated successfully!'
                : 'Failed to update chef. Please try again.';
            $chef_message_type = ( $result !== false ) ? 'success' : 'error';

        } else {
            // INSERT
            $result = chef_insert( $data );
            $chef_message = ( $result > 0 )
                ? 'Chef added successfully!'
                : 'Failed to add chef. Please try again.';
            $chef_message_type = ( $result > 0 ) ? 'success' : 'error';

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

$chef_id   = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : ( $post_id ?? 0 );
$chef      = ( $chef_id > 0 ) ? chef_get_single( $chef_id ) : null;
$is_edit   = ! empty( $chef );
$page_title = $is_edit ? 'Edit Chef' : 'Add New Chef';


// ─────────────────────────────────────────
// HELPER: safe field value
// ─────────────────────────────────────────
function chef_field( $chef, $field, $default = '' ) {
    return $chef ? esc_attr( $chef->$field ) : $default;
}


// ─────────────────────────────────────────
// ENQUEUE WP MEDIA UPLOADER
// ─────────────────────────────────────────

?>


<div class="wrap">

    <h1><?php echo esc_html( $page_title ); ?></h1>

    <a href="<?php echo esc_url( admin_url( 'admin.php?page=chef-management' ) ); ?>">
        &larr; Back to All Chefs
    </a>

    <br><br>

    <?php if ( $chef_message ) : ?>
        <div class="notice notice-<?php echo $chef_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $chef_message ); ?></p>
        </div>
    <?php endif; ?>


    <!-- ─────────────────────────────────────────
         FORM
    ───────────────────────────────────────── -->
    <form method="post" action="">

        <?php wp_nonce_field( 'chef_save_action', 'chef_nonce' ); ?>

        <!-- Hidden chef ID for edit mode -->
        <input type="hidden" name="chef_id"
               value="<?php echo esc_attr( $chef_id ); ?>">

        <table class="form-table">

            <!-- Name -->
            <tr>
                <th><label for="chef_name">Name <span style="color:red;">*</span></label></th>
                <td>
                    <input type="text"
                           id="chef_name"
                           name="chef_name"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'name' ); ?>"
                           required>
                </td>
            </tr>

            <!-- Designation -->
            <tr>
                <th><label for="chef_designation">Designation <span style="color:red;">*</span></label></th>
                <td>
                    <input type="text"
                           id="chef_designation"
                           name="chef_designation"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'designation' ); ?>"
                           required>
                </td>
            </tr>

            <!-- Bio -->
            <tr>
                <th><label for="chef_bio">Bio</label></th>
                <td>
                    <textarea id="chef_bio"
                              name="chef_bio"
                              class="large-text"
                              rows="4"><?php echo $chef ? esc_textarea( $chef->bio ) : ''; ?></textarea>
                </td>
            </tr>

            <!-- Profile Image -->
            <tr>
                <th><label>Profile Image</label></th>
                <td>
                    <input type="hidden"
                           id="chef_profile_image_id"
                           name="chef_profile_image_id"
                           value="<?php echo chef_field( $chef, 'profile_image_id', '0' ); ?>">

                    <div id="chef_profile_image_preview">
                        <?php if ( $is_edit && $chef->profile_image_id ) : ?>
                            <img src="<?php echo esc_url( wp_get_attachment_image_url( $chef->profile_image_id, 'thumbnail' ) ); ?>"
                                 style="max-width:150px; display:block; margin-bottom:8px;">
                        <?php endif; ?>
                    </div>

                    <button type="button"
                            class="button"
                            id="chef_profile_image_btn">
                        <?php echo $is_edit && $chef->profile_image_id ? 'Change Profile Image' : 'Upload Profile Image'; ?>
                    </button>


                    <?php if ( $is_edit && $chef->profile_image_id ) : ?>
                        <button type="button"
                                class="button"
                                id="chef_profile_image_remove">
                            Remove
                        </button>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- Hover Image -->
            <tr>
                <th><label>Hover Image</label></th>
                <td>
                    <input type="hidden"
                           id="chef_hover_image_id"
                           name="chef_hover_image_id"
                           value="<?php echo chef_field( $chef, 'hover_image_id', '0' ); ?>">

                    <div id="chef_hover_image_preview">
                        <?php if ( $is_edit && $chef->hover_image_id ) : ?>
                            <img src="<?php echo esc_url( wp_get_attachment_image_url( $chef->hover_image_id, 'thumbnail' ) ); ?>"
                                 style="max-width:150px; display:block; margin-bottom:8px;">
                        <?php endif; ?>
                    </div>

                    <button type="button"
                            class="button"
                            id="chef_hover_image_btn">
                        <?php echo $is_edit && $chef->hover_image_id ? 'Change Hover Image' : 'Upload Hover Image'; ?>
                    </button>

                    <?php if ( $is_edit && $chef->hover_image_id ) : ?>
                        <button type="button"
                                class="button"
                                id="chef_hover_image_remove">
                            Remove
                        </button>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- Social: Facebook -->
            <tr>
                <th><label for="chef_facebook">Facebook URL</label></th>
                <td>
                    <input type="url"
                           id="chef_facebook"
                           name="chef_facebook"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'facebook_url' ); ?>">
                </td>
            </tr>

            <!-- Social: Twitter -->
            <tr>
                <th><label for="chef_twitter">Twitter URL</label></th>
                <td>
                    <input type="url"
                           id="chef_twitter"
                           name="chef_twitter"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'twitter_url' ); ?>">
                </td>
            </tr>

            <!-- Social: Dribbble -->
            <tr>
                <th><label for="chef_dribbble">Dribbble URL</label></th>
                <td>
                    <input type="url"
                           id="chef_dribbble"
                           name="chef_dribbble"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'dribbble_url' ); ?>">
                </td>
            </tr>

            <!-- Social: LinkedIn -->
            <tr>
                <th><label for="chef_linkedin">LinkedIn URL</label></th>
                <td>
                    <input type="url"
                           id="chef_linkedin"
                           name="chef_linkedin"
                           class="regular-text"
                           value="<?php echo chef_field( $chef, 'linkedin_url' ); ?>">
                </td>
            </tr>

            <!-- Sort Order -->
            <tr>
                <th><label for="chef_sort_order">Sort Order</label></th>
                <td>
                    <input type="number"
                           id="chef_sort_order"
                           name="chef_sort_order"
                           class="small-text"
                           value="<?php echo chef_field( $chef, 'sort_order', '0' ); ?>"
                           min="0">
                    <p class="description">Lower number = shown first.</p>
                </td>
            </tr>

            <!-- Status -->
            <tr>
                <th><label for="chef_status">Status</label></th>
                <td>
                    <select id="chef_status" name="chef_status">
                        <option value="1" <?php selected( chef_field( $chef, 'status', '1' ), '1' ); ?>>Active</option>
                        <option value="0" <?php selected( chef_field( $chef, 'status', '1' ), '0' ); ?>>Inactive</option>
                    </select>
                </td>
            </tr>

        </table>

        <?php submit_button( $is_edit ? 'Update Chef' : 'Add Chef', 'primary', 'chef_form_submit' ); ?>

    </form>

</div><!-- .wrap -->


<!-- ─────────────────────────────────────────
     WP MEDIA UPLOADER JS
