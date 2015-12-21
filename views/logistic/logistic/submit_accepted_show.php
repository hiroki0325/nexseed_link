<?php
    $sql = sprintf(
        'SELECT p.thing, c.insentive, c.payment, c.arrival_date FROM logistic_posts p , candidates c
         WHERE p.candidate_id=c.id AND c.agent_id=%d',
         $_SESSION['login_id']
    );
    $accepted_requests = mysqli_query($db, $sql) or die (mysqli_error($db));
?>


<header id="form_header">
  <div class="container-fluid no-gutter row-nopadding">
    <div class="no-gutter row-nopadding">
      <div class="col-lg-6 col-lg-offset-3 ">    
        <div class="form_layout accepted_request_list">
          <h3>あなたからセブへのお届け物はこちら</h3>
          <?php while ($accepted_request=mysqli_fetch_assoc($accepted_requests)):?>        
            <?php if(isset($accepted_request)):?>
              <div class="notice notice-info">
                <strong>持ち物</strong><?php echo $accepted_request['thing']?>
              </div>          
              <div class="notice notice-info">
                <strong>必要な金額</strong><?php echo $accepted_request['payment']?>
              </div>
              <div class="notice notice-info">
                <strong>到着日</strong><?php echo $accepted_request['arrival_date']?>
              </div>
            <?php endif;?>
        <?php endwhile;?>
        </div>  
      </div>
    </div>   
  </div>
</header>

