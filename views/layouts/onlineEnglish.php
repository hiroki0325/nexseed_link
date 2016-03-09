<?php
    // ログイン判定
    if (!isLoginSuccess()) {
        header('Location: /7th_batch_camp//nexseed_link/user/auth/login');
        exit();
    }

    // 最終訪問日更新
     visit_log_time_show();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
      <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
      <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">

</head>
<body>
  <?php
      if (!isset($page)) {
        include('./views/' . $function . '/' . $directry . '.php');
      } else {
        include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
      }
   ?>

</body>
</html>
