/* -------------------------------------------------------------------
 * Plugin Name           : Niwax - Php Ajax Modern Contact Form
 * Author Name           : Rajesh Doot
 * File Name             : main.js
------------------------------------------------------------------- */

(function ($) {
    "use strict";

$(document).ready(function() {
    // validate form on keyup and submit
    $("#contactform").validate({
        rules: {
            fullname: "required",
            mobile_number: {
                required: true,
                digits: true,
                /*minlength: 10,
                maxlength: 10,*/ 
            },
            interested_in: "required",
            email: {
                required: true,
                email: true
            },
            your_location: "required",
            skype_whatsapp_no: "required",
            description: "required",
            agree: "required"
        },
        // form error message (notify your visitor about their mistake)
        messages: {
            fullname: "Please enter your name",
            mobile_number: {
                required: "Please enter a valid mobile number",
                digits: "Only numbers allowed 0-9",
               /* minlength: "At least 10 Numbers",
                maxlength: "Not more than 10 Numbers"*/
            },
            email: "Please enter a valid email address",
            interested_in: "Please select your interest",
            agree: "Please accept terms and conditions",
            your_location: "Please enter your location",
            skype_whatsapp_no: "Please provide Skype/Whatsapp No.",
            description: "Please brief about your project"
        },
        errorPlacement: function(error, element) {
            var newelement = element.next('label').next('div');
            newelement.html(error);
        },
        submitHandler: function() {
            $(':input[type="submit"]').prop('disabled', true);
            $('.loader').addClass('loader-icon');
            let formData = new FormData($('#contactform')[0]);
            $.ajax({
                url: "phpmailer/email/send.php",
                type: "POST",
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    console.log(result);
                    if (result.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonText: 'Thank You'
                        })
                        $("#contactform")[0].reset();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        });
                    }
                    $('.loader').removeClass('loader-icon');
                    $(':input[type="submit"]').prop('disabled', false);
                },
                error: function(msg) {
                    console.log('error', msg);
                    $('.loader').removeClass('loader-icon');
                    $(':input[type="submit"]').prop('disabled', false);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Oops! An error occurred, please try again later.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                }
            });
        }
    });

    $('.floating-input, .floating-select, .ctminpt').on('focusout', function() {
        $(this).valid();
    });
});


// end of js
})(jQuery);