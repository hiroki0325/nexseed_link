<?php
    // ログイン中ユーザーのお気に入り講師情報を呼び出す
    $sql_like_teachers = sprintf('SELECT users.id, users.nickname, users.picture, teacher_likes.student_id,lessons.id AS "lesson_id", lessons.date, lessons.teacher_id 
                                  AS "lessons_teacher_id", lessons.student_id AS "lessons_student_id", lessons.reserve_status_id,lesson_times.id AS "time_id", lesson_times.time 
                                  FROM users INNER JOIN teacher_likes ON users.id=teacher_likes.teacher_id AND teacher_likes.student_id=%s 
                                  INNER JOIN lessons ON lessons.teacher_id=teacher_likes.teacher_id AND lessons.reserve_status_id=1 
                                  INNER JOIN lesson_times ON lessons.time_id=lesson_times.id ORDER BY users.id, lessons.date, lesson_times.time',
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

    //パラメータで指定された日の講師及び予約情報
    $sql_all_lessons = sprintf('SELECT users.id, users.nickname, users.picture, lessons.id AS "lesson_id", lessons.date ,lesson_times.time                                 
                                FROM users INNER JOIN lessons ON users.id=lessons.teacher_id INNER JOIN lesson_times ON lessons.time_id=lesson_times.id WHERE lessons.reserve_status_id=1 AND lessons.date="%s"',
                                $date
                              );

    $all_lessons = mysqli_query($db, $sql_all_lessons) or die(mysqli_error($db));

      


    //お気に入り講師の追加と削除
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
    
    //配列の用意
    $lessons_ary = "";
 

?>
<link rel="stylesheet" type="text/css" href="../../views/assets/css/reserve/reserve.css">
<link rel="stylesheet" type="text/css" href="../../views/assets/css/logistic/logistic.css">

<div class="container">
  <div class="row">
    <!-- メイン画面 -->
    <div class="media-row col-xs-12" style="margin-top:30px">
      <!-- お気に入り講師一覧のrow -->
      <div class="row title_k">
          <p>お気に入り講師から予約</p>
      </div>
                  <?php 
                      // 講師とレッスン時間が紐付いた配列を作成する
                      $like_teachers_lessons = array(); // すべてのお気に入りの先生のレッスン可能時間をいれる
                      $count = 0;

                      $data = array(); // 最終的に必要なデータ (お気に入り先生ごとのレッスン可能時間すべて)
                   ?>


                  <?php while ($like_teacher = mysqli_fetch_assoc($like_teachers)) :?>
                      <?php
                         
                          $count++;

                          $tmp_ary = array(
                                $count => array(
                                      $like_teacher['nickname'] => $like_teacher['date']." ".$like_teacher["time"]." ".$like_teacher["lesson_id"]." ".$like_teacher["time_id"] // 日時と必要IDを連結させていれる
                                  )
                            );
                          
                          $like_teachers_lessons = array_merge($like_teachers_lessons,$tmp_ary);

                          $data = array_merge($data,array($like_teacher['nickname'] => array()));
                          
                      ?>

                      
                  <?php endwhile ;?>
                 <?php 
                    for ($i = 0; $i < count($like_teachers_lessons); $i++) {
                        $key = key($like_teachers_lessons[$i]);
                        $tmp_ary = array(
                            $i => $like_teachers_lessons[$i][$key]
                          );

                        for ($j = 0; $j < count($data); $j++) {  // お気に入り先生の数分繰り返す
                            $teacher_name = array_keys($data)[$j];

                            if ($teacher_name == $key) {//別々の箱から取ってきた名前が一致した時にそこへデータを追加している
                                $data[$key] = array_merge($data[$key], $tmp_ary);
                            }
                        }
                    }
                  ?>
                    
                <!-- お気に入り講師からの予約フォーム -->
                
                  
                  <?php 
                      foreach ($data as $key1 => $value1) {
                          echo '<div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">';
                          echo '<div class="well">';
                          
                          
                          echo $key1;
                          echo "<br>";
                          
                          
                          for ($i = 0; $i < count($value1); $i++) { 
                              $params = explode(' ', $value1[$i]);// データをスペース区切りで分解する
                              $datetime = $params[0]." ". $params[1];
                              $lesson_id = $params[2];
                              $time_id = $params[3];

                              //お気に入り講師の写真/ニックネーム表示
                              // echo '<div class="box">';
                              // echo sprintf('<img src="../../views/user/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                              //                 $like_teacher["picture"],
                              //                 $key1
                              //               );

                              //お気に入り解除ボタンの表示 
                              // echo '<form action="" method="post">';
                              // echo '<input type="hidden" name="id" value="<?php echo $like_teacher["id"]; " >';
                              // echo '<input class="btn btn-info" type="submit" name="like" value="お気に入り解除">';
                              // echo '</form>'; 
                              // echo '</div>';

                              

                              //お気に入り講師の予約可能時間帯表示
                              echo '<div class="media">';
                              echo '<div class="media-body" >';
                              echo '<form action="confirm" method="post">';
                              echo sprintf('<button class="btn btn-info" type="submit" name="lesson_id" value="%s">%s</button>',
                                          $lesson_id,
                                          // $datetime,
                                          //$value1[$i], 
                                          date("n月j日H時i分",strtotime($datetime))
                                          //date("n月j日H時i分",strtotime($value1[$i]))
                                          );
                              echo "<br>";
                              // echo "<br>";
                              echo sprintf('<input type="hidden" name="%s" value="%s">',
                                            $lesson_id,
                                            $lesson_id
                                            );
                              echo '</form> ';
                              echo '</div>';
                              echo "</div>";
                          }
                        echo '</div>';
                        echo "</div>";
                      }
                  ?>
                  
    </div> <!-- media-row col-xs-12 bg-primary -->           
  </div><!-- class="row" -->

 
  <!-- お気に入り講師終了 -->
  <hr>

  <!-- 日付指定用のrow -->
  <div class="row">
    <p class="title_k">日付を指定して予約</p>
    <?php
      if (isset($_REQUEST)) {
         echo '<p>※<?php echo date("Y-m-d", strtotime($REQUEST));?></p>';
       } 
    ;?>
    
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

          <div class= "col-sm-6 col-xs-12 col-md-6 col-lg-4">
            <div class="well">
              <div class="media" >
                <!-- 講師の写真表示 -->
                <?php 
                    if (isset($all_lesson["nickname"])) {
                      echo sprintf('<img src="../../views/user/user_picture/%s" alt="画像" width="80" height="80" style="float:left"><p>%s先生</p>',
                                    $all_lesson["picture"],
                                    // "default.png",
                                    $all_lesson["nickname"]
                                    // "Daisy"
                                  );
                    }
                    // お気に入り登録の重複確認
                    $sql = sprintf('SELECT count(*) AS cnt FROM teacher_likes WHERE student_id=%d AND teacher_id=%d',
                                    $_SESSION["join"]["id"],
                                    $all_lesson["id"]
                                    );
                    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
                    $table = mysqli_fetch_assoc($record);
                    if ($table["cnt"] > 0) {
                        $error["like"] = "duplicate";
                    }
                    
                ?>

                <div class="media-body" >
                  <!-- 予約可能時間帯の表示 -->
                    <?php if (isset($all_lesson["lesson_id"])) :?>
                        <form action="confirm" method="post">
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
              </div>
            </div>
          </div>
      <?php endwhile; ?>
    </div>
</div>
