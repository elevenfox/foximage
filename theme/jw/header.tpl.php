<?php
/* @var Array $data */
/* @var Theme $theme */

$domainUrl = getDomainUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" dir="ltr">

<head<?php print $data['header_attrs'];?>>
    <meta charset="utf-8" />
    <meta name="referrer" content="no-referrer" />
    <meta name="robots" content="follow, index" />

    <meta http-equiv="cache-control" content="max-age=864000" />

    <link rel="shortcut icon" href="/theme/jw/favicon.ico" type="image/vnd.microsoft.icon" />

    <meta name="description" content="<?=$data['meta_desc']?>" />
    <meta name="keywords" content="<?=$data['meta_keywords']?>" />
    <link rel="canonical" href="<?=$data['REQUEST_URI']?>" />
    <link rel="shortlink" href="<?=$data['REQUEST_URI']?>" />

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
    <meta name="viewport" content="width=device-width">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-197042779-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-197042779-1');
    </script>

    <?php print $data['metas']; ?>
    <?php print $data['styles']; ?>
    <?php print $data['scripts_header']; ?>

</head>
<body>

<!-- START ExoClick Goal Tag | test -->
<script type="text/javascript" src="https://ads.exoclick.com/tag_gen.js" data-goal="e7f967087c429c40b2a4864e4c81b0cf"></script>
<!-- END ExoClick Goal Tag | test -->

<!-- never block -->
<script type="text/javascript" src="/nb/sdBZfpSvXN.js"></script>

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
                <img src="/theme/jw/logo.png" width="45" height="45"alt="Tuzac home" class="header__logo-image">
                <span>图宅<span class="not-in-mobile">- 高清美女图集</span></span>
            </a>
            <div id="search-button-div">
                <a href="#" id="buttonSearch" class="ui-link"><img src="/theme/jw/images/search100bsa.png" title="Search" alt="Search"></a>
                <a id="user-actions" href="/user/<?=empty($_SESSION['user'])?'login':''?>"><span class="glyphicon glyphicon-user"></span></a>
            </div>
        </div>


        <div id="h-right">
            <?php if(!empty($_SESSION['user'])):?>
                <span>Hello <a href="/user"><?=$_SESSION['user']['name']?></a></span>|
                <span><a href="/user/logout">Log out</a></span>
            <?php else:?>
                <span><a href="/user/login">Log In</a></span><span><a href="/user/register">Sign Up</a></span>
            <?php endif;?>
        </div>


        <div id="h-middle">
            <div class="header__region region region-header">
                <form action="/search" method="post" id="search-block-form" accept-charset="UTF-8">
                    <div>
                        <div class="container-inline">
                            <div class="form-item form-type-textfield form-item-search-block-form">
                                <input title="Enter the terms you wish to search for." placeholder="Search..." type="text" id="edit-search-block-form--2" name="search_term" value="" size="15" maxlength="128" class="form-text">
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
            <li class="outer-link"><a href="https://www.javcook.com" title="" target="_blank">JAVCOOK.com</a></li>
            <li class="outer-link last"><a href="https://www.youfreex.com" title="" target="_blank">YouFreeX.com</a></li>
        </ul>
    </div>

