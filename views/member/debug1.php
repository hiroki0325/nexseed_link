<?php 
    if (isLoginSuccess()) {
        echo "ログインしていた場合の処理";
    } else {
        echo "ログインしていなかった場合の処理";
    }


    if (status()=='future'){
        echo '来学予定者としてログイン中';
    }elseif(status()=='stay') {
        echo "在学生としてログイン中";
    }else{
        echo "卒業生としてログイン中";
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>hoge</title>
</head>
<body>
  <h1>来学予定者</h1>
  <div>
    <a href="logout/logout">ログアウト</a>
  </div>
</body>
</html>
