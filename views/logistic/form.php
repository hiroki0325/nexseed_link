 
<?php
    
    include('dbconnect.php');
    //文字入力のバグ対応
    
    //use_idを仮設定
    $_SESSION['login_id'] = 1;
    
    //入力のエラー判定
    if (!empty($_POST['form'])) {
        //入力漏れエラー判定
        if ($_POST['thing']  == '') {
            $error['thing'] = 'Blanck';
        }
        if ($_POST['insentive']  == '') {
            $error['insentive'] = 'Blanck';
        }
        if ($_POST['payment']  == '') {
            $error['payment']= 'Blanck';
        }
        if ($_POST['due']  == '') {
            $error['due']= 'Blanck';
        }
        //画像ファイルの拡張子に対してのエラー判定
        if (isset($_FILES)) { 
            $filename = $_FILES['image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png') {
                $error['image'] = 'type';
            }
        }
        //画像をファイルにアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                var_dump($image);
                move_uploaded_file($_FILES['image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/image_thing/'.$image);  
            }
        }
        //エラーがない場合logistic_postsにinsert
        if (empty($error)) {
            $sql = sprintf('INSERT INTO logistic_posts 
                SET client_id=%d, thing="%s", category="%s", image="%s", insentive="%s", payment="%s", due="%s", created=NOW()',
                mysqli_real_escape_string($db, $_SESSION['login_id']),
                mysqli_real_escape_string($db, $_POST['thing']),
                mysqli_real_escape_string($db, $_POST['category']),
                mysqli_real_escape_string($db, $_FILES['image']['name']),
                mysqli_real_escape_string($db, $_POST['insentive']),
                mysqli_real_escape_string($db, $_POST['payment']),
                mysqli_real_escape_string($db, $_POST['due'])
            );
            $sql = mysqli_query($db, $sql) or die (mysqli_error($db));
            echo 'データが挿入されました';
        } else {
           var_dump($error);
        }
    }

    //データの表示
    //承認されたデータのみ
    $sql = sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND candidate_id IS NOT NULL ORDER BY due ASC',
       $_SESSION['login_id']
    );
    $accepted_posts = mysqli_query($db, $sql) or die (mysqli_error($db));

    //承認されていないデータのみ
    $sql = sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND candidate_id IS NULL ORDER BY due ASC',
       $_SESSION['login_id']
    );
    $unverified_posts = mysqli_query($db, $sql) or die (mysqli_error($db));


?>

<!DOCTYPE html >
<html  lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>logistic mypage</title>
  </head>
  <body>
    <h3>欲しいものを登録しましょう</h3>
    <form action="" method="post" enctype="multipart/form-data">

      <h3>欲しいものを入力しましょう</h3>
      <input type="text" name="thing"> 
      <?php if (isset($error['thing'])):?>
          <p>必須項目です</p>
      <?php endif; ?>

      <h3>カテゴリーを選択します</h3>
      <select name="category">
        <option value="書籍">書籍</option>
        <option value="食べ物">食べ物</option>
        <option value="衣類">衣類</option>
        <option value="アメニティ">アメニティ</option>
      </select>

      <h3>イメージ画像を登録しましょう</h3>
      <input type="file" name="image"> 
      <h3>お礼を記入しましょう</h3>
      <input type="text" name="insentive"> 
      <?php if (isset($error['insentive'])):?>
          <p>必須項目です</p>
      <?php endif; ?>

      <h3>必要な金額を入力しましょう</h3>
      <input type="text" name="payment"> 
      <?php if (isset($error['payment'])):?>
          <p>必須項目です</p>
      <?php endif; ?>

      <h3>いつまでに欲しいか選択しましょう</h3>
      <input type="date" name="due">
      <?php if (isset($error['due'])):?>
          <p>必須項目です</p>
      <?php endif; ?>
      <input type="submit" name="form">
    </form>
    
    <!-- 表示の切り替え -->
    <form action="" method="post">
      <input type="submit" name="accepted" value="承認済みのみ表示">
      <input type="submit" name="unaccepted" value="承認待ちのみ表示">
    </form>
             
    <!-- 承認済みデータの表示 -->
    <?php if (isset($_POST['accepted']) || empty($_POST)):?>
        <h4>承認済み依頼</h4>
        <?php while ($post=mysqli_fetch_assoc($accepted_posts)):?>
            <div>
              <img src="../views/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
              <p><?php echo h($post['thing'])?></p>
              <p><?php echo h($post['category'])?></p>
              <p><?php echo h($post['insentive'])?></p>
              <p><?php echo h($post['payment'])?></p>
              <p><?php echo h($post['due'])?></p>
              <p><?php echo h($post['created'])?></p> 
              [<a href="show?id=<?php echo h($post['id'])?>">show</a>]
            </div>
        <?php endwhile;?>

    <?php elseif (isset($_POST['unaccepted'])):?>
    <!-- 承認待ちデータの表示 -->
  
        <h4>承認待ち依頼</h4>
        <?php while ($post=mysqli_fetch_assoc($unverified_posts)):?>
            <div>
              <img src="../views/logistic/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
              <p><?php echo h($post['thing'])?></p>
              <p><?php echo h($post['category'])?></p>
              <p><?php echo h($post['insentive'])?></p>
              <p><?php echo h($post['payment'])?></p>
              <p><?php echo h($post['due'])?></p>
              <p><?php echo h($post['created'])?></p>
              [<a href="show?id=<?php echo h($post['id'])?>">show</a>]
            </div>
        <?php endwhile;?>
    <?php endif; ?>
  </body>
</html>
