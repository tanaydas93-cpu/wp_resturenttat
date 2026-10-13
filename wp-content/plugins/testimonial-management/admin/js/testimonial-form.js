

(function ($) {

    // ── Author Image ──────────────────────
    var tmFrame;
         
    $('#tm_image_btn').on('click', function (e) {
        e.preventDefault();
                       
        console.log('clicked');
     
        if (tmFrame) {
            tmFrame.open();
            return;
        }

        tmFrame = wp.media({
            title   : 'Select Author Image',
            button  : { text: 'Use This Image' },
            multiple: false
        });

        tmFrame.on('select', function () {
            var attachment = tmFrame.state().get('selection').first().toJSON();
            $('#tm_image_id').val(attachment.id);
            $('#tm_image_preview').html(
                '<img src="' + attachment.url + '" style="max-width:100px; display:block; margin-bottom:8px; border-radius:50%;">'
            );
            $('#tm_image_btn').text('Change Image');
        });

        tmFrame.open();
    });

    // ── Remove Image ──────────────────────
    $('#tm_image_remove').on('click', function (e) {
        e.preventDefault();
        $('#tm_image_id').val('0');
        $('#tm_image_preview').html('');
        $('#tm_image_btn').text('Upload Image');
    });

})(jQuery);