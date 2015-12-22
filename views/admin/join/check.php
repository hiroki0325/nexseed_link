<?php
  //情報が入っていなかった場合、index.phpにもどる
    // if(!isset($_SESSION["user"])){
    //   header("Location: check");
    //   exit();
    // }


    $fullname = $_SESSION["user"]["first_name"]. ' ' .$_SESSION["user"]["last_name"];

    if(!empty($_POST)){
        if ($_SESSION["user"]["start_day"] && $_SESSION["user"]["end_day"]) {
            $sql=sprintf('INSERT INTO users SET fullname="%s",
              email="%s",password="%s",start_day="%s",login_count=0,end_day="%s",status_id=%d,created=NOW()',
              mysqli_real_escape_string($db,$fullname),
              mysqli_real_escape_string($db,$_SESSION["user"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["user"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["user"]["start_day"]),
              mysqli_real_escape_string($db,$_SESSION["user"]["end_day"]),
              mysqli_real_escape_string($db,$_SESSION["user"]["status_id"])
            );
        } else {
            $sql = sprintf('INSERT INTO users SET fullname = "%s",
              email = "%s",password = "%s",loing_count = 0,status_id = %d,created = NOW()',
              mysqli_real_escape_string($db,$fullname),
              mysqli_real_escape_string($db,$_SESSION["user"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["user"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["user"]["status_id"])
            );
        }
        mysqli_query($db,$sql)or die(mysqli_error($db));
        unset($_SESSION["user"]);


        $sql = 'SELECT * FROM users ORDER BY created DESC';
        $users = mysqli_query($db,$sql)or die(mysqli_error($db));
        $user = mysqli_fetch_assoc($users);
        //新しくユーザーが登録されたことを通知する
        $sql = sprintf('INSERT INTO notifications SET user_id = %d,
                         notificaton_message_id = 1, created = NOW()',
                    mysqli_real_escape_string($db,$user['id'])
        );
        $user_notification = mysqli_query($db,$sql)or die(mysqli_error($db));
        header('Location: ../../user/auth/login');
        exit();
    }
?>

<div id="page-wrapper">
  <div id="regist_form" class="container-fluid">
    <h1 class="page-header">確認画面 </h1>
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-6 col-lg-offset-3">
          <form action="" method="post">
            <input type="hidden" name="hoge" value="huga">
            <div  class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>Name</th>
                  <td><?php echo h($fullname); ?></td>
                </tr>
              </table>
            </div>      
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>E-mail</th>
                  <td><?php echo h($_SESSION["user"]["email"]); ?></td>
                </tr>
              </table>
            </div>      
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>Password</th>
                  <td>表示しません</td>
                </tr>
              </table>
            </div>      
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>留学開始日</th>
                  <td><?php echo h($_SESSION["user"]["start_day"]); ?></td>
                </tr>
              </table>
            </div>      
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>留学終了日</th>
                  <td><?php echo h($_SESSION["user"]["end_day"]); ?></td>
                </tr>
              </table>
            </div>      
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>ステータス</th>
                  <td>
                    <?php
                      if($_SESSION["user"]["status_id"]==2){
                          echo '来学予定者';
                      }elseif($_SESSION["user"]["status_id"]==3){
                          echo '在学生';
                      }elseif($_SESSION["user"]["status_id"]==4){
                          echo '卒業生';
                      }elseif($_SESSION["user"]["status_id"]==5){
                          echo 'teacher';
                      }else{
                          echo '管理者';
                      }
                    ?>
                  </td>
                </tr>
              </table>
            </div>

            <div class="row">
              <div class="col-xs-6 col-md-6">     
              </div>
                <button type="submit" class="send_btn">登録する</button>
                <a href="index?action=rewrite" class="back_btn">書き直す</a> 
              </div>
           <!--  <div class="row">
              <div class="col-xs-6 col-md-6">     
              </div>
              <div class="col-xs-6 col-md-6 pull-right">
                <button type="submit" class="btn btn-large btn-danger pull-right">登録する</button>
                <a href="index?action=rewrite" class="btn btn-sm btn-info pull-right">書き直す</a> 
              </div>
            </div> -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
