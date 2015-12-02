<?php
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
            $error['payment'] = 'Blanck';
        }
        if ($_POST['due']  == '') {
            $error['due'] = 'Blanck';
        }
        //画像ファイルの拡張子に対してのエラー判定
        if (isset($_FILES)) { 
            $filename = $_FILES['image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png') {
                $error_image = 'type';
            }
        }
        //画像をファイルにアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                move_uploaded_file($_FILES['image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/logistic/image_thing/'.$image);  
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
            mysqli_query($db, $sql) or die (mysqli_error($db));
            $post_check = 'OK';
        } else {
            $post_check = 'NO';
        }
    }
?>
<span>新入生に日本からの救援物資を依頼できます。</span>
<div class="post_form">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="thing_form">
      <p>
        <span>日本から持ってきてもらいたいもの(必須)</span>
        <?php if (isset($error['thing'])):?>
          <input type="text" name="thing">
          <span>ご記入ください。</span>
        <?php elseif (isset($error)):?> 
          <input type="text" name="thing" value="<?php echo $_POST['thing']?>"> 
        <?php else : ?>
          <input type="text" name="thing">
        <?php endif; ?>
        <span>カテゴリーを選択</span>
        <select name="category">
          <option value="書籍">書籍</option>
          <option value="食べ物">食べ物</option>
          <option value="衣類">衣類</option>
          <option value="アメニティ">アメニティ</option>
        </select>
      </p>
    </div>
    <div class="image_form">
      <p>
        <span>イメージ画像を入力</span>
        <input type="file" name="image"> 
        <span>いつまでに欲しい?（必須）</span>
        <?php if (isset($error['due'])):?>
          <input type="date" name="due">
          <span>ご記入ください。</span> 
        <?php elseif (isset($error)):?>
          <input type="date" name="due" value="<?php echo $_POST['due']?>"> 
        <?php else : ?>
          <input type="date" name="due">
        <?php endif; ?>
      </p>
    </div>
    <div class="info_form">
      <p>
        <span>謝礼を入力 (必須)</span>
        <?php if (isset($error['insentive'])):?>
          <input type="text" name="insentive">
          <span>ご記入ください。</span> 
        <?php elseif (isset($error)):?>
          <input type="text" name="insentive" value="<?php echo $_POST['insentive']?>">
        <?php elseif (empty($error['insentive'])): ?>
          <input type="text" name="insentive">
        <?php endif; ?>
        <span>お支払いする金額を入力（必須）</span>
        <?php if (isset($error['payment'])):?>
          <input type="text" name="payment" placeholder="pessoで入力してください">
          <span>ご記入ください。</span> 
        <?php elseif (isset($error)):?>
          <input type="text" name="payment" value="<?php echo $_POST['payment']?>">
        <?php else : ?>
          <input type="text" name="payment" placeholder="pessoで入力してください">
        <?php endif; ?>
      </p>
    </div>
    <input type="submit" name="form">
  </form>
</div>
<!-- 投稿が成功できたらデータを表示 -->
<?php if (isset($post_check)) { ?>
  <?php if($post_check == 'OK'): ?>
    <div>
      <h3>投稿できたデータはこちらです</h3>
      <p><?php echo h($_POST['thing'])?></p>
      <?php if (isset($image)):?>
        <img src="../../views/logistic/logistic/image_thing/<?php echo h($image)?>" width=100 hight=100>
      <?php else: ?>
        <p>画像は登録されていません</p>
      <?php endif; ?>
      <p>カテゴリー:<?php echo h($_POST['category'])?></p>
      <p><?php echo h($_POST['insentive'])?></p>
      <p><?php echo h($_POST['payment'])?>pesso</p>
      <p>期限:<?php echo h($_POST['due'])?></p>
    </div> 
  <?php elseif ($post_check == 'NO'):?>
    <h3>投稿内容を確認してください</h3>
  <?php endif; ?>
<?php } ?>
