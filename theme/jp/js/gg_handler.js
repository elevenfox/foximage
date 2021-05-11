jQuery(function () {
  'use strict';

  var maInterval = null;
  function moveAds(flag) {
    if ($(".all-tags-page")[0]){
      // if it's all-tag-page, don't move ads around
    }
    else {
      if (maInterval === null) {
        maInterval = setInterval(function () {
          moveAds(flag);
        }, 500);
      }
      else {
        if (
          jQuery('#block-ads-jp-right-sidebar-ad-1 > div > div').length > 0
          && jQuery('#block-ads-jp-right-sidebar-ad-2 > div > div').length > 0
          && jQuery('#block-ads-jp-right-sidebar-ad-3 > div > div').length > 0
        ) {
          var newAdClass = 'm-block-ad';
          if (flag) {
            // var a1 = jQuery('#block-ads-jp-right-sidebar-ad-1').html();
            // var a2 = jQuery('#block-ads-jp-right-sidebar-ad-2').html();
            // var a3 = jQuery('#block-ads-jp-right-sidebar-ad-3').html();
            var a1 = jQuery('#block-ads-jp-right-sidebar-ad-1').clone();
            var a2 = jQuery('#block-ads-jp-right-sidebar-ad-2').clone();
            var a3 = jQuery('#block-ads-jp-right-sidebar-ad-3').clone();

            var ads = [a1, a2];

            var allVideoTeasers = jQuery('article.node-teaser');
            if (allVideoTeasers.length > 4) {
              var i = 0;
              var j = 0;
              jQuery.each(allVideoTeasers, function (key, teaser) {
                i++;
                if (i % 4 === 0) {
                  if (jQuery(teaser).find('div.' + newAdClass).length === 0) {

                    //jQuery(teaser).append('<div class="' + newAdClass + ' ad-' + (j+1) + '">' + ads[j] + '</div>');
                    jQuery(teaser).append('<div class="' + newAdClass + ' ad-' + (j+1) + '">' + ads[j].html() + '</div>');

                    j++;
                  }
                  j = (j >= ads.length) ? 0 : j;
                }
              });
            }
          }
          else {
            jQuery('.' + newAdClass).remove();
          }
          clearInterval(maInterval);
        }
      }
    }
  }

  // Is mobile
  var winW = (window.innerWidth > 0) ? window.innerWidth : screen.width;

  // if(window.matchMedia('(max-device-width: 565px)').matches) {
  if (winW <= 565) {
    moveAds(true);
  }
  else {
    moveAds(false);
  }

  jQuery(window).resize(function () {
    var winW = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if (winW <= 565) {
      moveAds(true);
    }
    else {
      moveAds(false);
    }
  });
});
