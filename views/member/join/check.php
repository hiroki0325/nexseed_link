<?php
  //情報が入っていなかった場合、index.phpにもどる
    if(!isset($_SESSION["join"])){
      header("Location: index");
      exit();
    }


    if(!empty($_POST)){
        if ($_SESSION["join"]["start_day"] && $_SESSION["join"]["end_day"]) {
            $sql=sprintf('INSERT INTO users SET first_name="%s",last_name="%s",eg_first_name="%s",eg_last_name="%s",
              email="%s",password="%s",start_day="%s",end_day="%s",status_id=%d,picture="%s",created=NOW()',
              mysqli_real_escape_string($db,$_SESSION["join"]["first_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["last_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["eg_first_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["eg_last_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["join"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["join"]["start_day"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["end_day"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["status_id"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["image"])
            );
        } else {
            $sql=sprintf('INSERT INTO users SET first_name="%s",last_name="%s",eg_first_name="%s",eg_last_name="%s",
              email="%s",password="%s",status_id=%d,picture="%s",created=NOW()',
              mysqli_real_escape_string($db,$_SESSION["join"]["first_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["last_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["eg_first_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["eg_last_name"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["email"]),
              mysqli_real_escape_string($db,sha1($_SESSION["join"]["password"])),
              mysqli_real_escape_string($db,$_SESSION["join"]["status_id"]),
              mysqli_real_escape_string($db,$_SESSION["join"]["image"])
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
    <p>姓</p>
      <?php echo h($_SESSION["join"]["last_name"]); ?>
  </div>

  <div>
    <p>名</p>
      <?php echo h($_SESSION["join"]["first_name"]); ?>
  </div>

  <div>
    <p>First Name</p>
      <?php echo h($_SESSION["join"]["eg_first_name"]); ?>
  </div>

  <div>
    <p>Last Name</p>
      <?php echo h($_SESSION["join"]["eg_last_name"]); ?>
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
    <p>プロフィール画像</p>
      <?php
          echo sprintf('<img src="../../views/member/user_picture/%s" width="100" height="100">',
              $_SESSION["join"]["image"]
          );
      ?>
  </div>

  <div>
      <a href="index?action=rewrite">&laquo;&nbsp;書き直す</a> |
      <button type="submit">登録する</button>
  </div>
 

</form>

</body>
</html>
