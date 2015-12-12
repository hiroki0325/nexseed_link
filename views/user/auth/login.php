<?php

    if(isset($_COOKIE['email'])){
        if($_COOKIE['email']!=''){
          $_POST['email']=$_COOKIE['email'];
          $_POST['password']=$_COOKIE['password'];
          $_POST['save']='on';
        }
    }


    if(!empty($_POST)){
      //ログインの処理1
        if(isset($_POST['password'])){
            if($_POST['email']!='' && $_POST['password'] !=''){
              $sql=sprintf('SELECT*FROM users WHERE email="%s" AND password="%s"',
                mysqli_real_escape_string($db,$_POST['email']),
                mysqli_real_escape_string($db,sha1($_POST['password']))
              );
              $record=mysqli_query($db,$sql)or die(mysqli_error($db));

              if($table = mysqli_fetch_assoc($record)){
                  $_SESSION['join']['id']=$table['id'];
                  $_SESSION['join']['fullname']=$table['fullname'];
                  $_SESSION['join']['nickname']=$table['nickname'];
                  $_SESSION['join']['email']=$table['email'];
                  $_SESSION['join']['password']=$table['password'];
                  $_SESSION['join']['start_day']=$table['start_day'];
                  $_SESSION['join']['end_day']=$table['end_day'];
                  $_SESSION['join']['status_id']=$table['status_id'];
                  $_SESSION['join']['image']=$table['picture'];
                  $_SESSION['join']['created']=$table['created'];

             
                //ログイン情報を記録する
                  if($_POST['save']=='on'){
                    setcookie('email',$_POST['email'],time()+60*60*24*14);
                    setcookie('password',$_POST['password'],time()+60*60*24*14);
                  }
                //ログインした時間を記録
                  $_SESSION['time'] = time();
                  // $_SESSION['login_time'] = date("Y/m/d H:i:s",$_SESSION['time']);
                //ログイン回数のカウントとログインした時間の更新
                  $sql=sprintf('UPDATE users SET login_count=%d WHERE id=%d ',
                      $table['login_count']+1,
                      mysqli_real_escape_string($db,current_user('id'))
                  );
                  mysqli_query($db, $sql) or die(mysqli_error());
                //初回ログインのみユーザー編集画面に遷移
                  if ($table['login_count'] == 0){
                    header('Location: ../user_edit');
                    exit();
                  } else {
                    header('Location: ../index');
                    exit();
                  }

              }else{
                $error['login']='failed';
              }
            }else{
              $error['login']='blank';
            }

        }
    }

?>


<link rel="stylesheet" type="text/css" href="../../views/assets/css/user/login.css">
<div class="container">
  <div class="row">
    <div class="col-xs-offset-4 col-xs-4">
      <form action="" method="post" class="form-signin mg-btm">
        <h3 class="heading-desc">Login</h3>

        <div class="main">

          <div>
            <lavel>Email</lavel>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <?php if(isset($_POST['email'])): ?>
                  <input type="text" name="email" value="<?php echo h($_POST['email']); ?>"
                    class="form-control" placeholder="" autofocus>
                <?php else: ?>
                  <input type="text" name="email" class="form-control" placeholder="" autofocus>
                <?php endif; ?>
              </div>

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
            <lavel>Password</lavel>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
          </div>

          <div>
            <input type="checkbox" id="save" name="save" value="on">
            <label for="">次回から自動ログインする</label>
          </div>

          <div class="row">
            <div class="col-xs-6 col-md-6">     
            </div>
            <div class="col-xs-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-large btn-success pull-right">Login</button>
            </div>
          </div>

        </div>

          <span class="clearfix"></span>  
          <div class="login-footer">
            <div class="row">
              <div class="col-xs-6 col-md-6">
                <div class="left-section">
                  <a href="admin_login">管理者はこちら</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-6 pull-right"></div>
            </div>
          </div>


      </form>
    </div>
  </div>
</div>


