jQuery(function() {
    var mobileWidth = 777;

    jQuery('#buttonSearch').click(function() {
        jQuery('#h-middle-m').toggle();
        jQuery('#h-middle-m input[name="op"]').val('Search');
    });

    jQuery('#quick-nav').click(function() {
        jQuery('.main-menu').toggleClass('mobile_hide');
    });

    jQuery(document).on('click', function(e) {
        var container = jQuery('.main-menu');
        var triggers = jQuery('#quick-nav, #quick-nav img');
        if (!triggers.is(e.target) && !container.is(e.target)) {
            container.addClass("mobile_hide");
        }
    });

    jQuery(document).on('scroll', function(e) {
        jQuery('.main-menu').addClass('mobile_hide');
    });

});