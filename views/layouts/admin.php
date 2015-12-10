<?php 
    if (!isLoginSuccess()) {
        header('Location: ../user/auth/login');
        exit();
    }
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>NexSeedLink -Admin page-</title>
  <link rel="stylesheet" href="../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../views/assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../views/assets/css/admin/sb-admin.css">
  <link rel="stylesheet" href="../views/assets/css/admin/plugins/morris.css">



</head>
<body>
  <?php
      if (!isset($page)) {
        include('./views/' . $function . '/' . $directry . '.php');
      // } else {
      //   include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
      }

   ?>

   <!-- jQuery -->
   <script src="../views/assets/js/admin/jquery.js"></script>

   <!-- Bootstrap Core JavaScript -->
   <script src="../views/assets/js/admin/bootstrap.min.js"></script>

   <!-- Morris Charts JavaScript -->
   <script src="../views/assets/js/admin/plugins/morris/raphael.min.js"></script>
   <script src="../views/assets/js/admin/plugins/morris/morris.min.js"></script>
   <script src="../views/assets/js/admin/plugins/morris/morris-data.js"></script>

   <!-- Flot Charts JavaScript -->
   <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
   <script src="../views/assets/js/admin/plugins/flot/jquery.flot.js"></script>
   <script src="../views/assets/js/admin/plugins/flot/jquery.flot.tooltip.min.js"></script>
   <script src="../views/assets/js/admin/plugins/flot/jquery.flot.resize.js"></script>
   <script src="../views/assets/js/admin/plugins/flot/jquery.flot.pie.js"></script>
   <script src="../views/assets/js/admin/plugins/flot/flot-data.js"></script>

</body>
</html>

