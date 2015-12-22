   






<div class="container-fluid">
  <div class= "row"> 
    <div class= "media-row col-xs-12 bg-primary" style="margin-top:30px">
    <div class="list_title">
      <h3>届いているリクエストはこちら</h3>  
    </div>  
    <?php
        //
        $sql = sprintf('SELECT id FROM logistic_posts WHERE client_id=%d ORDER BY created DESC',$_SESSION['login_id']);
        $posts = mysqli_query($db,$sql) or die (mysqli_error($db));
        while ($post=mysqli_fetch_assoc($posts)) {
            $sql = sprintf('SELECT * FROM candidates WHERE post_id=%d AND desicion IS NULL ORDER BY created DESC',$post['id']);
            $requests = mysqli_query($db,$sql) or die (mysqli_error($db));
            while ($request=mysqli_fetch_assoc($requests)){
    ?>   
      <div class= "col-sm-6 col-xs-12 col-md-4 col-lg-4">
        <div class="well">
          <div class="media">
            <div class="media-body" >
              <div class="list-inline list-unstyled" style="float:left">
                <?php
                  $sql = sprintf('SELECT thing FROM logistic_posts WHERE id=%d',$request['post_id']);
                  $thing = mysqli_query($db,$sql) or die (mysqli_error($db));
                  $thing=mysqli_fetch_assoc($thing);
                ?>
                <span>[投稿した物]</span><h4><?php echo h($thing['thing']);?></h4>
                <ul><span>[お礼]</span><?php echo h($request['insentive']);?></ul>
                <ul><span>[必要経費]</span><?php echo h($request['payment']);?> pessos</ul>
                <ul><span>[到着日]</span><?php echo h($request['arrival_date']);?> </ul> 
                <ul><a href="show?id=<?php echo $request['post_id'];?>">投稿の詳細を確認する</a></ul>
                <ul><a href="submit_new?id=<?php echo $request['id'];?>">投稿を承認する</a></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php };?>
    <?php };?>  
    </div>
  </div>
</div>  


