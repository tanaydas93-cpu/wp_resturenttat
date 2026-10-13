jQuery(document).ready(function ($) {

    $('#commentForm').on('submit', function (e) {

        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: comment_ajax.ajax_url,
            type: 'POST',
            data: formData + '&action=submit_blog_comment',

            beforeSend: function () {
                $('#comment-response').html('Submitting...');
            },

            success: function (response) {

                if (response.success) {

                    $('#comment-response').html(
                        '<div class="success-msg">' +
                        response.data.message +
                        '</div>'
                    );

                    $('#commentForm')[0].reset();

                } else {

                    $('#comment-response').html(
                        '<div class="error-msg">' +
                        response.data.message +
                        '</div>'
                    );
                }
            },

            error: function () {

                $('#comment-response').html(
                    '<div class="error-msg">Server error occurred.</div>'
                );
            }
        });
    });
});