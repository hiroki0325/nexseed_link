<?php
    //teacherアカウントでログインしている場合、専用ページにリダイレクト
    if ($_SESSION["join"]["status_id"] == 5) {
        header("Location: /nexseed_link/onlineEnglish/reserve/teacher_index");
        exit();
    }

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
<link rel="stylesheet" type="text/css" href="../../views/assets/css/reserve/reserve.css">
<div class="container-fluid">
  <div class="well">
    <h1>レッスン予約状況</h1>
  </div>

  <hr>





  <div class="container">
    
      

            <?php if ($lesson = mysqli_fetch_assoc($lessons)) :?>
              <?php mysqli_data_seek($lessons, 0);?>
              <?php while ($lesson = mysqli_fetch_assoc($lessons)): ?>
                <div class="well lesson">
                  <div class="media">
                    <div class="" style="float:left;">
                      <?php
                          echo sprintf('<img src="../../views/user/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                                        $lesson["picture"],
                                        $lesson["nickname"]
                                      );
                      ?>

                      <p>開始時間：<?php echo date("n月j日", strtotime($lesson["date"])).date("H時i分", strtotime($lesson["time"])) ;?></p>
                      <input type="button" class="btn btn-info" onclick="window.open('https://lovepop-geechscamp.ssl-lolipop.jp/7th_batch_camp/nexseed_link/onlineEnglish/class/class?<?php echo $lesson['rand_str'] ;?>')" value="入室する">
                      <p>※開始5分前までは入室しないでください。</p>
                      <br>
                      <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $lesson['id'] ;?>">
                        <input class="btn" type="submit" name="cancel" value="キャンセル">
                      </form>
                    </div>
                  </div>
                </div>
              <?php endwhile ;?>
            <?php else :?>
              <div class="row">
                <p>現在予約済みのレッスンはありません</p>
                  <input type="button" value="レッスン予約画面へ" onClick="document.location='reserve'">
              </div>
            <?php endif ;?>
</div>
