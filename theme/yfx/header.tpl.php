<?php
/* @var Array $data */
/* @var Theme $theme */

$domainUrl = getDomainUrl();
$site_lang = empty(Config::get('site_lang')) ? 'zh-CN' : Config::get('site_lang');
?>
<!DOCTYPE html>
 <html lang="<?=$site_lang?>" >

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
    
    <link rel="shortcut icon" href="/theme/yfx/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="canonical" href="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <link rel="shortlink" href="<?=$domainUrl . $data['REQUEST_URI']?>" />

    <meta name="referrer" content="no-referrer" />
    <?php if( empty($data['dev_mode']) ) { ?>
    <meta name="robots" content="<?=empty($data['meta_robots']) ? 'follow, index': $data['meta_robots']?>" />
    <?php }?>
    <meta http-equiv="cache-control" content="max-age=864000" />
    <meta name="description" content="<?=$data['meta_desc']?>" />
    <meta name="keywords" content="<?=$data['meta_keywords']?>" />    
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <meta name="twitter:title" content="<?=$data['page_title'] . ' | ' . SITE_NAME ?>" />
    <meta name="twitter:site" content="@javwall" />
    <meta name="twitter:creator" content="@javwall" />

    <meta property="og:url"                content="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <meta property="og:type"               content="File" />
    <meta property="og:title"              content="<?=$data['page_title'] ?>" />
    <meta property="og:description"        content="<?=$data['meta_desc']?>" />

    <title><?=t($data['page_title']) . ' | ' . SITE_NAME ?></title>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

    <?php if(empty($data['dev_mode'])) : ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-82GCRWGNJ1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-82GCRWGNJ1');

        function trackGA(event_name) {
            if(typeof gtag !== 'undefined') gtag('event', event_name, {});
        }
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M3LQNF2X');</script>
    <!-- End Google Tag Manager -->
    <?php endif; ?>

    <?php print $data['metas']; ?>
    <?php print $data['styles']; ?>
    <?php print $data['scripts_header']; ?>

</head>
<body class="body <?=isAdmin()?'admin':''?>">

<?php
if( empty($data['dev_mode']) ) {
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M3LQNF2X"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<!-- never block -->
<script type="text/javascript" src="/nb/sdBZfpSvXN.js"></script>
<?php } ?>

<div id="body" class="layout-center">

    <div class="loading"><div class="spinner"></div></div>


    <header class="header" role="banner">

        <div id="h-left">
            <a href="/" title="Home" rel="home" class="header__logo">
                <img src="<?=Config::get('site_logo')?>" alt="YouFreeX home" class="header__logo-image">
            </a>
        </div>

        <div id="h-right">
            <?php if(!empty($_SESSION['user'])):?>
                <span>Hello <a href="/user"><?=$_SESSION['user']['name']?></a></span>|
                <span><a href="/user/logout">Logout</a></span>
            <?php else:?>
                <span><a href="/user/login">Log In</a></span><span><a href="/user/register">Sign Up</a></span>
            <?php endif;?>
        </div>

        <div id="h-middle">
            <div class="header__region region region-header">
                <form action="/search" method="get" id="search-block-form" accept-charset="UTF-8">
                    <div>
                        <div class="container-inline">
                            <div class="form-item form-type-textfield form-item-search-block-form">
                                <input title="Enter the terms you wish to search for." placeholder="Search..." type="text" id="edit-search-block-form--1" name="term" value="" size="15" maxlength="1024" class="form-text">
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
                <img src="<?=Config::get('site_logo')?>" alt="YouFreeX home" class="header__logo-image">
            </a>
            <div id="search-button-div">
                <a href="#" id="buttonSearch" class="ui-link"><img src="/theme/jw/images/search100bsa.png" title="Search" alt="Search" width="20" height="20"></a>
                <a id="user-actions" href="/user/<?=empty($_SESSION['user'])?'login':''?>" aria-label="Login"><span class="glyphicon glyphicon-user"></span></a>
            </div>
        </div>

        <div id="h-middle-m">
            <div class="header__region region region-header">
                <form action="/search" method="get" id="search-block-form-mobile" accept-charset="UTF-8">
                    <div>
                        <div class="container-inline">
                            <div class="form-item form-type-textfield form-item-search-block-form">
                                <input title="Enter the terms you wish to search for." placeholder="Search..." type="text" id="edit-search-block-form-mobile" name="term" value="" size="15" maxlength="1024" class="form-text">
                            </div>
                            <div class="form-actions form-wrapper" id="edit-actions-mobile">
                                <input type="submit" id="edit-submit-mobile" name="op" value="Search" class="form-submit">
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
                    <span><a href="/user/logout">Logout</a></span>
                </li>    
            <?php else:?>
                <li class="login mobile-only">
                    <span><a href="/user/login">login</a></span>
                </li>  
                <li class="signup mobile-only">
                    <span><a href="/user/register">Sign Up</a></span>
                </li>    
            <?php endif;?>
        </ul>
    </div>

<!-- JuicyAds v3.0 -->
<div class="mobile-only mobile-banner" style="width:100%; padding: 15px 0 0 0; text-align: center">
  <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
  <ins id="946411" data-width="300" data-height="50"></ins>
  <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':946411});</script>
</div>
<!--JuicyAds END-->
