<?php
    //仮のアカウント情報設定
    $_SESSION["join"]["id"] = 38;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["nickname"] = "koichi";

    //マッチング完了レッスンの取得
    $sql = sprintf('SELECT * FROM lessons WHERE student_id=%d AND reserve_status_id=%d',
                  $_SESSION["join"]["id"],
                  2
                  );
    $lessons = mysqli_query($db,$sql) or die(mysqli_error($db));

    if (isset($_POST["id"])) {
        $sql = sprintf('DELETE FROM lessons WHERE id=%d',$_POST["id"]);
        mysqli_query($db, $sql) or die(mysqli_error($db));
    }


?>

<h1>レッスン予約状況</h1>

<hr>

<?php while ($lesson = mysqli_fetch_assoc($lessons)): ?>
    <p>開始時間：<?php echo $lesson["date"] ?></p>
    <form action="" method="post">
      <input type="hidden" name="id" value="<?php $lesson['id'] ;?>">
      <input type="submit" name="cancel" value="キャンセル">
    </form>
    <a href="http://<?php $lesson['rand_str'] ;?>">入室する</a>
    <hr>
<?php endwhile ;?>


