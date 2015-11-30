<?php
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
    if(!empty($_POST['update'])) {
        if ($_SESSION['thing'] != $_POST['thing']) {
            $_SESSION['thing'] = $_POST['thing'];
        }
        if ($_SESSION['category'] != $_POST['category']) {
            $_SESSION['category'] = $_POST['category'];
        }

        if ($_SESSION['insentive'] != $_POST['insentive']) {
            $_SESSION['insentive'] = $_POST['insentive'];
        }
        if ($_SESSION['payment'] != $_POST['payment']) {
            $_SESSION['payment'] = $_POST['payment'];
        }
        if ($_SESSION['due'] != $_POST['due']) {
            $_SESSION['due'] = $_POST['due'];
        }

        if (!empty($_FILES)) {
            $filename = $_FILES['image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png'){
                $error['image'] = 'type';
            }
        }
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                move_uploaded_file($_FILES['image']['tmp_name'],'thing_image/'.$image);  
      
                if($_SESSION['image'] != $_FILES['image']['name']){
                    $new_image = $_FILES['image']['name'];
                    $_SESSION['new_image'] = $new_image;
                    $image = "image_thing/".$new_image; 
                } 
            }
        } else {
            $new_image = $_SESSION['image'];
            $_SESSION['new_image'] = $new_image;
        }
    }
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
                move_uploaded_file($_FILES['comment_image']['tmp_name'],'comment_image/'.$image);           
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

    //依頼requestのインサート
    if (isset($_POST['request'])){
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

<h2>投稿の内容を確認しましょう</h2>
<div>
  <p><?php echo $_SESSION['thing']; ?></p>
  <p><?php echo $_SESSION['category']; ?></p>
  <p><?php echo $_SESSION['insentive']; ?></p>
  <p><?php echo $_SESSION['payment']; ?></p>
  <p><?php echo $_SESSION['due']; ?></p>
  <img src= "<?php echo sprintf('../../views/logistic/'.'%s',$image); ?>" >
</div>

<!-- 投稿の編集form バリデーション済み -->
<h2>投稿の編集はこちら</h2>
<div>
  <form action="" method="post" enctype="multipart/form-data" >
    <input type="text" name="thing" value="<?php echo $_SESSION['thing']; ?>">
    <select name="category" >
      <option value="<?php echo $_SESSION['category'] ;?>"><?php echo $_SESSION['category'] ;?></option>
      <option value="書籍">書籍</option>
      <option value="食べ物">食べ物</option>
      <option value="衣類">衣類</option>
      <option value="アメニティ">アメニティ</option>
    </select>
    <input type="text" name="insentive" value="<?php echo $_SESSION['insentive']; ?>">
    <input type="text" name="payment" value="<?php echo $_SESSION['payment']; ?>">
    <input type="date" name="due" value="<?php echo $_SESSION['due']; ?>">
    <input type="file" name="image">
    <input type= "submit" value="編集を確認" name="update">
  </form>
</div>
<!-- 編集と削除のトリガー -->
<div>
    <?php if (!empty($_POST)):?>
        <a href="update?id=<?php echo $_REQUEST['id']?>">編集を実行</a>
    <?php endif ; ?>
    <a href="delete?id=<?php echo $_REQUEST['id']?>">削除を実行</a>
</div>

<!-- 承認依頼フォーム -->
<div>
    <h2>引き受ける際の条件を記入しましょう</h2>
    <form action="" method="post">
        <input type="text" name="request_insentive">
        <input type="text" name="request_payment">
        <input type="date" name="arrival_date">
        <input type="submit" name="request">
    </form>
</div>

<!-- 投稿に対するコメント -->
<form action=""method='post'enctype="multipart/form-data">
  <p>コメントを入力します</p>
  <input type="text" name="comment">
  <input type="file" name="comment_image">
  <input type="submit" name="comment_push">
</form>
<?php while($comment = mysqli_fetch_assoc($comments)):?>
    <p><?php echo $comment['user_id'].' '.$comment['comment'];?></p>
    <?php if(!empty($comment['comment_image'])):?>
        <img src="comment_image/<?php echo $comment['comment_image']?>">
    <?php endif; ?>
    [<a href="comment_delete?id=<?php echo $comment['id']?>">削除</a>]
<?php endwhile;?>
  
