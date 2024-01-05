<?php
// if(!is_mobile()) {
  if( empty($data['dev_mode']) ) {
?>

<div class="ad-side-right">
    <script async type="application/javascript" src="https://a.magsrv.com/ad-provider.js"></script>
    
    <?php include ('ad-native-1.tpl.php')?>

    <?php include ('ad-native-2.tpl.php')?>

    <?php include ('ad-native-3.tpl.php')?>
     
    <div id="block-ads-right-sidebar-ad-v">
        <div>
            <div class="ad-container">
              <ins class="eas6a97888e2" data-zoneid="4779888"></ins> 
            </div>
        </div>
    </div>
    <div id="block-ads-right-sidebar-ad-v-2">
        <div>
            <div class="ad-container"> 
              <ins class="eas6a97888e2" data-zoneid="4779890"></ins>
            </div>
        </div>
    </div>
    <!--script>(AdProvider = window.AdProvider || []).push({"serve": {}});</script-->
    <!-- push-serve called in footer -->
    <script type="text/javascript">
              (function () {
                function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;
                ExoLoader.addZone({"idzone":"4779888"}); // native-v
                ExoLoader.addZone({"idzone":"4779890"}); // native-v2
              })();
    </script>
</div>
<?php 
}
//}
?>