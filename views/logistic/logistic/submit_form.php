<?php
    if(empty($_POST["comment"])){
        if (isset($_POST['request_insentive']) && isset($_POST['request_payment']) && isset($_POST['request_arrival_date'])){
            $sql = 'SELECT id FROM logistic_posts WHERE candidate_id IS NOT NULL';
            $candidates = mysqli_query($db,$sql) or die (mysqli_error($db));
            $post_check = array();
            while ($candidate = mysqli_fetch_assoc($candidates)) {
                $post_check = $candidate;
            }
            if (in_array($_REQUEST['id'], $post_check) == false){
                $sql = sprintf(
                    'INSERT INTO candidates SET post_id=%d, agent_id=%d, insentive="%s", payment="%s", arrival_date="%s", created=NOw()',
                    $_REQUEST['id'],
                    $_SESSION['login_id'],
                    $_POST['request_insentive'],
                    $_POST['request_payment'],
                    $_POST['request_arrival_date']
                );
                mysqli_query($db,$sql) or die (mysqli_error($db));  
                echo "リクエストを送信しました";      
            } else {
                $error = 'alredy';
            }  
        }   
    } 
    
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-xs-12 button-field">
      <h4>受け入れのリクエストを送信します。</h4>
      <form action=""method='post'enctype="multipart/form-data">
        <fieldset>
          <span>謝礼</span>
          <input type="text" name="request_insentive" class="input-block-level" placeholder="承諾するおかえしを記入しましょう">
          <p>経費</p>
          <input type="number" name="request_payment" class="input-block-level" placeholder="pessoで入力してください" style="width:500px;">
          <p>到着日</p>
          <input type="date" name="request_arrival_date" class="input-block-level" style="width:500px;">
          <button type="submit" class="btn btn-warning pull-right">Submit</button>
        </fieldset>
      </form>
      <?php if (isset($error) && $error=='alredy'):?>
        <h4>この投稿に対するリクエストは締め切られました</h4>
      <?php endif; ?>
    </div>
  </div>
</div>
