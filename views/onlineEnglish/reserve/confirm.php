<?php
    //仮のアカウント情報設定
    $_SESSION["join"]["id"] = 38;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["eg_name"] = "koichi";

    date_default_timezone_set('Asia/Tokyo');

    if (isset($_POST["confirm"])) {
        if ($_POST["confirm"] == "on") {
            $sql = sprintf('UPDATE lessons SET student_id=%d, reserve_status_id=2, modified=NOW() WHERE id=%d',
                          $_SESSION["join"]["id"],
                          $_POST["lesson"]
            );
            mysqli_query($db, $sql)or die(mysqli_error($db));
            header('Location: thanks');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
  <body>
    <div class="container">
    <?php 
        var_dump($_POST);
    ?>
      <div class="row">
        <h1>予約情報の確認</h1>
      </div>
      
    
      <div class="row">
        <img src="" alt="">
        <?php
            if (isset($_POST)) {
                echo $_POST["eg_name"];
                echo "<br>";
                echo date("n月j日", strtotime($_POST["date"]));
                echo "<br>";
                echo date("H時i分", strtotime($_POST["date"]));
            }
        ?>
      </div>

      <div class="row">
        <p>※必ず内容をご確認の上で、「予約する」ボタンを押してください。</p>
        <input type="button" value="選択画面に戻る" onClick="document.location='reserve';">
        <form action="" method="post">       
          <input type="hidden" name="lesson" value="<?php echo $_POST["lesson_id"]; ?>" >
          <input type="hidden" name="eg_name" value="<?php echo $_POST["eg_name"]; ?>" >
          <input type="hidden" name="picture" value="<?php echo $_POST["picture"]; ?>" >
          <input type="hidden" name="confirm" value="on">
          <input type="submit" value="予約する">
        </form>
      </div>
    </div>

    
  </body>
</html>
