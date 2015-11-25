<?php 
    if (isLoginSuccess()) {
        echo "ログインしていた場合の処理";
    } else {
        echo "ログインしていなかった場合の処理";
    }

    echo "<br>";

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
    echo "status()の中身 = " . status('id');

    echo "<br>";

    $status = current_user('status_id');
    if($status == 2) {
        echo 'ステータス：来学予定者';
    } elseif($status == 3) {
        echo 'ステータス：在学生';
    } elseif($status == 4) {
        echo 'ステータス：卒業生';
    } elseif($status == 5) {
        echo 'ステータス：teacher';
    } elseif($status == 1) {
        echo 'ステータス：管理者';
    } else {
        echo 'ステータス：current_user()関数のエラー';
    }

    echo "<br>";
    echo "current_user('email')の中身 = " . current_user('email');


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>hoge</title>
</head>
<body>
  <h1>在学生</h1>
  <div>
    <a href="logout/logout">ログアウト</a>
  </div>
</body>
</html>
