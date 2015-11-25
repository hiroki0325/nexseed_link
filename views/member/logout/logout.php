<?php 
    session_start();
 
    //セッション情報を削除
    $_SESSION=$arrayName = array();
    if(ini_get("session.use_cokkie_params")){
      $params=session_get_cookie_params();
      setcookie(session_name(),'', time() - 42000,
        $params["path"],$params["domain"],
        $params["secure"],$params["httponly"]
        );
    }
    session_destroy();

    //Cookie情報を削除
    setcookie('email','',time()-3600);
    setcookie('password','',time()-3600);

    header('Location: ../login/login');
    exit();

 ?>
