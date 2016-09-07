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

    // on blur: validate
    $("#mobile-number").blur(function() {
        if ($.trim($("#mobile-number").val())) {
            if ($("#mobile-number").intlTelInput("isValidNumber")) {
                $("#valid-msg-mobile").removeClass("hide");
                $('input[name="mobile-number-error"]').remove();
                $("#mobile-number").removeClass('wpcf7-not-valid');
                $("span.wpcf7-not-valid-tip",".wpcf7-form-control-wrap.mobile_number").remove();
            } else {
                $("#mobile-number").addClass("error");
                $("#error-msg-mobile").removeClass("hide");
                $("#valid-msg-mobile").addClass("hide");
                if ($("#mobile-number-error").length === 0) {
                    $('<input id="mobile-number-error" type="hidden" name="mobile-number-error" value="1">').insertAfter("#mobile-number");
                }
            }
        }
    });

    // on keydown: reset
    $("#mobile-number").keydown(function() {
        $("#mobile-number").removeClass("error");
        $("#error-msg-mobile").addClass("hide");
        $("#valid-msg-mobile").addClass("hide");
    });

    $(".flag-dropdown").click(function() {
        $("#mobile-number").removeClass("error");
        $("#error-msg-mobile").addClass("hide");
        $("#valid-msg-mobile").addClass("hide");
    });
});
