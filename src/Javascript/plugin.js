jQuery(document).ready(function($) {
    /**
     * ------------------------------------------------------------------
     * Contact Form 7
     * ------------------------------------------------------------------
     */
    // initialise plugin
    $("#mobile-number").intlTelInput({
        preferredCountries: [],
        defaultCountry: "auto",
        nationalMode: true,
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.9/js/utils.js",
        geoIpLookup: function(callback) {
            $.ajax({
                url: wpjs.ajax_url,
                data: {
                    action: 'get_ipinfo'
                },
                cache: false,
                success: function(data) {
                    var obj = $.parseJSON(data);
                    callback(obj.country);
                },
                error: function() {
                    var x = "IE";
                    callback(x);
                }
            });
        }
    });

    $("#registerform, #your-profile, #resendSMS, #loginformaddphone").submit(function() {
        if (!$("#mobile-number").intlTelInput("isValidNumber")) {

            $("#mobile-validation").val(
                $("#mobile-number").intlTelInput("getValidationError")
            );
        }

        if ($("#mobile-number").val() !== '' ){
            $("#hidden-phone").val(
                $("#mobile-number").intlTelInput("getNumber")
            );
        }
    });

    $('#2fa-activation').on('change',function(){
        if($('#2fa-activation').prop('checked')) {
            $('#2faSection').css('display', 'block');
        } else {
            $('#2faSection').css('display', 'none');
        }
    });
});
