<?php
    //ランダム英数字文字列の作成
    function makeRandStr($length) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str))];
        }
        return $r_str;
    }

    //time関数用の設定
    date_default_timezone_set('Asia/Tokyo');

    // SELECT文でlessonsからidで指定して全カラム取得
    // UPDATE文でlessonsのidが一致するもののstudent_idとstatusを変更
    if (isset($_POST)) {
        $sql = sprintf('SELECT * FROM lessons WHERE id=%d',
                      $_POST["lessons_id"]
                      );
        $lesson = mysqli_query($db, $sql)or die(mysqli_error($db));
        $lesson = mysqli_fetch_assoc($lesson);
    }

    if (isset($_POST["confirm"])) {
        if ($_POST["confirm"] == "on") {
              //乱数生成関数の呼び出し
              $radomStr = makeRandStr(8);

              //レッスンテーブルのアップデート
              $sql = sprintf('UPDATE lessons SET student_id=%d, reserve_status_id=2, rand_str = "%s", modified=NOW() WHERE id=%d',
                            $_SESSION["join"]["id"],
                            $radomStr,
                            $_POST["lessons_id"]
              );
              mysqli_query($db, $sql)or die(mysqli_error($db));
              header('Location: thanks');
              exit();
        }
    }
?>

<div class="container">

  <div class="row">
    <h1>予約情報の確認</h1>
  </div>
  

  <div class="row">
    <img src="" alt="">
    <?php
        if (isset($lesson["id"])) {
            // echo $lesson["date"];
            // echo "<br>";
            echo date("n月j日", strtotime($lesson["date"]));
            echo $lesson['time_id'];
            echo "<br>";
            // echo date("H時i分", strtotime($_POST["time"]));
        }

    ?>
  </div>

  <div class="row">
    <p>※必ず内容をご確認の上で、「予約する」ボタンを押してください。</p>
    <input type="button" value="選択画面に戻る" onClick="document.location='reserve';">
    <?php if(isset($_POST["lessons_id"])) : ?>
        <form action="" method="post">       
          <input type="hidden" name="lessons_id" value="<?php echo $_POST["lessons_id"]; ?>" >
          <input type="hidden" name="confirm" value="on">
          <input type="submit" value="予約する">
        </form>
    <?php endif ;?>
  </div>
</div>

