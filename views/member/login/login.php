<?php
    if(isset($_COOKIE['email'])){
        if($_COOKIE['email']!=''){
          $_POST['email']=$_COOKIE['email'];
          $_POST['passsword']=$_COOKIE['password'];
          $_POST['save']='on';
        }
    }


    if(!empty($_POST)){
      //ログインの処理
        if(isset($_POST['password'])){
            if($_POST['email']!='' && $_POST['password'] !=''){
              $sql=sprintf('SELECT*FROM users WHERE email="%s" AND password="%s"',
                mysqli_real_escape_string($db,$_POST['email']),
                mysqli_real_escape_string($db,sha1($_POST['password']))
              );
              $record=mysqli_query($db,$sql)or die(mysqli_error($db));

              if($table = mysqli_fetch_assoc($record)){
                  $_SESSION['join']['id']=$table['id'];
                  $_SESSION['join']['first_name']=$table['first_name'];
                  $_SESSION['join']['last_name']=$table['last_name'];
                  $_SESSION['join']['eg_first_name']=$table['eg_first_name'];
                  $_SESSION['join']['eg_last_name']=$table['eg_last_name'];
                  $_SESSION['join']['email']=$table['email'];
                  $_SESSION['join']['password']=$table['password'];
                  $_SESSION['join']['start_day']=$table['start_day'];
                  $_SESSION['join']['end_day']=$table['end_day'];
                  $_SESSION['join']['status_id']=$table['status_id'];
                  $_SESSION['join']['picture']=$table['picture'];
                  $_SESSION['join']['created']=$table['created'];


                $_SESSION['time']=time();
                //ログイン情報を記録する
                  if($_POST['save']=='on'){
                    setcookie('email',$_POST['email'],time()+60*60*24*14);
                    setcookie('password',$_POST['password'],time()+60*60*24*14);
                  }
                header('Location: ../index');
                exit();
              }else{
                $error['login']='failed';
              }
            }else{
              $error['login']='blank';
            }
        }
    }

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
</head>
<body>
  <h1>ログイン</h1>
  <p>&raquo;<a href="../join/index">入会手続きをする</a></p>
  <form action="" method="post">

  <div>
    <lavel for="">メールアドレス</lavel>
    <?php if(isset($_POST['email'])): ?>
        <input type="text" name="email" value="<?php echo h($_POST['email']); ?>">
    <?php else: ?>
        <input type="text" name="email">
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <?php if($error['login']=='blank'): ?>
            <p class="error"> *メールアドレスとパスワードをご記入ください</p>
        <?php endif; ?>
        <?php if($error['login']=='failed'): ?>
            <p class="error"> *ログインに失敗しました。正しく情報をご記入ください</p>
        <?php endif; ?>
    <?php endif; ?>
  </div>

  <div>
    <lavel for="">パスワード</lavel>
    <input type="password" name="password">
  </div>

  <p>ログイン情報の記録</p>
  <div>
    <input type="checkbox" id="save" name="save" value="on">
    <label for="">次回から自動でログインする</label>
  </div>

  <div>
    <input type="submit" value="ログインする">
  </div>


  </form>
</body>
</html>
