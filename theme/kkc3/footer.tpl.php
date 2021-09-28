<?php
/* @var Array $data */
/* @var Theme $theme */
?>


    <div class="clearfix"></div>

   <footer class="footer">
    <?= $theme->render($data, 'ads_templates/ad-footer-banner');?>
    <?= $theme->render($data, 'ads_templates/ad-m-bottom');?>
   </footer>


   <footer id="fixed-footer">
       <div class="hot-searches">
            <div>热门搜索</div>
            <?php
              $hot_models = get_random_hot_searches(100);
              if(is_array($hot_models)) {
                foreach ($hot_models as $model) {
                  echo '<a class="hot-modal" href="/search?term=' . $model . '">' . $model . '</a>';
                }
              }
            ?>
       </div>
       <div>
            <span class="the-tag">
              <a href="/tags/性感美女">性感美女</a>
            </span>
           <span class="the-tag">
              <a href="/tags/丝袜美腿">丝袜美腿</a>
            </span>
            <span class="the-tag">
              <a href="/tags/cosplay">cosplay</a>
            </span>
            <span class="the-tag">
              <a href="/tags/诱惑">诱惑</a>
            </span>
            <span class="the-tag">
              <a href="/tags/清纯">清纯</a>
            </span>
           <span class="the-tag">
              <a href="/tags/制服">制服</a>
            </span>
           <span class="the-tag">
              <a href="/tags/萝莉控">萝莉控</a>
            </span>
           <span class="the-tag">
              <a href="/tags/女仆">女仆</a>
            </span>
            <span class="the-tag">
              <a href="/tags/秀人网">秀人网</a>
            </span>
           <span class="the-tag">
              <a href="/tags/尤果圈爱尤物">尤果圈</a>
            </span>
           <span class="the-tag">
              <a href="/tags/内衣美女">内衣美女</a>
            </span>
           <span class="the-tag">
              <a href="/tags/妹子">妹子</a>
            </span>
           <span class="the-tag">
              <a href="/tags/人体艺术">人体艺术</a>
           </span>
           <span class="the-tag">
              <a href="/tags/日本萌妹子">日本萌妹子</a>
            </span>
           <span class="the-tag">
              <a href="/tags/蕾丝诱惑">蕾丝</a>
            </span>
       </div>
       
       <div class="footer-links">
           <span class="footer-link"><a href="/terms-conditions">Terms &amp; Conditions</a></span>
           <span class="footer-link"><a href="/dmca-notice">DMCA</a></span>
           <span class="footer-link"><a href="/usc-2257">2257</a></span>
           <span class="footer-link"><a href="/privacy-policy">Privacy Policy</a></span>
       </div>
       <div style="margin: 15px 0;">
           © KKC3 <?=Config::get('site_abbr')?> 2021 - <?=date('Y', time())?>
       </div>
       <?php print $data['scripts_footer']; ?>

   </footer>

    <?= $theme->render($data, 'ads_templates/ad-pop-under');?>


<?php
if( empty($data['dev_mode']) ) {
?>
<script type="text/javascript">
  (function () {
    function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;

    ExoLoader.serve({"script_url":"/nb/QlzeiSIAgK.php"});
  })();
</script>
<?php } ?>

</body>
</html>



