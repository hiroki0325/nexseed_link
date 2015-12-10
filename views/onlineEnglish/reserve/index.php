<?php
    //仮のアカウント情報設定
    $_SESSION["join"]["id"] = 38;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["nickname"] = "koichi";

    //マッチング完了レッスンの取得
    $sql = sprintf('SELECT lessons.*, users.picture, users.nickname,lesson_times.time FROM lessons INNER JOIN lesson_times ON lessons.time_id=lesson_times.id INNER JOIN users ON lessons.teacher_id=users.id WHERE lessons.student_id=%d AND reserve_status_id=2',
                  $_SESSION["join"]["id"]
                  );
    $lessons = mysqli_query($db,$sql) or die(mysqli_error($db));

    if (isset($_POST["id"])) {
        $sql = sprintf('UPDATE lessons SET student_id=NULL, reserve_status_id=1 WHERE id=%d',$_POST["id"]);
        mysqli_query($db, $sql) or die(mysqli_error($db));
    }
?>

<h1>レッスン予約状況</h1>

<hr>
<?php if ($lesson = mysqli_fetch_assoc($lessons)) :?>
    <?php mysqli_data_seek($lessons, 0);?>
    <?php while ($lesson = mysqli_fetch_assoc($lessons)): ?>
        <?php
            echo sprintf('<img src="../../views/member/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                          $lesson["picture"],
                          $lesson["nickname"]
                        );
        ?>
        <p>開始時間：<?php echo date("n月j日", strtotime($lesson["date"])).date("H時i分", strtotime($lesson["time"])) ;?></p>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?php echo $lesson['id'] ;?>">
          <input type="submit" name="cancel" value="キャンセル">
        </form>
        <a href="http://geechscamp.lovepop.jp/7th_batch_camp/nexseed_link/onlineEnglish/<?php $lesson['rand_str'] ;?>">入室する</a>
        <p>※開始5分前までは入室しないでください。</p>
        <hr>
    <?php endwhile ;?>
<?php else :?>
    <p>現在予約済みのレッスンはありません</p>
<?php endif ;?>
