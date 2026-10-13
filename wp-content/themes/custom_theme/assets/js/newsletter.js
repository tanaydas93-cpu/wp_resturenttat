(function ($) {

    $(document).on('submit', '#ns-newsletter-form', function (e) {

        // Only handle forms that have an email input (newsletter form)
        var $form  = $(this);
        var $input = $form.find('input[name="email"]');

        if ( $input.length === 0 ) {
            return; // Not our form, let it submit normally
        }

        e.preventDefault();

        var email      = $input.val().trim();
        var $button    = $form.find('button[type="submit"]');
        var $msg       = $form.find('.ns-message');

        // Create message container if not exists
        if ( $msg.length === 0 ) {
            $form.append('<div class="ns-message" style="margin-top:10px;"></div>');
            $msg = $form.find('.ns-message');
        }

        // Basic validation
        if ( email === '' ) {
            $msg.text('Please enter your email.').css('color', 'red');
            return;
        }

        // Disable button during request
        $button.prop('disabled', true);
        $msg.text('Subscribing...').css('color', '#666');

        $.ajax({
            url      : ns_ajax_obj.ajax_url,
            type     : 'POST',
            dataType : 'json',
            data     : {
                action : 'ns_subscribe',
                email  : email,
                nonce  : ns_ajax_obj.nonce
            },
            success: function (response) {

                if ( response.success ) {
                    $msg.text(response.data.message).css('color', 'green');
                    $input.val(''); // Clear input on success
                } else {
                    $msg.text(response.data.message).css('color', 'red');
                }
            },
            error: function () {
                $msg.text('Something went wrong. Please try again.').css('color', 'red');
            },
            complete: function () {
                $button.prop('disabled', false);
            }
        });

    });

})(jQuery);