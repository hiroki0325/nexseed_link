<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
      <link rel="stylesheet" type="text/css" href="../views/assets/css/style.css">
      <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
      <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">

      <!-- FullCalemdarの呼び出し -->
      <!-- CSS -->
      <link href="../../views/assets/css/reserve/fullcalendar.min.css" rel="stylesheet" type="text/css">
      <!-- Java Script -->
      <script type="text/javascript" src="../../views/assets/js/reserve/moment.min.js"></script>
      <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script type="text/javascript" src="../../views/assets/js/reserve/jquery-ui.custom.min.js"></script>
      <script type="text/javascript" src="../../views/assets/js/reserve/fullcalendar.min.js"></script>
      <script type="text/javascript" src="../../views/assets/js/reserve/ja.js"></script>

</head>
<body>
  <h1>NexSeedLink</h1>
  <?php
      if (!isset($page)) {
        include('./views/' . $function . '/' . $directry . '.php');
      } else {
        include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
      }
   ?>
  
</body>
</html>
