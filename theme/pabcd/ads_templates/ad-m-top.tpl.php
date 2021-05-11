<?php
if(false) {
    /* m-top is deprecated */
?>
<div class="block-ads" id="block-ads-m-top">
    <div class="ad-container">
        <iframe sandbox="allow-scripts allow-popups"  src="//ads.exosrv.com/iframe.php?idzone=2598489&size=300x50" width="300" height="50" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
    </div>

    <script type="text/javascript">
      (function () {
        function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;
        ExoLoader.addZone({"idzone":"2598489"}); // m_middle
      })();
    </script>
</div>
<?php
}
?>