    
    function orientation() {
        let currentOrientation = window.innerHeight > window.innerWidth ? 'portrait' : 'landscape';
        
        let autoRotate = window.devMode || (window.innerWidth < 1000 && currentOrientation == 'portrait');
        
        if(autoRotate) {
          let image = $('#the-photo'); 
          
          let originImageWidth = image.width();
          let originImageHeight = image.height();
          let aspectRatio = originImageWidth/originImageHeight;
          image.data("aspect-ratio", aspectRatio);
    
          if( aspectRatio > 1 && currentOrientation === 'portrait' ) {
              // Image is landscape, so rotate it
              image.addClass('rotate');
              $('#the-photo-link').width(originImageHeight * aspectRatio);
              $('#the-photo-link').height(originImageWidth * aspectRatio);
              image.width(originImageWidth * aspectRatio);
              image.height(originImageHeight * aspectRatio);
              image.css('top', (originImageWidth * (aspectRatio - 1))/2 );
              image.css('left', (originImageWidth * (1 - aspectRatio))/2 );
              
          } 
          if (aspectRatio < 1 && currentOrientation === 'landscape') {
              // Image is portrait, rotate it to landscape and scale it
              image.addClass('rotate');
              $('#the-photo-link').height(originImageWidth * aspectRatio);
              image.width(originImageWidth * aspectRatio);
              image.height(originImageHeight * aspectRatio);
              image.css('top', (originImageWidth * (aspectRatio-1))/2 );
          }
        }
    
        //document.getElementById('the-photo').scrollIntoView();
    }
  