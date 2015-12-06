<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
      <link rel="stylesheet" type="text/css" href="../views/assets/css/user/style.css">
      <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
      <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">

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
