jQuery(document).ready(function ($) {

    $('#restaurantBookingForm').on('submit', function (e) {
        e.preventDefault();

        var $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('Booking...');

        $.ajax({
            url: booking_ajax.ajax_url,
            type: 'POST',
            data: {
                action:  'submit_booking',
                nonce:   booking_ajax.nonce,
                name:    $('#bookingName').val(),
                phone:   $('#bookingPhone').val(),
                persons: $('#bookingPersons').val(),
                date:    $('#bookingDate').val(),
                time:    $('#bookingTime').val(),
                message: $('#bookingMessage').val(),
            },
            success: function (response) {
                if (response.success) {
                    $('#bookingResponse').html(
                        '<p style="color:green;">' + response.data.message + '</p>'
                    );
                    $('#restaurantBookingForm')[0].reset();
                } else {
                    $('#bookingResponse').html(
                        '<p style="color:red;">' + response.data.message + '</p>'
                    );
                }
            },
            error: function () {
                $('#bookingResponse').html(
                    '<p style="color:red;">Something went wrong. Please try again.</p>'
                );
            },
            complete: function () {
                $btn.prop('disabled', false).text('Book a Table');
            }
        });
    });

});