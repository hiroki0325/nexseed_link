<?php
  //情報が入っていなかった場合、index.phpにもどる
    if(!isset($_SESSION["join"])){
      header("Location: index");
      exit();
    }


    $fullname = $_SESSION["join"]["first_name"]. ' ' .$_SESSION["join"]["last_name"];

    if(!empty($_POST)){
        if ($_SESSION["join"]["start_day"] && $_SESSION["join"]["end_day"]) {
            $sql=sprintf('INSERT INTO users SET fullname="%s",
              email="%s",password="%s",start_day="%s",login_count=0,end_day="%s",status_id=%d,created=NOW()',
              mysqli_real_escape_string($db,$fullname),
              mysqli_real_escape_string($db,$_SESSION["join"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["join"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["join"]["start_day"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["end_day"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["status_id"])
            );
        } else {
            $sql=sprintf('INSERT INTO users SET fullname="%s",
              email="%s",password="%s",loing_count=0,status_id=%d,created=NOW()',
              mysqli_real_escape_string($db,$fullname),
              mysqli_real_escape_string($db,$_SESSION["join"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["join"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["join"]["status_id"])
            );
        }

        mysqli_query($db,$sql)or die(mysqli_error($db));
        unset($_SESSION["join"]);

        header('Location: thanks');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Nexseed Link-登録確認</title>
</head>
<body>
  <h1>入力内容の確認</h1>

<form action="" method="post">
  <input type="hidden" name="hoge" value="huga">

  <div>
    <p>Name</p>
      <?php echo h($fullname); ?>
  </div>

  <div>
    <p>メールアドレス</p>
      <?php echo h($_SESSION["join"]["email"]); ?>
  </div>

  <div>
    <p>パスワード</p>
       [表示されません]
  </div>

  <div>
    <p>留学開始日</p>
      <?php echo h($_SESSION["join"]["start_day"]); ?>
  </div>

  <div>
    <p>留学終了日</p>
      <?php echo h($_SESSION["join"]["end_day"]); ?>
  </div>

  <div>
    <p>ステータス</p>
      <?php
        if($_SESSION["join"]["status_id"]==2){
            echo '来学予定者';
        }elseif($_SESSION["join"]["status_id"]==3){
            echo '在学生';
        }elseif($_SESSION["join"]["status_id"]==4){
            echo '卒業生';
        }elseif($_SESSION["join"]["status_id"]==5){
            echo 'teacher';
        }else{
            echo '管理者';
        }
      ?>
  </div>

  <div>
      <a href="index?action=rewrite">&laquo;&nbsp;書き直す</a> |
      <button type="submit">登録する</button>
  </div>
 

</form>

</body>
</html>
