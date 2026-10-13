<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET video section (always single row)
function vs_get_video() {
    global $wpdb;
    return $wpdb->get_row(
        "SELECT * FROM {$wpdb->prefix}video_section WHERE status = 1 LIMIT 1"
    );
}

// INSERT video section
function vs_insert( $data ) {
    global $wpdb;
    return $wpdb->insert(
        "{$wpdb->prefix}video_section",
        [
            'video_id' => absint( $data['video_id'] ),
            'status'   => 1,
        ],
        [ '%d', '%d' ]
    );
}

// UPDATE video section
function vs_update( $id, $data ) {
    global $wpdb;
    return $wpdb->update(
        "{$wpdb->prefix}video_section",
        [
            'video_id' => absint( $data['video_id'] ),
        ],
        [ 'id' => absint( $id ) ],
        [ '%d' ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// FORM HANDLING
// ─────────────────────────────────────────
$vs_message      = '';
$vs_message_type = 'success';

if ( isset( $_POST['vs_form_submit'] ) ) {

    // Verify nonce
    if ( ! isset( $_POST['vs_nonce'] ) || ! wp_verify_nonce( $_POST['vs_nonce'], 'vs_save_action' ) ) {
        $vs_message      = 'Security check failed. Please try again.';
        $vs_message_type = 'error';

    } else {

        $data = [
            'video_id' => $_POST['vs_video_id'] ?? 0,
        ];

        // Validate
        if ( empty( $data['video_id'] ) || $data['video_id'] == 0 ) {
            $vs_message      = 'Please select a video.';
            $vs_message_type = 'error';

        } else {

            $existing = vs_get_video();

            if ( $existing ) {
                // UPDATE existing row
                $result          = vs_update( $existing->id, $data );
                $vs_message      = ( $result !== false ) ? 'Video updated successfully!' : 'Failed to update. Please try again.';
                $vs_message_type = ( $result !== false ) ? 'success' : 'error';

            } else {
                // INSERT first time
                $result          = vs_insert( $data );
                $vs_message      = ( $result ) ? 'Video saved successfully!' : 'Failed to save. Please try again.';
                $vs_message_type = ( $result ) ? 'success' : 'error';
            }
        }
    }
}


// ─────────────────────────────────────────
// LOAD EXISTING DATA
// ─────────────────────────────────────────
$video = vs_get_video();
?>


<div class="wrap">

    <h1>Video Section</h1>

    <?php if ( $vs_message ) : ?>
        <div class="notice notice-<?php echo $vs_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $vs_message ); ?></p>
        </div>
    <?php endif; ?>


    <!-- ─────────────────────────────────────────
         FORM
    ───────────────────────────────────────── -->
    <form method="post" action="">

        <?php wp_nonce_field( 'vs_save_action', 'vs_nonce' ); ?>

        <table class="form-table">

            <!-- Video Upload -->
            <tr>
                <th>
                    <label>Video <span style="color:red;">*</span></label>
                </th>
                <td>
                    <input type="hidden"
                           id="vs_video_id"
                           name="vs_video_id"
                           value="<?php echo $video ? esc_attr( $video->video_id ) : '0'; ?>">

                    <!-- Current Video Preview -->
                    <div id="vs_video_preview">
                        <?php if ( $video && $video->video_id ) :
                            $video_url = wp_get_attachment_url( $video->video_id );
                        ?>
                            <video width="320"
                                   height="180"
                                   controls
                                   style="display:block; margin-bottom:8px;">
                                <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Button -->
                    <button type="button" class="button" id="vs_video_btn">
                        <?php echo ( $video && $video->video_id ) ? 'Change Video' : 'Upload Video'; ?>
                    </button>

                    <!-- Remove Button -->
                    <?php if ( $video && $video->video_id ) : ?>
                        <button type="button" class="button" id="vs_video_remove">
                            Remove
                        </button>
                    <?php endif; ?>

                    <p class="description">Accepted formats: MP4, WebM, OGG</p>

                </td>
            </tr>

        </table>

        <?php submit_button( 'Save Video', 'primary', 'vs_form_submit' ); ?>

    </form>

</div><!-- .wrap -->