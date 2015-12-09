<script type='text/javascript'>
  function disp(){
    // 「OK」時の処理開始 ＋ 確認ダイアログの表示
    if(window.confirm('削除してよろしいですか？')){
      location.href = "<?php echo sprintf ('request_delete?id=%d',$_REQUEST['id']);?>"; 
    } 
    // 「キャンセル」時の処理開始
    else{
      window.alert('キャンセルされました'); // 警告ダイアログを表示
    }
    // 「キャンセル」時の処理終了
  }
</script>
<?php
    //ページの表示
    //投稿内容の編集
    //投稿の削除
    //編集はpopup表示
    //削除は確認画面の作成
    //コメントの挿入
    //コメント投稿フォームの作成
     
    $sql = sprintf(
        'SELECT * FROM logistic_posts WHERE id=%d',
        $_REQUEST['id']
    );
    $sql = mysqli_query($db,$sql) or die (mysqli_error($db));
    $post = mysqli_fetch_assoc($sql);

    $_SESSION['thing'] = $post['thing'];
    $_SESSION['category'] = $post['category'];
    $_SESSION['insentive'] = $post['insentive'];
    $_SESSION['payment'] = $post['payment'];
    $_SESSION['due'] = $post['due'];
    $_SESSION['created'] = $post['created'];
    $_SESSION['image'] = $post['image'];
    $image = "image_thing/".$_SESSION['image'];

    //postsの編集があった場合のアップデート
    
    //コメントに画像を挿入する場合の画像拡張子でのエラー判定
    if (!empty($_POST['comment_push'])) {
        if (!empty($_FILES)){
            $filename = $_FILES['comment_image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png') {
                $error['comment_image'] = 'type';
            }
        }
        //コメント画像のアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                move_uploaded_file($_FILES['comment_image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/logistic/comment_image/'.$image);           
            } 
        }

        //コメントのinsert
        $sql = sprintf(
            'INSERT INTO comments SET post_id=%d, user_id=%d, comment="%s", comment_image="%s",created=NOW()',
            $_REQUEST['id'],
            $_SESSION['login_id'],
            $_POST['comment'],
            $_FILES['comment_image']['name']
        );
        mysqli_query($db,$sql) or die (mysqli_error($db));
    }
    //コメントの表示
    $sql = sprintf('SELECT * FROM comments WHERE post_id=%d',
        $_REQUEST['id']
    );
    $comments = mysqli_query($db,$sql) or die (mysqli_error($db));

?>
<a href="top">物流topへ</a>
<div class="show">
  <div class="show_block">
    <div class="show_row">
      <span>[お願いしたいもの]</span>
      <p><?php echo $_SESSION['thing']; ?></p>
    </div>
    <div class="show_row">
      <span>[カテゴリー]</span>
      <p><?php echo $_SESSION['category']; ?></p>
    </div>
    <div class="show_row">
      <span>[謝礼]</span>
      <p><?php echo $_SESSION['insentive']; ?></p>   
    </div>
    <div class="show_row">
      <span>[必要な金額]</span>
      <p><?php echo $_SESSION['payment']; ?></p>
    </div>
    <div class="show_row">
      <span>[期限]</span>
      <p><?php echo $_SESSION['due']; ?></p>
    </div>
  </div>
  <div class="show_image">
    <p>[イメージ画像]</p>
    <img src= "<?php echo sprintf('../../views/logistic/logistic/'.'%s',$image); ?>" class="show_picture">
  </div> 
</div>
<div class="button">
  <a data-target="con1" class="modal-open">投稿の編集</a>
  <?php echo '<input type="button" value="投稿を削除" onClick="disp()">';?>
</div>

<div id="con1" class="modal-content">
  <?php include('request_update.php');?>
  <p><a class="modal-close">閉じる</a></p>
</div>
<?php  include('comment.php'); ?>






