<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
  <link rel="stylesheet" type="text/css" href="../views/assets/css/style.css">
  <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">
  <?php if ($function == 'logistic') :?>
    <link rel="stylesheet" href="../../views/assets/css/logistic/logistic.css">
    <link rel='stylesheet' href='../../views/assets/css/logistic/popbox.css' type='text/css' media='screen'>
    <link rel='stylesheet' href='../../views/assets/css/logistic/comment_timeline.css'>
    <script type='text/javascript' src='../../views/assets/js/logistic/jquery-min.js'></script>
    <script type='text/javascript' src='../../views/assets/js/logistic/popbox.js'></script>
    <script type='text/javascript'>
      function disp(){
        // 「OK」時の処理開始 ＋ 確認ダイアログの表示
        if(window.confirm('削除してよろしいですか？')){
          location.href = "<?php echo sprintf ('request_delete?id=%d',$_REQUEST['id']);?>"; 
        } 
        // 「キャンセル」時の処理開始
        else{
          window.alert('キャンセルされました'); // 警告ダイアログを表示
        }
        // 「キャンセル」時の処理終了
      }
    </script>
  <?php endif; ?>
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
