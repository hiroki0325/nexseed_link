<!-- その投稿がすでに承認されている場合個別ページで受け入れ内容を表示 -->
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <?php echo'<h3>この投稿はすでに受け入れが決まっています</h3>';?>
      <div class="alert alert-info">
        <strong>お届け物へのお礼:</strong><?php echo $accepted_candidate['insentive']; ?>
      </div>
      <div class="alert alert-success">
        <strong>準備に必要な経費:</strong><?php echo $accepted_candidate['payment']; ?>php
      </div> 
      <div class="alert alert-warning">
        <strong>お届けできる日にち:</strong><?php echo $accepted_candidate['arrival_date']; ?>
      </div>
    </div>
  </div>
</div>
