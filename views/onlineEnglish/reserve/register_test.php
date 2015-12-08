<?php

    //仮のアカウント情報設定
    $_SESSION["join"]["id"] = 38;
    $_SESSION["join"]["picture"]["name"] = "default2.png";
    $_SESSION["join"]["eg_name"] = "koichi";

    $available_times = array("18:00 - 18:30", "18:30 - 19:00", "19:00 - 19:30", "19:30 - 20:30");
    var_dump($_POST);

?>

<!-- 日付指定用のrow -->
<div class="container">
  <div class="row">
    <p>choose date</p>
    <div class="col-md-12">
      <ul>
      <?php
          for ($i=0; $i <=10 ; $i++) { 
            echo sprintf("<li style=".'display:inline;'.">"."<a href='register_test?date=%s'>"."%s"."</a>"."</li>",
            date("Ymd", strtotime("+$i day")),
            date("n/j(D)", strtotime("+$i day"))
            );
          }
          
      ?>
      </ul>
    </div>
  </div>

  <div class="row">
    <p>choose time</p>
    <div class="col-md-12">
      <form action="" method="post">
        <select name="lesson_time">
        <?php
            foreach ($available_times as $available_time) {
              echo sprintf('<option value="%s">%s</option>',$available_time, $available_time);
            }
            echo sprintf('<input type="hidden" name="teacher_id" value="%s">', $_SESSION['join']['id']);

        ?>
        </select>
        <input type="submit" value="register">

      </form>
    </div>
  </div>
</div>








 
