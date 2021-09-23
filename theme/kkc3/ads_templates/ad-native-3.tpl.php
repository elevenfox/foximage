<?php
if( empty($data['dev_mode']) ) {
?>
<div id="<?=empty($apply_mobile_native_ads) ? 'block-ads-right-sidebar-ad-3' : 'block-ads-right-sidebar-ad-3-mobile'?>"  class="<?=empty($apply_mobile_native_ads) ? '':'mobile-only'?>">
    <script type="application/javascript" data-idzone="4279900" src="https://a.exdynsrv.com/nativeads-v2.js" ></script>
    <script type="text/javascript">
      (function () {
        function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;
        ExoLoader.addZone({"idzone":"4279900"}); // native-3
      })();
    </script>
</div>
<?php } ?>