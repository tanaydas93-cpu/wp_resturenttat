(function ($) {

    var riFrame;

    $('#ri_image_btn').on('click', function (e) {
        e.preventDefault();

        if (riFrame) {
            riFrame.open();
            return;
        }

        riFrame = wp.media({
            title   : 'Select Restaurant Image',
            button  : { text: 'Use This Image' },
            multiple: false
        });

        riFrame.on('select', function () {
            var attachment = riFrame.state().get('selection').first().toJSON();
            $('#ri_image_id').val(attachment.id);
            $('#ri_image_preview').html(
                '<img src="' + attachment.url + '" style="max-width:150px; display:block; margin-bottom:8px;">'
            );
            $('#ri_image_btn').text('Change Image');
        });

        riFrame.open();
    });

    $('#ri_image_remove').on('click', function (e) {
        e.preventDefault();
        $('#ri_image_id').val('0');
        $('#ri_image_preview').html('');
        $('#ri_image_btn').text('Upload Image');
    });

})(jQuery);