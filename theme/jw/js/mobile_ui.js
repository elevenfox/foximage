jQuery(function() {
    'use strict';

    //var mobileWidth = 777;
    var mobileWidth = 565;
  
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


    moveAdsAction();

    jQuery(window).resize(function () {
        moveAdsAction();
    });


    
    /***** functions *****/
    function moveAdsAction() {
        // if(window.matchMedia('(max-device-width: 565px)').matches) {
        if (getWinWidth() <= mobileWidth) {
            setTimeout(()=>{moveAds(true)}, 500);
        }
        else {
            setTimeout(()=>{moveAds(false)}, 500);
        }   
    }
    function getWinWidth() {
        return (window.innerWidth > 0) ? window.innerWidth : screen.width;
    }
    function moveAds(flag) {
        if ($(".all-tags-page")[0]){
          // if it's all-tag-page, don't move ads around
        }
        else {
            if (
              jQuery('#block-ads-right-sidebar-ad-1').length > 0
              && jQuery('#block-ads-right-sidebar-ad-2').length > 0
              && jQuery('#block-ads-right-sidebar-ad-3').length > 0
            ) {
              var newAdClass = 'm-block-ad';
              
              // var a1 = jQuery('#block-ads-jp-right-sidebar-ad-1').html();
              // var a2 = jQuery('#block-ads-jp-right-sidebar-ad-2').html();
              // var a3 = jQuery('#block-ads-jp-right-sidebar-ad-3').html();
              // var a1 = jQuery('#block-ads-right-sidebar-ad-1').clone();
              // var a2 = jQuery('#block-ads-right-sidebar-ad-2').clone();
              // var a3 = jQuery('#block-ads-right-sidebar-ad-3').clone();
              var a1 = jQuery('#block-ads-right-sidebar-ad-1');
              var a2 = jQuery('#block-ads-right-sidebar-ad-2');
              var a3 = jQuery('#block-ads-right-sidebar-ad-3');
              var ads = [a1, a2, a3];
    
              if (flag) {
                var allFileTeasers = jQuery('article.node-teaser');
                if (allFileTeasers.length > 4) {
                  var i = 0;
                  var j = 0;
                  jQuery.each(allFileTeasers, function (key, teaser) {
                    i++;
                    if (i % 4 === 0) {
                      if (jQuery(teaser).parent().find('div.' + newAdClass+ '-' + (j+1)).length === 0) {
                        ads[j].addClass('mobile-only');
                        ads[j].addClass(newAdClass+ '-' + (j+1));
                        //jQuery(teaser).append('<div class="' + newAdClass + ' ad-' + (j+1) + '">' + ads[j] + '</div>');
                        //jQuery(teaser).after('<div class="' + newAdClass + ' ad-' + (j+1) + '">' + ads[j].html() + '</div>');
                        ads[j].detach().insertAfter(jQuery(teaser));
    
                        j++;
                      }
                      j = (j >= ads.length) ? 0 : j;
                    }
                  });
                }
              }
              else {
                ads.forEach((ad) => {
                  if(ad.hasClass('mobile-only')) {
                    ad.removeClass('mobile-only');
                    ad.detach().insertBefore(jQuery("#block-ads-right-sidebar-ad-v"));
                  }
                });
              }
          }
        }
    }
});