<?php
/* @var Array $data */
/* @var Theme $theme */

$domainUrl = getDomainUrl();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6 language-cn" lang="zh-CN"> <![endif]-->
<!--[if IE 7 ]>	<html class="ie7 language-cn" lang="zh-CN"> <![endif]-->
<!--[if IE 8 ]>	<html class="ie8 language-cn" lang="zh-CN"> <![endif]-->
<!--[if IE 9 ]>	<html class="ie9 language-cn" lang="zh-CN"> <![endif]-->
<!--[if !(IE)]><!--> <html class="language-cn" lang="zh-CN"> <!--<![endif]-->

<head<?php print $data['header_attrs'];?>>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link rel="dns-prefetch" href="https://img.tuzac.com">
    <link rel="preconnect" href="https://img.tuzac.com">
    <link rel="dns-prefetch" href="https://image.tuzac.com">
    <link rel="preconnect" href="https://image.tuzac.com">
    
    <link rel="dns-prefetch" href="https://ajax.googleapis.com">
    <link rel="preconnect" href="https://ajax.googleapis.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://js.juicyads.com">
    <link rel="preconnect" href="https://js.juicyads.com">
    <link rel="dns-prefetch" href="https://poweredby.jads.co">
    <link rel="preconnect" href="/https:/poweredby.jads.co">
    <link rel="dns-prefetch" href="https://syndication.exdynsrv.com">
    <link rel="preconnect" href="https://syndication.exdynsrv.com">
    <link rel="dns-prefetch" href="https://a.magsrv.com">
    <link rel="preconnect" href="https://a.magsrv.com">
    

    <meta name="referrer" content="no-referrer" />

    <?php if( empty($data['dev_mode']) ) { ?>
    <meta name="robots" content="<?=empty($data['meta_robots']) ? 'follow, index': $data['meta_robots']?>" />
    <?php }?>

    <meta http-equiv="cache-control" content="max-age=864000" />

    <link rel="shortcut icon" href="/theme/jw/favicon.ico" type="image/vnd.microsoft.icon" />

    <meta name="description" content="<?=$data['meta_desc']?>" />
    <meta name="keywords" content="<?=$data['meta_keywords']?>" />
    <link rel="canonical" href="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <link rel="shortlink" href="<?=$domainUrl . $data['REQUEST_URI']?>" />

    <meta name="rating" content="adult" />
    <meta name="rating" content="RTA-5042-1996-1400-1577-RTA" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <meta name="twitter:title" content="<?=$data['page_title'] . ' | ' . SITE_NAME ?>" />
    <meta name="twitter:site" content="@javwall" />
    <meta name="twitter:creator" content="@javwall" />

    <meta property="og:url"                content="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <meta property="og:type"               content="File" />
    <meta property="og:title"              content="<?=$data['page_title'] ?>" />
    <meta property="og:description"        content="<?=$data['meta_desc']?>" />

    <title><?=$data['page_title'] . ' | ' . SITE_NAME ?></title>

    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

    <?php if(empty($data['dev_mode'])) : ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-197042779-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-197042779-1');
    </script>    
    <!-- GA universal -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-55PR14SFEJ"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-55PR14SFEJ');

    function trackGA(event_name) {
        if(typeof gtag !== 'undefined') gtag('event', event_name, {});
    }
    </script>

    <?php endif; ?>

    <?php print $data['metas']; ?>
    <?php print $data['styles']; ?>
    <?php print $data['scripts_header']; ?>

</head>
<body>

<?php
if( empty($data['dev_mode']) ) {
?>
<!-- JuicyAds v3.2P Start -->
<script type="text/javascript">
var juicy_tags = ['a', 'img'];
</script>
<script type="text/javascript" src="https://js.juicyads.com/jp.php?c=34b42303x224u4q2v284x2d444&u=http%3A%2F%2Fwww.juicyads.rocks"></script>
<!-- JuicyAds v3.2P End -->

<!-- never block -->
<script type="text/javascript" src="/nb/sdBZfpSvXN.js"></script>
<?php } ?>

