<?php
    $db = mysqli_connect("localhost", "root", "mysql","nexseed_link");
    // ログイン中ユーザーのお気に入り講師情報を呼び出す
    
    $sql_like_teachers = sprintf('SELECT users.id, users.nickname, users.picture, teacher_likes.student_id, lessons.date, lessons.teacher_id 
                                  AS "lessons_teacher_id", lessons.student_id AS "lessons_student_id", lessons.reserve_status_id, lesson_times.time 
                                  FROM users INNER JOIN teacher_likes ON users.id=teacher_likes.teacher_id AND teacher_likes.student_id=%d 
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
    
    //配列の用意
    $lessons_ary = "";
 

?>

<div class="container">
  <div class="row">
    <!-- メイン画面 -->
    <div class="col-md-8">
      <!-- お気に入り講師一覧のrow -->
      <div class="row">
          <!-- <p>お気に入り講師から予約</p> -->
          <div class="col-md-4"> 
            <div class="col-md-6"> 
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
                                      $like_teacher['nickname'] => $like_teacher['date']." ".$like_teacher["time"]  // 日時を連結させていれる
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

                    <!-- お気に入り講師の写真表示 -->
                    <?php 
                      // echo sprintf('<img src="../../views/member/user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                      //                  $like_teacher["picture"],
                      //                  $like_teacher["nickname"]
                      //                );
                    ?>

                    <!-- お気に入り解除ボタンの表示 -->
                    <!-- <form action="" method="post">
                      <input type="hidden" name="id" value="<?php echo $like_teacher["id"]; ?>" >
                      <input type="submit" name="like" value="お気に入り解除">
                    </form> -->
            </div><!-- <div class="col-md-6"> -->

           
            <div class="col-md-6">

                <!-- お気に入り講師からの予約フォーム -->
                
            
                <form action="confirm" method="post">
                  <?php 
                      foreach ($data as $key1 => $value1) {
                          echo $key1;
                          echo "<br>";
                          // var_dump($value1);
                          // foreach ($value1 as $key2 => $value2) {
                          //     // var_dump($value1);
                          //     // echo "<br>";
                          //     echo $key2;
                          //     echo $value2;
                          //     echo "<br>";
                          // }
                          for ($i = 0; $i < count($value1); $i++) { 
                              // echo $value1[$i];
                              // echo "<br>";
                              // echo $value1["$i"]."<br>";
                              echo sprintf('<button type="submit" name="date" value="%s">%s</button>',
                                          $value1[$i], // データをスペース区切りで分解する
                                          date("n月j日H時i分",strtotime($value1[$i]))
                                          );
                              echo "<br>";
                          }
                      }
                  ?>
                  <input type="hidden" name="lesson_id" value="">
                  <input type="hidden" name="student_id" value="">
                </form> 
            </div>

            <hr>
            
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
