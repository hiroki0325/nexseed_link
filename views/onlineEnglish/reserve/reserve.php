<?php
    session_start();
    $_SESSION["join"]["id"] = 38;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["eg_name"] = "Daisy";


    $db = mysqli_connect("localhost", "root", "mysql","nexseed_link");
    // ログイン中ユーザーのお気に入り講師情報を呼び出す
    //現状複数人のお気に入りがいた場合、おかしなことになるはず
    $sql_like_teachers = sprintf('SELECT u.id, u.eg_name, u.picture, l.id AS "lesson_id", l.lesson_date FROM users u, teacher_likes t, lessons l WHERE t.user_id=%d AND t.teacher_id=u.id AND t.teacher_id=l.teacher_id AND l.reserve_status_id=1 AND l.lesson_date>NOW()+1',
                                $_SESSION["join"]["id"]
                             );
    $like_teachers = mysqli_query($db, $sql_like_teachers);
    //$like_teacher = mysqli_fetch_assoc($like_teachers);

    //指定した日付で予約可能な講師情報と予約可能時間帯を取得
    date_default_timezone_set('Asia/Tokyo');
    if (isset($_REQUEST["date"])) {
        $date = $_REQUEST["date"];
    }else{
        $date = date("m/j(D)", strtotime("+1 day"));
    }

    $sql_all_lessons = sprintf('SELECT u.id, u.eg_name, u.picture, l.id AS "lesson_id", l.lesson_date FROM users u,lessons l WHERE l.lesson_date=%d AND u.status_id=5 AND  l.reserve_status_id=1',
                                //$_REQUEST["date"]
                                20151126200000
                              );
    $all_lessons = mysqli_query($db, $sql_all_lessons);
    $all_lesson = mysqli_fetch_assoc($all_lessons);
    var_dump($_POST);

    if (isset($_POST["like"])) {
        if ($_POST["like"] == "お気に入り追加") {
            $sql = sprintf('INSERT INTO teacher_likes SET user_id=%d , teacher_id=%d , created=NOW()',
                          $_SESSION["join"]["id"],
                          $_POST["teacher_id"]
                          );
            mysqli_query($db, $sql);
        }elseif ($_POST["like"] == "お気に入り解除") {
            $sql = 'DELETE FROM teacher_likes WHERE user_id=10 AND teacher_id=10';
            mysqli_query($db, $sql);
        }
    }
    


    //予約情報の送信
    // if (isset($_POST["lesson_date"])) {
    //     $_SESSION["reserve"] = $_POST;
    //     $_SESSION["reserve"]["eg_name"] = $like_teacher["eg_name"];
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
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
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
                <?php 
                    if ($like_teacher = mysqli_fetch_assoc($like_teachers)){
                        echo sprintf('<img src="../user_picture/%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                                      $like_teacher["picture"],
                                      $like_teacher["eg_name"]
                                    );
                    }
                ?>
              </div>
              <div class="col-md-6">
                <!-- 予約可能時間帯の表示 -->
                <?php while ($like_teacher = mysqli_fetch_assoc($like_teachers)) :?>
                    <form action="confirm.php" method="post">
                      <input type="hidden" name="lesson_id" value="<?php echo $like_teacher["lesson_id"]; ?>" >
                      <input type="hidden" name="id" value="<?php echo $like_teacher["id"]; ?>" >
                      <input type="hidden" name="eg_name" value="<?php echo $like_teacher["eg_name"]; ?>" >
                      <input type="hidden" name="picture" value="<?php echo $like_teacher["picture"]; ?>" >
                      <button type="submit" name="lesson_date" value="<?php echo $like_teacher["lesson_date"];?>"><?php echo date("n月j日H時i分",strtotime($like_teacher["lesson_date"])) ;?></button>
                    </form>
                    
                <?php endwhile; ?>
                <form action="" method="post">
                  <input type="submit" name="like" value="お気に入り解除">
                </form>
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
                  echo sprintf("<li style=".'display:inline;'.">"."<a href='reserve.php?date=%s'>"."%s"."</a>"."</li>",
                  date("n/j(D)", strtotime("+$i day")),
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
                      echo sprintf('<img src="%s" alt="画像" width="80" height="80"><p>%s先生</p>',
                                    $all_lesson["picture"],
                                    // "default.png",
                                    $all_lesson["eg_name"]
                                    // "Daisy"
                                  );
                  ?>
                </div>
                <div class="col-md-6">
                  <!-- 予約可能時間帯の表示 -->
                  <form action="confirm.php" method="post">
                    <input type="hidden" name="lesson_id" value="<?php echo $all_lesson["lesson_id"]; ?>" >
                    <input type="hidden" name="eg_name" value="<?php echo $all_lesson["eg_name"]; ?>" >
                    <input type="hidden" name="picture" value="<?php echo $all_lesson["picture"]; ?>" >
                    <button type="submit" name="lesson_date" value="<?php echo $all_lesson["lesson_date"];?>"><?php echo date("H時i分",strtotime($all_lesson["lesson_date"])) ;?></button>
                  </form>
                  <form action="" method="post">
                    <input type="hidden" name="teacher_id" value="<?php echo $all_lesson["id"]; ?>" >
                    <input type="submit" name="like" value="お気に入り追加">
                  </form>
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
