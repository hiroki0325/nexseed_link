<?php 

    //ログインした時間を記録する
    $sql=sprintf('UPDATE users SET last_login_time=%d WHERE id=%d ',
        $_SESSION['time'],
        mysqli_real_escape_string($db,$_SESSION['join']['id'])
        );
        mysqli_query($db, $sql) or die(mysqli_error());
        

    //セッション情報を削除
    $_SESSION = array();
    if(ini_get("session.use_cokkie_params")){
      $params = session_get_cookie_params();
      setcookie(session_name(),'', time() - 42000,
        $params["path"],$params["domain"],
        $params["secure"],$params["httponly"]
      );
    }
    session_destroy();

    //Cookie情報を削除
    setcookie('email','',time()-3600);
    setcookie('password','',time()-3600);

    header('Location: login');
    exit();

 ?>
