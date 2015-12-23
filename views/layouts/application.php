<?php
    // ログイン判定
    if (!isLoginSuccess()) {
        header('Location: /nexseed_link/user/auth/login');
        exit();
    }

    // 最終訪問日更新
     visit_log_time_show();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>NexSeedLink</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="UTF-8">
<!-- css -->
  <?php if($function == 'mypage'):?>
    <!-- マイページに必要 -->
    <link rel="shortcut icon" href="views/assets/images/seedkun.ico" >
    <link rel="stylesheet" href="views/assets/css/bootstrap.css">
    <link rel="stylesheet" href="views/assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="views/assets/css/mypage/style.css">
    <link rel="stylesheet" href="views/assets/css/mypage/main.css" />
    <link rel="stylesheet" href="views/assets/css/mypage/owl.carousel.css" />
    <link rel="stylesheet" href="views/assets/css/mypage/magnific-popup.css" />
    <link rel="stylesheet" href="views/assets/css/mypage/body.css" />
    <link rel="stylesheet" href="views/assets/css/mypage/responsive.css" />
    
  <?php else: ?>
    <!-- マイページ以外に必要 (パスが違う) -->
    <link rel="shortcut icon" href="../../views/assets/images/seedkun.ico" >
    <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../../views/assets/css/mypage/style.css" />
    <link rel="stylesheet" href="../../views/assets/css/mypage/main.css" />
    <link rel="stylesheet" href="../../views/assets/css/mypage/owl.carousel.css" />
    <link rel="stylesheet" href="../../views/assets/css/mypage/magnific-popup.css" />
    <link rel="stylesheet" href="../../views/assets/css/mypage/body.css" />
    <link rel="stylesheet" href="../../views/assets/css/mypage/responsive.css" />

    <link rel="stylesheet" href="../../views/assets/css/<?php echo $function.'/'.$directry.'.css';?>">
  <?php endif; ?>

</head>
<body>
  <!-- Header -->
  <div id="header">

    <div class="top">
      <!-- Logo -->
      <div id="logo">
        <?php if($function == 'mypage'):?>
            <span class="image avatar48"><img src="views/user/user_picture/<?php echo current_user('image'); ?>" alt="" /></span>
        <?php else: ?>
            <span class="image avatar48"><img src="../../views/user/user_picture/<?php echo current_user('image'); ?>" alt="" /></span>
        <?php endif; ?>
        
        <h1 id="title"><?php echo current_user('fullname'); ?></h1>
    <!--     <p>hogeID</p> -->
      </div>

      <!-- Nav -->
      <nav id="nav">
        <ul>
          <li><a href="/nexseed_link/mypage" id="top-link" class="skel-layers-ignoreHref"><span class="icon fa-home">ホーム</span></a></li>
          <li><a href="/nexseed_link/onlineEnglish/reserve/index" id="portfolio-link" class="skel-layers-ignoreHref"><span class="fa fa-commenting">英会話</span></a></li>
          <li><a href="/nexseed_link/logistic/logistic/top" id="about-link" class="skel-layers-ignoreHref"><span class="fa fa-plane">物流</span></a></li>
          <li><a href="#" id="contact-link" class="skel-layers-ignoreHref"><span class="icon fa fa-cog">詳細ページ</span></a></li>
        </ul>
      </nav>
    </div>

    <div class="bottom">
      <!-- Social Icons -->
      <ul class="icons">
        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon fa fa-envelope"><span class="label">Email</span></a></li>
      </ul>
    </div>
  </div>

  <!-- Main -->
  <div id="main">
    <?php

        if ($function == 'mypage') {
            include('./views/' . $function . '.php');
        } else {
            if (!isset($page)) {
                include('./views/' . $function . '/' . $directry . '.php');
            } else {
                include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
            }
        }


        //最終ログイン時間を記録する
        visit_log_time();

     ?>
  </div><!-- /main -->

  <!-- FOOTER -->
  <footer id="footer">
    <!-- SOCIAL ICONS -->
    <div class="footer-social-icons">
    </div>

    <!-- /SOCIAL ICONS -->
    <div class="copyright">
      <p>&copy; 2016 <a href="">NexseedLink</a>made by nexseed_link製作委員会</p>
    </div>
  </footer>
  <!-- /FOOTER -->

  <!-- Scripts -->


  <script src="../../views/assets/js/jquery.min.js"></script>
  <script src="../../views/assets/js/bootstrap.js"></script>
  <script src="../../views/assets/js/mypage/util.js"></script>
  <script type='text/javascript' src="../../views/assets/js/<?php echo $function.'/'.$directry.'.js';?>"></script>

  <?php if($function == 'mypage'):?>
    <script src="views/assets/js/jquery.min.js"></script>
    <script src="views/assets/js/bootstrap.js"></script>
    <script src="views/assets/js/mypage/jquery.scrolly.min.js"></script>
    <script src="views/assets/js/mypage/jquery.scrollzer.min.js"></script>
    <script src="views/assets/js/mypage/skel.min.js"></script>
    <script src="views/assets/js/mypage/util.js"></script>
    <script src="views/assets/js/mypage/jquery.parallax.js"></script>
    <script src="views/assets/js/mypage/smoothscroll.js"></script>
    <script src="views/assets/js/mypage/masonry.pkgd.min.js"></script>
    <script src="views/assets/js/mypage/jquery.fitvids.js"></script>
    <script src="views/assets/js/mypage/owl.carousel.min.js"></script>
    <script src="views/assets/js/mypage/jquery.counterup.min.js"></script>
    <script src="views/assets/js/mypage/jquery.isotope.min.js"></script>
    <script src="views/assets/js/mypage/jquery.magnific-popup.min.js"></script>
    <script src="views/assets/js/mypage/scripts.js"></script>
    <script src="views/assets/js/mypage/main.js"></script>
  <?php else: ?>

    <script src="../../views/assets/js/jquery.min.js"></script>
    <script src="../../views/assets/js/bootstrap.js"></script>
    <script src="../../views/assets/js/mypage/jquery.scrolly.min.js"></script>
    <script src="../../views/assets/js/mypage/jquery.scrollzer.min.js"></script> 
    <script src="../../views/assets/js/mypage/skel.min.js"></script>
    <script src="../../views/assets/js/mypage/util.js"></script>
    <script src="../../views/assets/js/mypage/main.js"></script>
    <script type='tsext/javascript' src="../../views/assets/js/<?php echo $function.'/'.$directry.'.js';?>"></script>

<?php endif; ?>
</body>
</html>
