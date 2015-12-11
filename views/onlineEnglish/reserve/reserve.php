<?php
    $db = mysqli_connect("localhost", "root", "mysql","nexseed_link");
    // ログイン中ユーザーのお気に入り講師情報を呼び出す
    $sql_like_teachers = sprintf('SELECT u.id, u.nickname, u.picture, l.id AS "lesson_id", l.date FROM users u, teacher_likes t, lessons l 
                                  WHERE t.student_id=%d AND t.teacher_id=u.id AND t.teacher_id=l.teacher_id AND l.reserve_status_id=1 AND l.date>NOW()+1',
                                $_SESSION["join"]["id"]
                             );
    $like_teachers = mysqli_query($db, $sql_like_teachers)or die(mysqli_error($db));


    //指定した日付で予約可能な講師情報と予約可能時間帯を取得
    date_default_timezone_set('Asia/Tokyo');
    if (isset($_REQUEST["date"])) {
        $date = (string)$_REQUEST["date"];
        // $date_next = (string)$date +1 day;
        //date($date, strtotime("+1 day"));
    }else{
        $date = (string)date("Ymd", strtotime("+1 day"));
        // $date_next = (string)date("Ymd", strtotime("+2 day"));
    }

    echo "選択したレッスン日：". $date;
    var_dump($date);
    echo "<br>";
    // echo "選択したレッスン日の次の日：". $date_next;
    // var_dump($date_next);

    //パラメータで指定された日の講師及び予約情報
    $sql_all_lessons = sprintf('SELECT users.id, users.nickname, users.picture, lessons.id AS "lesson_id", lessons.date ,lesson_times.time                                 
                                FROM users INNER JOIN lessons ON users.id=lessons.teacher_id INNER JOIN lesson_times ON lessons.time_id=lesson_times.id WHERE lessons.reserve_status_id=1 AND lessons.date="%s"',
                                $date
                              );

    $all_lessons = mysqli_query($db, $sql_all_lessons) or die(mysqli_error($db));

    //お気に入り講師の追加
    if (isset($_POST["like"])) {
        if ($_POST["like"] == "お気に入り追加") {
            $sql = sprintf('INSERT INTO teacher_likes SET student_id=%d , teacher_id=%d , created=NOW()',
                          $_SESSION["join"]["id"],
                          $_POST["teacher_id"]
                          );
            mysqli_query($db, $sql);
        }elseif ($_POST["like"] == "お気に入り解除" && isset($_POST["id"])) {
            $sql = sprintf('DELETE FROM teacher_likes WHERE student_id=%s AND teacher_id=%s',
                            $_SESSION["join"]["id"],
                            $_POST["id"]
                            );
            mysqli_query($db, $sql)or die(mysqli_error($db));
        }
    }
    
    //配列作成
    // $lessons_ary = array();
    // $lessons_ary1 = array();
    // $lessons_ary2 = array();
    // $i = 1;

    //予約情報の送信
    // if (isset($_POST["date"])) {
    //     $_SESSION["reserve"] = $_POST;
    //     $_SESSION["reserve"]["nickname"] = $like_teacher["nickname"];
    //     $_SESSION["reserve"]["picture"] = $like_teacher["picture"];
    //     header("Location: confirm.php");
    //     exit();
    //}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Reservation</title>
  <!-- <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-1.11.3.js"></script>
  <script type="text/javascript" src="assets/js/post.js"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <!-- メイン画面 -->
      <div class="col-md-8">
        <!-- お気に入り講師一覧のrow -->
        <div class="row">
            <p>お気に入り講師から予約</p>
            <div class="col-md-4">
              <div class="col-md-6">
                <!-- お気に入り講師の写真表示 -->


                    <!-- 修正中 -->
                    <!-- 講師とレッスン時間が紐付いた配列を作成する -->
                    <?php 
                        // while ( $like_teacher = mysqli_fetch_assoc($like_teachers) && $like_teacher["id"]) {
                        //     var_dump($like_teacher);
                        //     $array = array("like_teacher_name" => "",
                        //                    "")
                        // }
                    ?>




                    <?php while ($like_teacher = mysqli_fetch_assoc($like_teachers)) :?>
                        <?php
                            // echo "===== like_teacher =====";
                            // var_dump($like_teacher);

                            // $lessons_ary = array_merge($lessons_ary,array($like_teacher["nickname"] => array_merge($lessons_ary1,array($i => $like_teacher["date"]))));
                            // $i++;
                            // //$lessoms_ary2 = $lessons_ary + array( "key" => $);
                            // // $lessons_ary1 = array_merge($lessons_ary1, array("$i" => $like_teacher["date"]));
                            // // $i++;
                            // //$lessons_ary2 = 
                            // var_dump($lessons_ary);
                            // // var_dump($lessons_ary1);
                            // // var_dump($lessons_ary2);
                        ?>
                        <?php 
                          // echo sprintf('<img src="../../views/member/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                          //                  $like_teacher["picture"],
                          //                  $like_teacher["nickname"]
                          //                );
                        ?>
                        <!-- <form action="" method="post">
                          <input type="hidden" name="id" value="<?php echo $like_teacher["id"]; ?>" >
                          <input type="submit" name="like" value="お気に入り解除">
                        </form>
                         <div class="col-md-6">
            
                            <form action="confirm" method="post">
                              <input type="hidden" name="lesson_id" value="<?php echo $like_teacher["lesson_id"]; ?>" >
                              <input type="hidden" name="id" value="<?php echo $like_teacher["id"]; ?>" >
                              <input type="hidden" name="nickname" value="<?php echo $like_teacher["nickname"]; ?>" >
                              <input type="hidden" name="picture" value="<?php echo $like_teacher["picture"]; ?>" >
                              <button type="submit" name="date" value="<?php echo $like_teacher["date"];?>"><?php echo date("n月j日H時i分",strtotime($like_teacher["date"])) ;?></button>
                            </form>
                        </div>

                        <hr> -->

                    <?php endwhile ;?>


                    <!-- 修正中ここまで -->
                  </div>
              
            </div><!-- <div class="col-md-4"> -->
            <div class="col-md-4">
              
            </div>
            <div class="col-md-4">

            </div>
        </div>
        <!-- お気に入り講師終了 -->
        <hr>

        <!-- 日付指定用のrow -->
        <div class="row">
          <p>日付を指定して予約</p>
          <div class="col-md-12">
            <ul>
            <?php
                for ($i=0; $i <=10 ; $i++) { 
                  echo sprintf("<li style=".'display:inline;'.">"."<a href='reserve?date=%s'>"."%s"."</a>"."</li>",
                  date("Y-m-d", strtotime("+$i day")),
                  date("n/j(D)", strtotime("+$i day"))
                  );
                }
                
            ?>
            </ul>
          </div>
        </div>
        <!-- 日付指定終了 -->

        <!-- 検索結果のためのrow -->
        <div class="row">

          <?php while ($all_lesson = mysqli_fetch_assoc($all_lessons)) :?>
              <div class="col-md-4">
                <div class="col-md-6">
                  <!-- 講師の写真表示 -->
                  <?php 
                      if (isset($all_lesson["nickname"])) {
                        echo sprintf('<img src="../../views/member/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                                      $all_lesson["picture"],
                                      // "default.png",
                                      $all_lesson["nickname"]
                                      // "Daisy"
                                    );
                      }
                      
                  ?>
                </div>
                <div class="col-md-6">
                  <?php
                      //お気に入り登録の重複確認
                      // $sql = sprintf('SELECT count(*) AS cnt FROM teacher_likes WHERE student_id=%d AND teacher_id=%d',
                      //                 $_SESSION["join"]["id"],
                      //                 $all_lesson["id"]
                      //                 );
                      // $record = mysqli_query($db, $sql) or die(mysqli_error($db));
                      // $table = mysqli_fetch_assoc($record);
                      // if ($table["cnt"] > 0) {
                      //     $error["like"] = "duplicate";
                      // }
                      // echo $error["like"];
                  ?>

                  <!-- 予約可能時間帯の表示 -->
                  <?php if (isset($all_lesson["lesson_id"])) :?>
                    <form action="../confirm" method="post">
                      <input type="hidden" name="lesson_id" value="<?php echo $all_lesson["lesson_id"]; ?>" >
                      <input type="hidden" name="nickname" value="<?php echo $all_lesson["nickname"]; ?>" >
                      <input type="hidden" name="picture" value="<?php echo $all_lesson["picture"]; ?>" >
                      <input type="hidden" name="time" value="<?php echo $all_lesson["time"]; ?>" >
                      <button type="submit" name="date" value="<?php echo $all_lesson["date"];?>"><?php echo date("H時i分",strtotime($all_lesson["time"])) ;?></button>
                    </form>
                    <?php if (empty($error["duplicate"])) :?>
                        <!-- <form action="" method="post">
                          <input type="hidden" name="teacher_id" value="<?php echo $all_lesson["id"]; ?>" >
                          <input type="submit" name="like" value="お気に入り追加">
                        </form> -->
                    <?php else :?>
                        <!-- <label>登録済み</label> -->
                    <?php endif ;?>
                  <?php endif ;?>
                </div>
              </div><!-- <div class="col-md-4"> -->
          <?php endwhile; ?>


        </div><!-- <div class="row"> -->
        <!-- 検索結果終了 -->
      </div>
      <!-- メイン画面終了 -->

      <!-- サイドバー -->
      <div class="col-md-4">
        
      </div>
    </div>
  </div>
  
</body>
</html>
