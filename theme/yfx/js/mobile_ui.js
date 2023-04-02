jQuery(function() {
    var winWidth = jQuery(window).width();
    var mobileWidth = 760;


    function getAdWidth() {
        var winWidth = jQuery(window).width();
        var adWidth = winWidth >= 999 ? 370 : 185;
        adWidth = winWidth <= 600 ? 0 : adWidth;
        return adWidth;
    }
    //jQuery('.layout-3col__left-content').width(jQuery(window).width() - getAdWidth());

    jQuery('#buttonSearch').click(function() {
        jQuery('#h-middle').toggle();
        jQuery('#h-middle input[name="op"]').val('Search');
    });

    if (winWidth <= mobileWidth) {
        jQuery('#quick-nav').click(function() {
            jQuery('.main-menu').toggle();
        });

        jQuery(document).on('click', function(e) {
            var container = jQuery('.main-menu');
            var triggers = jQuery('#quick-nav, #quick-nav img');
            if (!triggers.is(e.target) && !container.is(e.target)) {
                container.hide();
            }
        });

        jQuery(document).on('scroll', function(e) {
            jQuery('.main-menu').hide();
        });
    }

    jQuery('.main-menu a[href*="http://www.javcook.com"]').attr('target', '_blank');

    jQuery('.lazy').lazy();

    jQuery(window).resize(function () {
        var winW = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (winW > mobileWidth) {
            jQuery('.main-menu').show();
            jQuery(document).on('scroll', function (e) {
              jQuery('.main-menu').show();
            });
        }
        else {
            jQuery('.main-menu').hide();
            jQuery(document).on('scroll', function (e) {
              jQuery('.main-menu').hide();
            });
        }
    });

});