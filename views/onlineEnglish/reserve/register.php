<?php
    $sql = 'SELECT * from lesson_times';
    $available_times = mysqli_query($db, $sql);

    if (isset($_POST["lesson_time"])) {
        $date = $_REQUEST['date'] .' '. $_POST["lesson_time"];
        $sql = sprintf('INSERT INTO lessons SET date="%s", time_id=%d, teacher_id=%s, reserve_status_id=%s, created=NOW()',
                  $date,
                  $_POST["lesson_time"],
                  $_POST["teacher_id"],
                  1
                  );
        mysqli_query($db,$sql) or die(mysqli_error($db));
    }
    

?>

<!-- 日付指定用のrow -->
<div class="container">
  <div class="row">
    <p>Choose Lesson date</p>
    <div class="col-md-12">
      <ul>
      <?php
          for ($i=0; $i <=10 ; $i++) { 
            echo sprintf("<li style=".'display:inline;'.">"."<a href='register_test?date=%s'>"."%s"."</a>"."</li>",
            date("Y-m-d", strtotime("+$i day")),
            date("n/j(D)", strtotime("+$i day"))
            );
          }
          
      ?>
      </ul>
    </div>
  </div>

  <div class="row">
    <p>Choose Bigining time</p>
    <div class="col-md-12">
      <form action="" method="post">
        <select name="lesson_time">
        <?php
            while ($available_time = mysqli_fetch_assoc($available_times)) {
                echo sprintf('<option value="%s">%s</option>',$available_time["id"], $available_time["time"]);
                
            }
            echo sprintf('<input type="hidden" name="teacher_id" value="%s">', $_SESSION['join']['id']);
        ?>
        </select>
        <input type="submit" value="register">
      </form>
    </div>
  </div>

  <div class="row">
    <a href="../../reserve/index/">To Adomin Top</a>
  </div>
</div>








 
