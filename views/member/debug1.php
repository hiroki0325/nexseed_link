<?php 
    if (isLoginSuccess()) {
        echo "ログインしていた場合の処理";
    } else {
        echo "ログインしていなかった場合の処理";
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>hoge</title>
</head>
<body>
  <h1>管理者</h1>
  <?php
    if (status() == 1) {
        echo '管理者としてログイン中';
    } elseif (status() == 2) {
        echo '来学予定者としてログイン中';
    } elseif (status() == 3) {
        echo "在学生としてログイン中";
    } elseif (status() == 4) {
        echo "卒業生としてログイン中";
    } elseif (status() == 5) {
        echo "先生としてログイン中";
    } else {
        echo "status()関数のエラー";
    }

    echo "<br>";
    echo "status()の中身 = " . status();
    echo "<br>";
    echo "ユーザー名 : " . current_user('first_name') . ' ' . current_user('last_name');
    echo "<br>";
    echo "メールアドレス : " . current_user('email');
    echo "<br>";
    echo "留学期間 : " . current_user('start_day') . ' ~ ' . current_user('end_day');
    echo "<br>";
    echo current_user_image();

    ?>
  <div>
    <a href="logout/logout">ログアウト</a>
  </div>
</body>
</html>
