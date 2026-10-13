(function ($) {

    var vsFrame;

    $('#vs_video_btn').on('click', function (e) {
        e.preventDefault();

        if (vsFrame) {
            vsFrame.open();
            return;
        }

        vsFrame = wp.media({
            title    : 'Select or Upload Video',
            button   : { text: 'Use This Video' },
            multiple : false,
            library  : { type: 'video' }   // ← Show only video files
        });

        vsFrame.on('select', function () {
            var attachment = vsFrame.state().get('selection').first().toJSON();
            $('#vs_video_id').val(attachment.id);
            $('#vs_video_preview').html(
                '<video width="320" height="180" controls style="display:block; margin-bottom:8px;">' +
                '<source src="' + attachment.url + '" type="' + attachment.mime + '">' +
                '</video>'
            );
            $('#vs_video_btn').text('Change Video');
        });

        vsFrame.open();
    });

    // ── Remove Video ──────────────────────
    $('#vs_video_remove').on('click', function (e) {
        e.preventDefault();
        $('#vs_video_id').val('0');
        $('#vs_video_preview').html('');
        $('#vs_video_btn').text('Upload Video');
    });

})(jQuery);