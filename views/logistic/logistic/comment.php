
<?php
    $post_id = $_REQUEST['id'];
    $user_id = $_SESSION['login_id'];
    if (!empty($_POST)) {
        //入力漏れエラー判定
        if ($_POST['comment']  == '') {
            $error['comment'] = 'Blanck';
        }
         
        //画像ファイルの拡張子に対してのエラー判定
        if (isset($_FILES)) { 
            $filename = $_FILES['comment_image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png') {
                $error_image = 'type';
            }
        }
        //画像をファイルにアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $comment_image = $filename;  
                move_uploaded_file($_FILES['comment_image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/logistic/comment_image/'.$comment_image);  
            }
        }
        //エラーがない場合logistic_postsにinsert
        if (empty($error)) {
            $sql = sprintf('INSERT INTO comments 
                SET post_id=%d, user_id="%s", comment="%s", comment_image="%s", created=NOW()',
                mysqli_real_escape_string($db, $post_id),
                mysqli_real_escape_string($db, $user_id),
                mysqli_real_escape_string($db, $_POST['comment']),
                mysqli_real_escape_string($db, $_FILES['comment_image']['name'])
            );
            mysqli_query($db, $sql) or die (mysqli_error($db));
        } 
    } 
    $sql = sprintf(
        'SELECT * FROM comments WHERE post_id=%d ORDER BY created DESC',
        $_REQUEST['id']
    );
    $comments = mysqli_query($db, $sql) or die (mysqli_error($db));
?>
<!-- 投稿に対するコメントの入力フォーム -->
<div class="container">
  <div class="row">
    <div class="col-md-offset-3 col-lg-offset-3">
      <div class="widget-area no-padding blank">
        <div class="status-upload" style="width: 600px;">
          <form action="" method="post" enctype="multipart/form-data" >
            <?php if (isset($error['comment'])):?>
              <textarea ype="text" name="comment" placeholder="コメントを入力してください" ></textarea>
            <?php else:?>
              <textarea ype="text" name="comment" placeholder="コメントを投稿します。" ></textarea>
            <?php endif; ?>
            <input type="file" name="comment_image">
            <button type="submit" class="btn btn-success green"><i class="fa fa-share"></i>コメントする</button>
          </form>
        </div>
      </div>
    </div>    
  </div>
</div>
<!-- コメントの表示 -->
<?php while($comment = mysqli_fetch_assoc($comments)):?>
  <div class="container content">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="testimonials">
          <div class="active item">
            <blockquote>
              <p><?php echo $comment['user_id'].' '.$comment['comment'];?></p>
              <?php if(!empty($comment['comment_image'])):?>
                <img src="../../views/logistic/logistic/comment_image/<?php echo $comment['comment_image']?>">
              <?php endif; ?>
              <p>[<a href="comment_delete?id=<?php echo $comment['id']?>" onClick="disp()">削除</a>]</p>
            </blockquote>         
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile;?>
  
