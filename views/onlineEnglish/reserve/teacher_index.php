<?php
    //仮のアカウント情報設定
    $_SESSION["join"]["id"] = 40;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["nickname"] = "Daisy";

    //マッチング完了レッスンの取得
    $sql = sprintf('SELECT lessons.*, users.picture, users.nickname,lesson_times.time FROM lessons INNER JOIN lesson_times ON lessons.time_id=lesson_times.id INNER JOIN users ON lessons.student_id=users.id WHERE lessons.teacher_id=%d AND reserve_status_id=2',
                  $_SESSION["join"]["id"]
                  );
    $lessons = mysqli_query($db,$sql) or die(mysqli_error($db));

    if (isset($_POST["id"])) {
        $sql = sprintf('DELETE FROM lessons WHERE id=%d',$_POST["id"]);
        mysqli_query($db, $sql) or die(mysqli_error($db));
    }
?>

<h1>Your Lessons</h1>

<hr>
<?php if ($lesson = mysqli_fetch_assoc($lessons)) :?>
    <?php mysqli_data_seek($lessons, 0);?>
    <?php while ($lesson = mysqli_fetch_assoc($lessons)): ?>
        <?php
            echo sprintf('<img src="../../views/member/user_picture/%s" alt="profile_picture" width="80" height="80"><p>Student neme : %s</p>',
                          $lesson["picture"],
                          $lesson["nickname"]
                        );
        ?>
        <p>Starting time：<?php echo date("n/j", strtotime($lesson["date"]))." ".date("H : i", strtotime($lesson["time"])) . " (Japanese Time)" ;?></p>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?php echo $lesson['id'] ;?>">
          <input type="submit" name="cancel" value="Cancel">
        </form>
        <a href="http://geechscamp.lovepop.jp/7th_batch_camp/nexseed_link/onlineEnglish/<?php $lesson['rand_str'] ;?>">Enter the room</a>
        <p>Please enter 5 minutes before the Lesson</p>
        <hr>
    <?php endwhile ;?>
<?php else :?>
    <p>There are no lessons</p>
<?php endif ;?>

