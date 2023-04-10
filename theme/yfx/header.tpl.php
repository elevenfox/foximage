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
    
    <link rel="dns-prefetch" href="//img.tuzac.com">
    <link rel="preconnect" href="//img.tuzac.com">
    
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="preconnect" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <link rel="preconnect" href="//www.googletagmanager.com">
    <link rel="dns-prefetch" href="//js.juicyads.com">
    <link rel="preconnect" href="//js.juicyads.com">
    <link rel="dns-prefetch" href="//poweredby.jads.co">
    <link rel="preconnect" href="//poweredby.jads.co">
    <link rel="dns-prefetch" href="//syndication.exdynsrv.com">
    <link rel="preconnect" href="//syndication.exdynsrv.com">
    <link rel="dns-prefetch" href="//a.exdynsrv.com">
    <link rel="preconnect" href="//a.exdynsrv.com">
    
    <link rel="shortcut icon" href="/theme/yfx/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="canonical" href="<?=$domainUrl . $data['REQUEST_URI']?>" />
    <link rel="shortlink" href="<?=$domainUrl . $data['REQUEST_URI']?>" />

    <meta name="referrer" content="no-referrer" />
    <meta name="robots" content="<?=empty($data['meta_robots']) ? 'follow, index': $data['meta_robots']?>" />
    <meta http-equiv="cache-control" content="max-age=864000" />
    <meta name="description" content="<?=$data['meta_desc']?>" />
    <meta name="keywords" content="<?=$data['meta_keywords']?>" />    
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width">
    
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146802304-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-178022644-1');
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-82GCRWGNJ1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-82GCRWGNJ1');
    </script>
    <?php endif; ?>

    <?php print $data['metas']; ?>
    <?php print $data['styles']; ?>
    <?php print $data['scripts_header']; ?>

</head>
<body class="body <?=isAdmin()?'admin':''?>">

<?php
if( empty($data['dev_mode']) ) {
?>
<!-- JuicyAds v3.2P Start -->
<script type="text/javascript">
var juicy_tags = ['a', 'img'];
</script>
<script type="text/javascript" src="https://js.juicyads.com/jp.php?c=34b42303x224u4q2v284039484&u=http%3A%2F%2Fwww.juicyads.rocks"></script>
<!-- JuicyAds v3.2P End -->

<!-- never block -->
<script type="text/javascript" src="/nb/sdBZfpSvXN.js"></script>
<?php } ?>

<div id="body" class="layout-center">

    <div class="loading"><div class="spinner"></div></div>


    <header class="header" role="banner">

        <div id="h-left">
            <div style="position: absolute; left: 15px; top: 15px; ">
            <span id="quick-nav">
                <img src="/theme/jw/images/menu100bsa.png" alt="Quick Navigation" title="Quick Navigation">
            </span>
                <span id="mobile-back">
                <a href="javascript:history.go(-1)" class="ui-link"><img src="/theme/jw/images/back100bsa.png" title="Go Back" alt="Go Back"></a>
            </span>
            </div>
            <a href="/" title="Home" rel="home" class="header__logo">
                <img src="<?=Config::get('site_logo')?>" alt="YouFreeX home" class="header__logo-image">
            </a>
            <div id="search-button-div">
                <a href="#" id="buttonSearch" class="ui-link"><img src="/theme/jw/images/search100bsa.png" title="Search" alt="Search"></a>
                <a id="user-actions" href="/user/<?=empty($_SESSION['user'])?'login':''?>"><span class="glyphicon glyphicon-user"></span></a>
            </div>
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
                                <input title="Enter the terms you wish to search for." placeholder="Search..." type="text" id="edit-search-block-form--2" name="term" value="" size="15" maxlength="128" class="form-text">
                            </div>
                            <div class="form-actions form-wrapper" id="edit-actions">
                                <input type="submit" id="edit-submit" name="op" value="" class="form-submit">
                            </div>
                        </div>
                    </div>
                </form>
                <?= $theme->render(null, 'ads_templates/ad-m-top');?>
            </div>
        </div>
    </header>

    <div class="main-menu" role="navigation">
        <ul class="navbar clearfix">
            <?php foreach($data['blocks']['blockHeader']['data']['menuLinks'] as $menuLink) :?>
                <li class="<?= substr($data['blocks']['blockHeader']['data']['currentUrl'], 0, strlen($menuLink['url'])) === $menuLink['url'] ? 'active' : '' ?>">
                    <a href="<?= $menuLink['url']?>" title=""><?= $menuLink['name']?></a>
                </li>
            <?php endforeach; ?>
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
