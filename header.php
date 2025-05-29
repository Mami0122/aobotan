                 
<?php
  $file_name = basename($_SERVER['SCRIPT_NAME']);
  $OgpHeadPrefix = ($file_name === 'index.php') ? 'website' : 'article';
  $site_url = 'https://aobotan.miico.site/';
?>
<!DOCTYPE html>
<html lang="ja">
<head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb# <?= $OgpHeadPrefix ?>: https://ogp.me/ns/<?= $OgpHeadPrefix ?>#">  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <meta name="robots" content="noindex">
  <meta name="format-detection" content="telephone=no">
  <meta name="description" content="<?= $description ?>">
  <link rel="icon" href="images/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="images/touch-icon.png">
  <meta property="og:title" content="<?= $title ?>">
  <meta property="og:type" content="<?= $OgpHeadPrefix ?>">
  <meta property="og:url" content="<?= $site_url . basename($_SERVER['SCRIPT_NAME']) ?>">
  <meta property="og:image" content="<?= $site_url.'images/ogp-thumbnail.png' ?>">
  <meta property="og:site_name" content="青牡丹工務店 | 大阪市北区の住宅建築・リフォーム・公共事業なら青牡丹工務店">
  <meta property="og:description" content="<?= $description ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;400;500;600;700&family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@4.0.1/destyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
<div class="loading"><img src="images/logo.svg" alt=""></div>
<div class="contentCover active"></div>

<header class="header">
  <div class="header__inner">
  <?php if($file_name === 'index.php'): ?>
    <h1 class="header__logo">
      <a class="logo" href="/"><img src="images/logo.svg" alt="青牡丹工務店"></a>
    </h1>
  <?php else: ?>  
    <div class="header__logo">
      <a class="logo" href="/"><img src="images/logo.svg" alt="青牡丹工務店"></a>
    </div>
  <?php endif; ?> 
    <nav id="headerNav" class="header__nav">
      <div class="header__navListWrapper">
        <ul class="header__navList">
          <li class="header__navListItem only-sp">
            <a href="/" class="header__navListItemLink">トップページ</a>
          </li>
          <li class="header__navListItem header__navListItem--hasSubMenu">
            <a href="about.php" class="header__navListItemLink">私達について</a>
            <ul class="header__navSubList">
              <li class="hader__navSubListItem"><a href="about.php#sectionPhilosophy" class="header__navSubListItemLink">経営理念</a></li>
              <li class="hader__navSubListItem"><a href="about.php#sectionOverview" class="header__navSubListItemLink">会社概要</a></li>
              <li class="hader__navSubListItem"><a href="about.php#sectionSafety" class="header__navSubListItemLink">安全への取り組み</a></li>
            </ul>
          </li>
          <li class="header__navListItem header__navListItem--hasSubMenu">
            <a href="service.php" class="header__navListItemLink">事業内容</a>
            <ul class="header__navSubList">
              <li class="hader__navSubListItem"><a href="service.php#sectionHouseBuilding" class="header__navSubListItemLink">住宅建築・リフォーム</a></li>
              <li class="hader__navSubListItem"><a href="service.php#sectionCompanyBuilding" class="header__navSubListItemLink">法人新築・リフォーム</a></li>
              <li class="hader__navSubListItem"><a href="service.php#sectionPublicConstruction" class="header__navSubListItemLink">公共工事</a></li>
            </ul>
          </li>
          <li class="header__navListItem">
            <a href="/#frontNews" class="header__navListItemLink">お知らせ</a>
          </li>
          <li class="header__navListItem">
            <a href="contact.php" class="header__navListItemLink header__navListItemLink--hasIcon mail">
              <svg class="header__navIcon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.9484 4.38576C19.8582 3.93162 19.6568 3.51604 19.3756 3.17271C19.3163 3.09791 19.2544 3.03092 19.1872 2.96393C18.689 2.46322 17.9897 2.15088 17.2257 2.15088H2.77426C2.01031 2.15088 1.31352 2.46322 0.81293 2.96393C0.745938 3.03092 0.683984 3.09791 0.624531 3.17271C0.343164 3.516 0.141797 3.93162 0.0541406 4.38576C0.018125 4.56104 0 4.74217 0 4.92529V15.075C0 15.4644 0.0825781 15.8387 0.229844 16.1767C0.366445 16.4994 0.567852 16.7913 0.812891 17.0361C0.875 17.0981 0.93668 17.155 1.00398 17.2117C1.48391 17.6091 2.1034 17.8492 2.77426 17.8492H17.2257C17.8968 17.8492 18.519 17.6091 18.9962 17.2092C19.0633 17.155 19.1253 17.0981 19.1872 17.0361C19.4321 16.7913 19.6335 16.4994 19.7729 16.1767V16.1742C19.9202 15.8362 20 15.4644 20 15.0751V4.92529C20 4.74217 19.9821 4.56104 19.9484 4.38576ZM1.81676 3.96764C2.06461 3.72006 2.39746 3.57018 2.77426 3.57018H17.2257C17.6025 3.57018 17.9383 3.72006 18.1832 3.96764C18.2271 4.01174 18.2684 4.06088 18.3048 4.10971L10.7303 10.7111C10.5214 10.8942 10.2634 10.9846 10 10.9846C9.7393 10.9846 9.48141 10.8942 9.26973 10.7111L1.69813 4.10689C1.73164 4.05807 1.77293 4.01174 1.81676 3.96764ZM1.4193 15.075V5.57561L6.9007 10.3574L1.42207 15.1342C1.4193 15.1161 1.4193 15.0957 1.4193 15.075ZM17.2257 16.4296H2.77426C2.52891 16.4296 2.29934 16.3651 2.1034 16.2518L7.88379 11.2143L8.42344 11.6838C8.87504 12.0762 9.44016 12.2749 10 12.2749C10.5627 12.2749 11.1278 12.0762 11.5794 11.6838L12.1187 11.2143L17.8969 16.2518C17.7007 16.3651 17.4711 16.4296 17.2257 16.4296ZM18.5807 15.075C18.5807 15.0957 18.5807 15.1161 18.578 15.1342L13.0995 10.3602L18.5807 5.57814V15.075Z" fill="black"/>
              </svg>
              お問い合わせ
            </a>
          </li>
        </ul>
        <small class="header__navCopyright copyright">© AOBOTAN INC.</small>
      </div>
    </nav>
    <button type="button" class="burgerBtn" aria-controls="headerNav" aria-expanded="false">
      <span class="burgerBtn__bar"></span>
    </button>
  </div>
</header>
