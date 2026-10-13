<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ─────────────────────────────────────────
// DB FUNCTIONS
// ─────────────────────────────────────────

// GET restaurant info (always single row)
function ri_get_info() {
    global $wpdb;
    return $wpdb->get_row(
        "SELECT * FROM {$wpdb->prefix}restaurant_info WHERE status = 1 LIMIT 1"
    );
}

// INSERT restaurant info
function ri_insert( $data ) {
    global $wpdb;
    return $wpdb->insert(
        "{$wpdb->prefix}restaurant_info",
        [
            'address_line'  => sanitize_text_field( $data['address_line'] ),
            'address_city'  => sanitize_text_field( $data['address_city'] ),
            'lunch_start'   => sanitize_text_field( $data['lunch_start'] ),
            'lunch_end'     => sanitize_text_field( $data['lunch_end'] ),
            'dinner_start'  => sanitize_text_field( $data['dinner_start'] ),
            'dinner_end'    => sanitize_text_field( $data['dinner_end'] ),
            'email'         => sanitize_email( $data['email'] ),
            'booking_phone' => sanitize_text_field( $data['booking_phone'] ),
            'image_id'      => absint( $data['image_id'] ),
            'status'        => 1,
        ],
        [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d' ,'%d']
    );
}

// UPDATE restaurant info
function ri_update( $id, $data ) {
    global $wpdb;
    return $wpdb->update(
        "{$wpdb->prefix}restaurant_info",
        [
            'address_line'  => sanitize_text_field( $data['address_line'] ),
            'address_city'  => sanitize_text_field( $data['address_city'] ),
            'lunch_start'   => sanitize_text_field( $data['lunch_start'] ),
            'lunch_end'     => sanitize_text_field( $data['lunch_end'] ),
            'dinner_start'  => sanitize_text_field( $data['dinner_start'] ),
            'dinner_end'    => sanitize_text_field( $data['dinner_end'] ),
            'email'         => sanitize_email( $data['email'] ),
            'booking_phone' => sanitize_text_field( $data['booking_phone'] ),
             'image_id'      => absint( $data['image_id'] ),
        ],
        [ 'id' => absint( $id ) ],
        [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ,'%d' ],
        [ '%d' ]
    );
}


// ─────────────────────────────────────────
// FORM HANDLING
// ─────────────────────────────────────────
$ri_message      = '';
$ri_message_type = 'success';

if ( isset( $_POST['ri_form_submit'] ) ) {

    // Verify nonce
    if ( ! isset( $_POST['ri_nonce'] ) || ! wp_verify_nonce( $_POST['ri_nonce'], 'ri_save_action' ) ) {
        $ri_message      = 'Security check failed. Please try again.';
        $ri_message_type = 'error';

    } else {

        $data = [
            'address_line'  => $_POST['ri_address_line']  ?? '',
            'address_city'  => $_POST['ri_address_city']  ?? '',
            'lunch_start'   => $_POST['ri_lunch_start']   ?? '',
            'lunch_end'     => $_POST['ri_lunch_end']     ?? '',
            'dinner_start'  => $_POST['ri_dinner_start']  ?? '',
            'dinner_end'    => $_POST['ri_dinner_end']    ?? '',
            'email'         => $_POST['ri_email']         ?? '',
            'booking_phone' => $_POST['ri_booking_phone'] ?? '',
            'image_id'      => absint( $_POST['ri_image_id'] ) ?? 0,
        ];

        $existing = ri_get_info();

        if ( $existing ) {
            // UPDATE existing row
            $result          = ri_update( $existing->id, $data );
            $ri_message      = ( $result !== false ) ? 'Restaurant info updated successfully!' : 'Failed to update. Please try again.';
            $ri_message_type = ( $result !== false ) ? 'success' : 'error';

        } else {
            // INSERT first time
            $result          = ri_insert( $data );
            $ri_message      = ( $result ) ? 'Restaurant info saved successfully!' : 'Failed to save. Please try again.';
            $ri_message_type = ( $result ) ? 'success' : 'error';
        }
    }
}


// ─────────────────────────────────────────
// LOAD EXISTING DATA
// ─────────────────────────────────────────
$info = ri_get_info();


// ─────────────────────────────────────────
// HELPER: safe field value
// ─────────────────────────────────────────
function ri_field( $info, $field, $default = '' ) {
    return $info ? esc_attr( $info->$field ) : $default;
}
?>


<div class="wrap">

    <h1>Restaurant Info</h1>

    <?php if ( $ri_message ) : ?>
        <div class="notice notice-<?php echo $ri_message_type === 'success' ? 'success' : 'error'; ?> is-dismissible">
            <p><?php echo esc_html( $ri_message ); ?></p>
        </div>
    <?php endif; ?>


    <!-- ─────────────────────────────────────────
         FORM
    ───────────────────────────────────────── -->
    <form method="post" action="">

        <?php wp_nonce_field( 'ri_save_action', 'ri_nonce' ); ?>

        <table class="form-table">

            <!-- Address Line -->
            <tr>
                <th>
                    <label for="ri_address_line">
                        Address Line <span style="color:red;">*</span>
                    </label>
                </th>
                <td>
                    <input type="text"
                           id="ri_address_line"
                           name="ri_address_line"
                           class="regular-text"
                           value="<?php echo ri_field( $info, 'address_line' ); ?>"
                           placeholder="Restoria, Arrondissement"
                           required>
                </td>
            </tr>

            <!-- Address City -->
            <tr>
                <th>
                    <label for="ri_address_city">
                        Address City <span style="color:red;">*</span>
                    </label>
                </th>
                <td>
                    <input type="text"
                           id="ri_address_city"
                           name="ri_address_city"
                           class="regular-text"
                           value="<?php echo ri_field( $info, 'address_city' ); ?>"
                           placeholder="Paris 9578"
                           required>
                </td>
            </tr>

            <!-- Lunch Time -->
            <tr>
                <th>Lunch Time <span style="color:red;">*</span></th>
                <td>
                    <input type="text"
                           id="ri_lunch_start"
                           name="ri_lunch_start"
                           
                           value="<?php echo ri_field( $info, 'lunch_start' ); ?>"
                           placeholder="10.00 am"
                           required>

                    &nbsp;—&nbsp;

                    <input type="text"
                           id="ri_lunch_end"
                           name="ri_lunch_end"
                          
                           value="<?php echo ri_field( $info, 'lunch_end' ); ?>"
                           placeholder="3:30 pm"
                           required>

                    <p class="description">Start time — End time</p>
                </td>
            </tr>

            <!-- Dinner Time -->
            <tr>
                <th>Dinner Time <span style="color:red;">*</span></th>
                <td>
                    <input type="text"
                           id="ri_dinner_start"
                           name="ri_dinner_start"
                           
                           value="<?php echo ri_field( $info, 'dinner_start' ); ?>"
                           placeholder="08.00 pm"
                           required>

                    &nbsp;—&nbsp;

                    <input type="text"
                           id="ri_dinner_end"
                           name="ri_dinner_end"
                          
                           value="<?php echo ri_field( $info, 'dinner_end' ); ?>"
                           placeholder="10:30 pm"
                           required>

                    <p class="description">Start time — End time</p>
                </td>
            </tr>

            <!-- Email -->
            <tr>
                <th>
                    <label for="ri_email">
                        Booking Email <span style="color:red;">*</span>
                    </label>
                </th>
                <td>
                    <input type="email"
                           id="ri_email"
                           name="ri_email"
                           class="regular-text"
                           value="<?php echo ri_field( $info, 'email' ); ?>"
                           placeholder="booking@domainame.com"
                           required>
                </td>
            </tr>

            <!-- Booking Phone -->
            <tr>
                <th>
                    <label for="ri_booking_phone">
                        Booking Phone <span style="color:red;">*</span>
                    </label>
                </th>
                <td>
                    <input type="text"
                           id="ri_booking_phone"
                           name="ri_booking_phone"
                           class="regular-text"
                           value="<?php echo ri_field( $info, 'booking_phone' ); ?>"
                           placeholder="+88-123-123456"
                           required>
                </td>
            </tr>
                  <!-- Restaurant Image -->
<tr>
    <th><label>Restaurant Image</label></th>
    <td>
        <input type="hidden"
               id="ri_image_id"
               name="ri_image_id"
               value="<?php echo ri_field( $info, 'image_id', '0' ); ?>">

        <div id="ri_image_preview">
            <?php if ( $info && $info->image_id ) : ?>
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $info->image_id, 'thumbnail' ) ); ?>"
                     style="max-width:150px; display:block; margin-bottom:8px;">
            <?php endif; ?>
        </div>

        <button type="button" class="button" id="ri_image_btn">
            <?php echo ( $info && $info->image_id ) ? 'Change Image' : 'Upload Image'; ?>
        </button>

        <?php if ( $info && $info->image_id ) : ?>
            <button type="button" class="button" id="ri_image_remove">
                Remove
            </button>
        <?php endif; ?>
    </td>
</tr>
        </table>

        <?php submit_button( 'Save Restaurant Info', 'primary', 'ri_form_submit' ); ?>

    </form>

</div>