<?php

    if(isset($_SESSION['join']['id'])&& $_SESSION['time']+3600>time()){
      //ログインしている
      $user_status = current_user('status_id');
    }else{
      //ログインしていない
      header('Location: auth/login');
      exit();
    }


    if($user_status == 1){
      header('Location: ../admin/index');
    }else{
      header('Location: ../mypage');
    }
    



    // //ユーザーステータスによる分岐
    // if($user_status == 1){
    //   header('Location: ../admin/index');
    // }elseif($user_status == 2){
    //   header('Location: debug2');
    // }elseif($user_status == 3){
    //   header('Location: debug3');
    // }elseif($user_status == 4){
    //   header('Location: debug4');
    // }elseif($user_status == 5){
    //   header('Location: debug5');
    // }else{
    //   echo "例外発生";
    // }


  ?>

