<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
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
