<?php
// if(!is_mobile()) {
  if( empty($data['dev_mode']) ) {
?>

<div class="ad-side-right">

    <?php include ('ad-native-1.tpl.php')?>

    <?php include ('ad-native-2.tpl.php')?>

    <?php include ('ad-native-3.tpl.php')?>

    <script async type="application/javascript" src="https://a.exdynsrv.com/ad-provider.js"></script> 
    <div id="block-ads-right-sidebar-ad-v">
        <div>
            <div class="ad-container">
              <ins class="adsbyexoclick" data-zoneid="4279904"></ins> 
            </div>
        </div>
    </div>
    <div id="block-ads-right-sidebar-ad-v-2">
        <div>
            <div class="ad-container">
              <ins class="adsbyexoclick" data-zoneid="4279906"></ins> 
            </div>
        </div>
    </div>
    <script>(AdProvider = window.AdProvider || []).push({"serve": {}});</script>
    <script type="text/javascript">
              (function () {
                function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;
                ExoLoader.addZone({"idzone":"4279904"}); // native-v
                ExoLoader.addZone({"idzone":"4279906"}); // native-v2
              })();
    </script>
</div>
<?php 
}
//}
?>