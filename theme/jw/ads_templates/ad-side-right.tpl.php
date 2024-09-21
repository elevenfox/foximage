<?php
// if(!is_mobile()) {
  if( empty($data['dev_mode']) ) {
?>

<div class="ad-side-right">

      <div class="backlink-ads">
      <?php
      // THE FOLLOWING BLOCK IS USED TO RETRIEVE AND DISPLAY LINK INFORMATION.
      // PLACE THIS ENTIRE BLOCK IN THE AREA YOU WANT THE DATA TO BE DISPLAYED.

      // MODIFY THE VARIABLES BELOW:
      // The following variable defines whether links are opened in a new window
      // (1 = Yes, 0 = No)
      $OpenInNewWindow = "1";

      // # DO NOT MODIFY ANYTHING ELSE BELOW THIS LINE!
      // ----------------------------------------------
      $BLKey = "SIM8-A4RT-49CN";

      if(isset($_SERVER['SCRIPT_URI']) && strlen($_SERVER['SCRIPT_URI'])){
          $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_URI'].((strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
      }

      if(!isset($_SERVER['REQUEST_URI']) || !strlen($_SERVER['REQUEST_URI'])){
          $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'].((isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
      }

      $QueryString  = "LinkUrl=".urlencode(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      $QueryString .= "&Key=" .urlencode($BLKey);
      $QueryString .= "&OpenInNewWindow=" .urlencode($OpenInNewWindow);


      if(intval(get_cfg_var('allow_url_fopen')) && function_exists('readfile')) {
          @readfile("http://www.backlinks.com/engine.php?".$QueryString); 
      }
      elseif(intval(get_cfg_var('allow_url_fopen')) && function_exists('file')) {
          if($content = @file("http://www.backlinks.com/engine.php?".$QueryString)) 
              print @join('', $content);
      }
      elseif(function_exists('curl_init')) {
          $ch = curl_init ("http://www.backlinks.com/engine.php?".$QueryString);
          curl_setopt ($ch, CURLOPT_HEADER, 0);
          curl_exec ($ch);

          if(curl_error($ch))
              print "Error processing request";

          curl_close ($ch);
      }
      else {
          print "It appears that your web host has disabled all functions for handling remote pages and as a result the BackLinks software will not function on your web page. Please contact your web host for more information.";
      }
      ?>
      </div>


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