<div id="body" class="layout-center">

    <div class="loading"><div class="spinner"></div></div>


    <header class="header" role="banner">
        <div id="h-left">
            <a href="/" title="Home" rel="home" class="header__logo">
                <img src="/theme/jw/logo.png" width="45" height="45"alt="Tuzac home" class="header__logo-image">
                <span>图宅<span class="not-in-mobile">- 高清美女图集</span></span>
            </a>
        </div>

        <div id="h-right">
            <?php if(!empty($_SESSION['user'])):?>
                <span>Hello <a href="/user"><?=$_SESSION['user']['name']?></a></span>|
                <span><a href="/user/logout">退出</a></span>
            <?php else:?>
                <span><a href="/user/login">登录</a></span><span><a href="/user/register">注册</a></span>
            <?php endif;?>
        </div>

        <div id="h-middle">
            <div class="header__region region region-header">
                <form action="/search" method="get" id="search-block-form" accept-charset="UTF-8">
                    <div>
                        <div class="container-inline">
                            <div class="form-item form-type-textfield form-item-search-block-form">
                                <input title="Enter the terms you wish to search for." placeholder="搜索... 逗号分隔关键字" type="text" id="edit-search-block-form--1" name="term" value="" size="15" maxlength="1024" class="form-text">
                            </div>
                            <div class="form-actions form-wrapper" id="edit-actions">
                                <input type="submit" id="edit-submit" name="op" value="go" class="form-submit">
                            </div>
                        </div>
                    </div>
                </form>
                <?= $theme->render(null, 'ads_templates/ad-m-top');?>
            </div>
        </div>
    </header>

    <header class="mobile_header">
        <div id="h-left-m">
            <div style="position: absolute; left: 15px; top: 15px; ">
                <span id="quick-nav">
                    <img src="/theme/jw/images/menu100bsa.png" alt="Quick Navigation" title="Quick Navigation" width="20" height="20">
                </span>
                    <span id="mobile-back">
                    <a href="javascript:history.go(-1)" class="ui-link"><img src="/theme/jw/images/back100bsa.png" title="Go Back" alt="Go Back" width="20" height="20"></a>
                </span>
            </div>
            <a href="/" title="Home" rel="home" class="header__logo">
                <img src="/theme/jw/logo.png" width="45" height="45"alt="Tuzac home" class="header__logo-image">
                <span>图宅<span class="not-in-mobile">- 高清美女图集</span></span>
            </a>
            <div id="search-button-div">
                <a href="#" id="buttonSearch" class="ui-link"><img src="/theme/jw/images/search100bsa.png" title="Search" alt="Search" width="20" height="20"></a>
                <a id="user-actions" href="/user/<?=empty($_SESSION['user'])?'login':''?>" aria-label="Login"><span class="glyphicon glyphicon-user"></span></a>
            </div>
        </div>
        <div id="h-middle-m">
            <div class="header__region region region-header">
                <form action="/search" method="get" id="search-block-form" accept-charset="UTF-8">
                    <div>
                        <div class="container-inline">
                            <div class="form-item form-type-textfield form-item-search-block-form">
                                <input title="Enter the terms you wish to search for." placeholder="搜索... 逗号分隔关键字" type="text" id="edit-search-block-form--2" name="term" value="" size="15" maxlength="1024" class="form-text">
                            </div>
                            <div class="form-actions form-wrapper" id="edit-actions">
                                <input type="submit" id="edit-submit" name="op" value="search" class="form-submit">
                            </div>
                        </div>
                    </div>
                </form>
                <?= $theme->render(null, 'ads_templates/ad-m-top');?>
            </div>
        </div>
    </header>

    <div class="main-menu mobile_hide" role="navigation">
        <ul class="navbar clearfix">
            <?php foreach($data['blocks']['blockHeader']['data']['menuLinks'] as $menuLink) :?>
                <li class="<?= substr($data['blocks']['blockHeader']['data']['currentUrl'], 0, strlen($menuLink['url'])) === $menuLink['url'] ? 'active' : '' ?>">
                    <a href="<?= $menuLink['url']?>" title=""><?= $menuLink['name']?></a>
                </li>
            <?php endforeach; ?>
            
            <?php if(!empty($_SESSION['user'])):?>
                <li class="logout mobile-only">
                    <span>Hello <a href="/user"><?=$_SESSION['user']['name']?></a></span>|
                    <span><a href="/user/logout">退出</a></span>
                </li>    
            <?php else:?>
                <li class="login mobile-only">
                    <span><a href="/user/login">登录</a></span>
                </li>  
                <li class="signup mobile-only">
                    <span><a href="/user/register">注册</a></span>
                </li>    
            <?php endif;?>
            <!--li class="outer-link"><a href="https://www.javcook.com" title="" target="_blank">JAVCOOK.com</a></li>
            <li class="outer-link last"><a href="https://www.youfreex.com" title="" target="_blank">YouFreeX.com</a></li-->
        </ul>
    </div>

<!-- JuicyAds v3.0 -->
<div class="mobile-only mobile-banner" style="width:100%; padding: 15px 0 0 0; text-align: center">
  <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
  <ins id="946411" data-width="300" data-height="50"></ins>
  <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':946411});</script>
</div>
<!--JuicyAds END-->
