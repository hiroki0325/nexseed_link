<?php
    if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
      //ログインしている
      $_SESSION['time']=time();
      $sql=sprintf('SELECT*FROM users WHERE id=%d',
        mysqli_real_escape_string($db,$_SESSION['id'])
        );

      $record=mysqli_query($db,$sql)or die(mysqli_error($db));
      $user=mysqli_fetch_assoc($record);
    }else{
      //ログインしていない
      header('Location: login');
      exit();
    }

    //ユーザーステータスによる分岐
    if($user['status']=='future_student'){
      echo header('Location: debug1');
    }else
    if($user['status']=='stay_student'){
      echo header('Location: debug2');
    }else{
      echo header('Location: debug3');
    }


  ?>

