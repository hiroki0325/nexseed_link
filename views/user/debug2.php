<<<<<<< HEAD:views/member/debug2.php




<?php 
    if (isLoginSuccess()) {
        echo "ログインしていた場合の処理";
    } else {
        header('Location: auth/login');
        exit();
    }
    echo "<br>";
    echo visit_log_time_show();
    
?>


=======
>>>>>>> a0a3cd2f27652dd8b0f087e37307fba341e43e76:views/user/debug2.php
<h1>来学予定者ページ</h1>

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
    echo "ユーザー名 : " . current_user('fullname');
    echo "<br>";
    echo "メールアドレス : " . current_user('email');
    echo "<br>";
    echo "留学期間 : " . current_user('start_day') . ' ~ ' . current_user('end_day');
    echo "<br>";
    echo current_user_image(100,100,"square");
?>

  <div>
    <a href="auth/logout">ログアウト</a>
  </div>
