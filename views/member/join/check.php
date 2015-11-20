<?php
    session_start();
    date_default_timezone_set('Asia/Tokyo');

 

  //情報が入っていなかった場合、index.phpにもどる
    if(!isset($_SESSION["join"])){
      header("Location: index");
      exit();
    }

    $start_date = $_SESSION["join"]["start_day"];
    $end_date = $_SESSION["join"]["end_day"];

    if(!empty($_POST)){
      $sql=sprintf('INSERT INTO users SET name="%s",eg_name="%s",
        email="%s",password="%s",start_day="%s",end_day="%s",status="%s",picture="%s",created=NOW()',
        mysqli_real_escape_string($db,$_SESSION["join"]["name"]),
        mysqli_real_escape_string($db,$_SESSION["join"]["eg_name"]),
        mysqli_real_escape_string($db,$_SESSION["join"]["email"]),
        mysqli_real_escape_string($db,sha1($_SESSION["join"]["password"])),
        mysqli_real_escape_string($db,$start_date),
        mysqli_real_escape_string($db,$end_date),
        mysqli_real_escape_string($db,$_SESSION["join"]["status"]),
        mysqli_real_escape_string($db,$_SESSION["join"]["image"])
      );

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
    <p>名前</p>
      <?php echo h($_SESSION["join"]["name"]); ?>
  </div>

  <div>
    <p>English Name</p>
      <?php echo h($_SESSION["join"]["eg_name"]); ?>
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
        if($_SESSION["join"]["status"]=='future_student'){
            echo '来学予定者';
        }elseif($_SESSION["join"]["status"]=='stay_student'){
            echo '在学生';
        }else{
            echo '卒業生';
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
