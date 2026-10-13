(function ($) {

    // ── Profile Image ──────────────────────
    var profileFrame;

    $('#chef_profile_image_btn').on('click', function (e) {
        e.preventDefault();

        if (profileFrame) {
            profileFrame.open();
            return;
        }

        profileFrame = wp.media({
            title   : 'Select Profile Image',
            button  : { text: 'Use This Image' },
            multiple: false
        });

        profileFrame.on('select', function () {
            var attachment = profileFrame.state().get('selection').first().toJSON();
            $('#chef_profile_image_id').val(attachment.id);
            $('#chef_profile_image_preview').html(
                '<img src="' + attachment.url + '" style="max-width:150px; display:block; margin-bottom:8px;">'
            );
            $('#chef_profile_image_btn').text('Change Profile Image');
        });

        profileFrame.open();
    });

    $('#chef_profile_image_remove').on('click', function (e) {
        e.preventDefault();
        $('#chef_profile_image_id').val('0');
        $('#chef_profile_image_preview').html('');
        $('#chef_profile_image_btn').text('Upload Profile Image');
    });


    // ── Hover Image ────────────────────────
    var hoverFrame;

    $('#chef_hover_image_btn').on('click', function (e) {
        e.preventDefault();

        if (hoverFrame) {
            hoverFrame.open();
            return;
        }

        hoverFrame = wp.media({
            title   : 'Select Hover Image',
            button  : { text: 'Use This Image' },
            multiple: false
        });

        hoverFrame.on('select', function () {
            var attachment = hoverFrame.state().get('selection').first().toJSON();
            $('#chef_hover_image_id').val(attachment.id);
            $('#chef_hover_image_preview').html(
                '<img src="' + attachment.url + '" style="max-width:150px; display:block; margin-bottom:8px;">'
            );
            $('#chef_hover_image_btn').text('Change Hover Image');
        });

        hoverFrame.open();
    });

    $('#chef_hover_image_remove').on('click', function (e) {
        e.preventDefault();
        $('#chef_hover_image_id').val('0');
        $('#chef_hover_image_preview').html('');
        $('#chef_hover_image_btn').text('Upload Hover Image');
    });

})(jQuery);