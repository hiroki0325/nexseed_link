<!DOCTYPE html>
<html lang="ja">
<head>
  <title>NexSeedLink</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="../views/assets/css/style.css">

  <link rel="stylesheet" href="../views/assets/css/mypage/main.css" />
  <link rel="stylesheet" href="../views/assets/css/mypage/timeline.css" />
  <link rel="stylesheet" href="../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../views/assets/css/mypage/owl.carousel.css" />
  <link rel="stylesheet" href="../views/assets/css/mypage/magnific-popup.css" />
  <link rel="stylesheet" href="../views/assets/css/mypage/body.css" />
  <link rel="stylesheet" href="../views/assets/css/mypage/responsive.css" />

  <link rel="stylesheet" href="../views/assets/font-awesome/css/font-awesome.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="images/icon/favicon.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/icon/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="images/icon/apple-touch-icon-57-precomposed.png">

</head>
<body>
  <!-- <h1>NexSeedLink</h1> -->

  <!-- Header -->
  <div id="header">

    <div class="top">
      <!-- Logo -->
      <div id="logo">
        <span class="image avatar48"><img src="images/avatar.jpg" alt="" /></span>
        <h1 id="title">Natuko</h1>
        <p>natuko@gmail.com</p>
      </div>

      <!-- Nav -->
      <nav id="nav">
        <ul>
          <li><a href="#top" id="top-link" class="skel-layers-ignoreHref"><span class="icon fa-home">ホーム</span></a></li>
          <li><a href="#portfolio" id="portfolio-link" class="skel-layers-ignoreHref"><span class="icon fa-th">英会話</span></a></li>
          <li><a href="#about" id="about-link" class="skel-layers-ignoreHref"><span class="icon fa-user">物流</span></a></li>
          <li><a href="#contact" id="contact-link" class="skel-layers-ignoreHref"><span class="icon fa-envelope">詳細ページ</span></a></li>
        </ul>
      </nav>
    </div>

    <div class="bottom">
      <!-- Social Icons -->
      <ul class="icons">
        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
        <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
        <li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
      </ul>
    </div>
  </div>

  <!-- Main -->
  <div id="main">

    <?php
        if (!isset($page)) {
            include('./views/' . $function . '/' . $directry . '.php');
        } else {
            include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
        }
     ?>


    <!-- Scripts -->
    <script src="../views/assets/js/jquery.min.js"></script>
    <script src="../views/assets/js/mypage/jquery.scrolly.min.js"></script>
    <script src="../views/assets/js/mypage/jquery.scrollzer.min.js"></script>
    <script src="../views/assets/js/mypage/skel.min.js"></script>
    <script src="../views/assets/js/mypage/util.js"></script>

    <script src="../views/assets/js/bootstrap.js"></script><!-- Bootstrap -->
    <script src="../views/assets/js/mypage/jquery.parallax.js"></script><!-- Parallax -->
    <script src="../views/assets/js/mypage/smoothscroll.js"></script><!-- Smooth Scroll -->
    <script src="../views/assets/js/mypage/masonry.pkgd.min.js"></script><!-- masonry -->
    <script src="../views/assets/js/mypage/jquery.fitvids.js"></script><!-- fitvids -->
    <script src="../views/assets/js/mypage/owl.carousel.min.js"></script><!-- Owl-Carousel -->
    <script src="../views/assets/js/mypage/jquery.counterup.min.js"></script><!-- CounterUp -->
    <script src="../views/assets/js/mypage/jquery.isotope.min.js"></script><!-- isotope -->
    <script src="../views/assets/js/mypage/jquery.magnific-popup.min.js"></script><!-- magnific-popup -->
    <script src="../views/assets/js/mypage/scripts.js"></script><!-- Scripts -->
    <script src="../views/assets/js/mypage/main.js"></script>

    <!-- /TimeLine -->
  </div><!-- /main -->

  <!-- FOOTER -->
  <footer id="footer">
    <!-- SOCIAL ICONS -->
    <div class="footer-social-icons">
    
    <!-- /SOCIAL ICONS -->
    <div class="copyright">
      <p>&copy; 2015 <a href="">ShapedTheme</a>. All Rights Reserved.</p>
    </div>
  </footer>
  <!-- /FOOTER -->

</body>
</html>
