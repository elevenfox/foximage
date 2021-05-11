jQuery(function () {
  'use strict';
  var intervalPointer = null;
  var videoThumbSrc = null;
  var thumbObj = null;
  var gifPreviewImages = [];
  var gifImgCounter = 0;
  var gifSpriteLength = 0;
  var gifDirection = null;
  var gifImgRow = 0;
  var gifImgCol = 0;
  var gifFormat = null;
  var xOffset = 0;
  var yOffset = 0;

  jQuery('.teaser-thumbnail').hover(
    function () {
      thumbObj = jQuery(this).find('img');
      xOffset = thumbObj.width();
      yOffset = thumbObj.height();
      videoThumbSrc = thumbObj.attr('src');
      var gifDom = jQuery(this).attr('gif-preview');
      gifPreviewImages = gifDom ? gifDom.split(',') : gifPreviewImages;
      gifSpriteLength = parseInt(jQuery(this).attr('gif-count'));
      gifDirection = jQuery(this).attr('gif-direction');
      gifFormat = jQuery(this).attr('gif-format');
      if (gifPreviewImages.length > 0) {
        changeThumb();
        intervalPointer = setInterval(changeThumb, 500);
      }
    },
    function () {
      if (gifPreviewImages && gifPreviewImages.length > 0) {
        clearInterval(intervalPointer);
        thumbObj.attr('src', videoThumbSrc);
        if (gifSpriteLength > 0) {
          thumbObj.parent().css('background', 'none');
        }
        videoThumbSrc = null;
        thumbObj = null;
        gifPreviewImages = null;
        gifImgCounter = 0;
        gifSpriteLength = 0;
        gifDirection = null;
        gifFormat = null;
        gifImgRow = 0;
        gifImgCol = 0;
      }
    }
  );
  function changeThumb() {
    if (gifSpriteLength > 0) {
      thumbObj.attr('src', '/images/img_trans.gif');
      thumbObj.parent().css('background', 'url("' + gifPreviewImages[0] + '") no-repeat');
      if (gifDirection === 'v') {
        thumbObj.parent().css('background-size', '100% auto');
        thumbObj.parent().css('background-position', '0 -' + xOffset / 240 * 135 * gifImgCounter + 'px');
      }
      else {
        thumbObj.parent().css('background-size', 'auto 100%');
        thumbObj.parent().css('background-position', '-' + xOffset * gifImgCounter + 'px, 0');
      }

      gifImgCounter++;
      if (gifImgCounter === gifSpriteLength) {
        gifImgCounter = 0;
      }
    }
    else {
      if (gifFormat != null) {
        var zoom = 500;
        thumbObj.attr('src', '/images/img_trans.gif');
        thumbObj.parent().css('background', 'url("' + gifPreviewImages[0] + '") no-repeat');
        thumbObj.parent().css('background-size', zoom + '% ' + zoom + '%');
        thumbObj.parent().css('background-position', '-' + xOffset * gifImgRow + 'px -' + yOffset * gifImgCol + 'px');
        gifImgCounter++;
        gifImgCol++;
        if (gifImgCounter % 5 === 0) {
          gifImgRow++;
          gifImgCol = 0;
        }
        if (gifImgCounter === 25) {
          gifImgCounter = 0;
          gifImgCol = 0;
          gifImgRow = 0;
        }
      }
      else {
        thumbObj.attr('src', gifPreviewImages[gifImgCounter]);
        gifImgCounter++;
        if (gifImgCounter === gifPreviewImages.length) {
          gifImgCounter = 0;
        }
      }
    }
  }
});
