<?php
    if (isset($_POST['submit'])){
        var_dump($_POST);
        $sql = sprintf(
            'INSERT INTO candidates SET post_id=%d, agent_id=%d, insentive="%s", payment="%s", arrival_date="%s", created=NOw()',
            $_REQUEST['id'],
            $_SESSION['login_id'],
            $_POST['request_insentive'],
            $_POST['request_payment'],
            $_POST['arrival_date']
        );
        mysqli_query($db,$sql) or die (mysqli_error($db));
    }

?>
<form action=""method='post'enctype="multipart/form-data">
  <p>受け入れ内容</p>
  <span>謝礼</span>
  <input type="text" name="insentive">
  <span>経費</span>
  <input type="text" name="payment">
  <span>到着日</span>
  <input type="date" name="arrival_date">
  <input type="submit" name="submui">
</form>
