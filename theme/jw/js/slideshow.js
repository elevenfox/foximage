(function($) {
    let theURL = window.location.href;
    
    if(theURL.includes('ppt=1')) {
        $(document).ready(function(){
            $("#auto-play").trigger("click");
        });
    }


    let x =1;
    $('#auto-play').on('click', function() {
        if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'auto_play','value':null});
          
        if( !theURL.includes('ppt=1')) {
            if(theURL.includes('?')) {
                let queryString = theURL.slice(theURL.indexOf('?') + 1);
                //theURL = theURL + '&ppt=1';
                param = '?' + queryString + '&ppt=1';
            }
            else {
                //theURL = theURL + '?ppt=1';
                param = '?ppt=1';
            }
            window.history.replaceState(null, null, param);
        }
        
        // Show the canvas
        $('body').append($('<div/>', {id: 'fdp-photo' }));

        // The slideshow control buttons
        let btns = `
            <div class="fdp-random-btns">
                <a href="#" id="close_ppt" class="glyphicon glyphicon-remove" title="Quit">&times;</a>
                <span class="fdp-random-count-down">20</span>
                <a href="#" class="fdp-random-previous" title="Previous">
                    <svg style="height: 14px;-webkit-transform: scaleX(-1);transform: scaleX(-1);" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20.465 20.465" xml:space="preserve"><g id="c91_rewind"><path d="M9.112,1.372c0.139-0.069,0.303-0.049,0.424,0.045l10.776,8.501c0.094,0.076,0.153,0.191,0.153,0.312s-0.06,0.24-0.153,0.314L9.536,19.047c-0.071,0.056-0.163,0.088-0.248,0.088l-0.176-0.042c-0.138-0.064-0.226-0.204-0.226-0.359V1.732C8.887,1.58,8.975,1.437,9.112,1.372z"/><path d="M0.225,1.372C0.364,1.303,0.529,1.323,0.65,1.417l10.776,8.501c0.093,0.076,0.152,0.191,0.152,0.312s-0.06,0.24-0.152,0.314L0.649,19.047c-0.073,0.056-0.163,0.088-0.249,0.088l-0.176-0.042C0.088,19.028,0,18.889,0,18.733V1.732C0,1.58,0.088,1.437,0.225,1.372z"/></g></svg>
                </a>
                <a href="#" class="fdp-random-pause glyphicon glyphicon-pause" title="Pause"></a>
                <a href="#" class="fdp-random-next" title="Next">
                    <svg style="height: 14px" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20.465 20.465" xml:space="preserve"><g id="c91_rewind"><path d="M9.112,1.372c0.139-0.069,0.303-0.049,0.424,0.045l10.776,8.501c0.094,0.076,0.153,0.191,0.153,0.312s-0.06,0.24-0.153,0.314L9.536,19.047c-0.071,0.056-0.163,0.088-0.248,0.088l-0.176-0.042c-0.138-0.064-0.226-0.204-0.226-0.359V1.732C8.887,1.58,8.975,1.437,9.112,1.372z"/><path d="M0.225,1.372C0.364,1.303,0.529,1.323,0.65,1.417l10.776,8.501c0.093,0.076,0.152,0.191,0.152,0.312s-0.06,0.24-0.152,0.314L0.649,19.047c-0.073,0.056-0.163,0.088-0.249,0.088l-0.176-0.042C0.088,19.028,0,18.889,0,18.733V1.732C0,1.58,0.088,1.437,0.225,1.372z"/></g></svg>
                </a>
                <span id="fdp-title"><a></a></span>
            </div>
        `;
        $('#fdp-photo').append($(btns));

        // Loading
        $('#fdp-photo').append($('<div/>', {id: 'loading'}));

        // Click area
        let clickArea = `
        <div class="fdp-click-area">
            <span class="fdp-click-area-left"  title="previous"></span>
            <span class="fdp-click-area-right" title="next"></span>
        </div>
        `;
        $('#fdp-photo').append($(clickArea));

        $('body').css('overflow', 'hidden');

        let num = 1;
        let total = 1;
        let domObj = $(this);
        
        let data = domObj.attr('data');
        let tmpArr = data.split("----");
        let type = tmpArr[0];
        let value = tmpArr[1];
        num = domObj.attr('num');
        total = domObj.attr('total');
        
        const showingSeconds = 20;
        let seconds = 20;
        let history = [];
        
        
        // Handle setInterval and setTimeout
        let timeoutCallback = function() {
            $('#loading').show();
            let endpoint = '';
            switch(type) {
                case 'album':
                    endpoint = '/api/?ac=get_album_images&id=' + value + '&num=' + num;
                    num++;
                    if(num == total) num = 1;
                    break;
                case 'tag':
                    endpoint = '/api/?ac=get_random_photo_by_tag&tag=' + value;
                    break;
                case 'search':
                    endpoint = '/api/?ac=get_random_photo_by_search&keywords=' + value;
                    break;    
                default:
                    break;
            }
            // Call API to get image src
            $.get(endpoint, function(resp) {
                if(resp.src) {
                    history.push(resp);
                    renderPhoto(resp.src, resp.title, resp.url);
                }
            });
            
        };

        let renderPhoto = (src, title, url) => {
            $('#the-photo').remove();
            $('#fdp-photo').append($('<img/>', {id: 'the-photo'}));
            $('#the-photo').attr('src',src);
            $('#the-photo').attr('title',title);
            $('#fdp-title a').text(title);
            $('#fdp-title a').attr('href', url);
            
            $('#the-photo').on('load', function(){
                $('#loading').hide();
                orientation();
            });
            seconds = showingSeconds;
        };
        
        timeoutCallback();

        let intervalCallback = function() {
            seconds = seconds - 1;
            $('.fdp-random-count-down').text(seconds);
            if(seconds <= 0) {
		seconds = showingSeconds;
                timeoutCallback();
            }
        };
        let itv = setInterval(intervalCallback, 1000);

        let pauseItv = () => {
            window.clearInterval(itv);
            $('.fdp-random-pause').removeClass('glyphicon-pause');
            $('.fdp-random-pause').addClass('glyphicon-play');
        };
        let startItv = () => {
            window.clearInterval(itv);
            $('.fdp-random-pause').removeClass('glyphicon-play');
            $('.fdp-random-pause').addClass('glyphicon-pause');
            itv = setInterval(intervalCallback, 1000);
        };
        $('.fdp-random-pause').on('click', function(e) {
            e.preventDefault();
            
            if($('.fdp-random-pause').hasClass('glyphicon-pause')) {
                if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'pause','value':null});
                pauseItv();
            }
            else {
                if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'start','value':null});
                startItv();
            }
        });


        const previous = (e) => {
            e.preventDefault();
            if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'previous','value':null});
            pauseItv();
            if(history.length <= 0) {
                alert("No previous photo.");
            }
            else {
                let currentSrc = $('#the-photo').attr('src');
                let resp = history.pop();
                if(resp.src == currentSrc) {
                    resp = history.pop();
                }
                renderPhoto(resp.src, resp.title, resp.url);
            }
            startItv();
        }
        $('.fdp-random-previous').on('click', (e)=>previous(e));
        $('#fdp-photo .fdp-click-area-left').on('click', (e)=>previous(e));

        const next = (e) => {
            e.preventDefault();
            if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'next','value':null});
            pauseItv();
            timeoutCallback();
            startItv();
        };
        $('.fdp-random-next').on('click', (e)=>next(e));
        $('#fdp-photo .fdp-click-area-right').on('click', (e)=>next(e));

        $('#close_ppt').on('click', function(e) {
            e.preventDefault();
            if(typeof gtag !== 'undefined') gtag('event','click',{'event_category':'slideshow','event_label':'close','value':null});
            pauseItv();
            $('#fdp-photo').remove();
            $('body').css('overflow', 'auto');
            // window.location.href=theURL;
        });

    });

    function orientation() {
        let currentOrientation = window.innerHeight > window.innerWidth ? 'portrait' : 'landscape';
        
        //let autoRotate = window.innerWidth < 1000;
        let autoRotate = true;
        
        if(autoRotate) {
          let image = $('#the-photo'); 
          
          let originImageWidth = image.width();
          let originImageHeight = image.height();
          let aspectRatio = originImageWidth/originImageHeight;
          image.data("aspect-ratio", aspectRatio);
    
          if( aspectRatio > 1 && currentOrientation === 'portrait' ) {
              // Image is landscape, so rotate it
              image.addClass('rotate');
              image.width(Math.floor(aspectRatio * 100) + '%');
              //image.height(Math.floor(aspectRatio * 100) + '%');
              image.css('top', (originImageWidth * (aspectRatio - 1))/2 );
              image.css('left', (originImageWidth * (1 - aspectRatio))/2 );
              
          } 
          if (aspectRatio < 1 && currentOrientation === 'landscape') {
              // Image is portrait, rotate it to landscape and scale it
              image.addClass('rotate');
              image.width(originImageWidth * aspectRatio);
              //image.height(originImageHeight * aspectRatio);
              image.css('top', (originImageWidth * (aspectRatio-1))/2 );
          }
          x++;
        }
    }
})(jQuery);


