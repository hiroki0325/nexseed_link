<link rel="stylesheet" href="../assets/css/logistic.css">

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
                $error['image'] = 'type';
            }
        }
        //画像をファイルにアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                move_uploaded_file($_FILES['image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/student_cebu/image_thing/'.$image);  
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
            $post_data = mysqli_query($db, $sql) or die (mysqli_error($db));
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


<span>新入生に日本からの救援物資を依頼できます。</span>
<div class="post_form">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="thing_form">
      <p>
        <span>日本から持ってきてもらいたいもの</span>
        <input type="text" name="thing"> 
        <?php if (isset($error['thing'])):?>
            <p>必須項目です</p>
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

        <span>いつまでに欲しい?</span>
        <input type="date" name="due">
        <?php if (isset($error['due'])):?>
            <p>必須項目です</p>
        <?php endif; ?>
      </p>
    </div>

    <div class="info_form">
      <p>
        <span>謝礼を入力</span>
        <input type="text" name="insentive"> 
        <?php if (isset($error['insentive'])):?>
            <p>必須項目です</p>
        <?php endif; ?>

        <span>お支払いする金額を入力</span>
        <input type="text" name="payment" placeholder="pessoで入力してください"> 
        <?php if (isset($error['payment'])):?>
            <p>必須項目です</p>
        <?php endif; ?>
      </p>
    </div>

    <input type="submit" name="form">
  </form>
</div>

<?php if (isset($_POST['form'])) { ?>
   <div>
     <p><?php echo h($_POST['thing'])?></p>
     <img src="../../views/logistic/student_cebu/image_thing/<?php echo h($image)?>" width=100 hight=100>
     <p>カテゴリー:<?php echo h($_POST['category'])?></p>
     <p><?php echo h($_POST['insentive'])?></p>
     <p><?php echo h($_POST['payment'])?>pesso</p>
     <p>期限:<?php echo h($_POST['due'])?></p>
   </div> 
<?php } ?>

<!-- 表示の切り替え -->
<div class="sort_tab">
  <form action="" method="post">
    <input type="submit" name="accepted" value="承認済みのみ表示">
    <input type="submit" name="unaccepted" value="承認待ちのみ表示">
  </form>
<div>
         
<!-- 承認済みデータの表示 -->
<?php if (isset($_POST['accepted']) || empty($_POST)):?>
    <h4>承認済み依頼</h4>
    <?php while ($post=mysqli_fetch_assoc($accepted_posts)):?>
        <div>
          <p><?php echo h($post['thing'])?></p>
          <img src="../../views/logistic/student_cebu/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
          <p>カテゴリー:<?php echo h($post['category'])?></p>
          <p><?php echo h($post['insentive'])?></p>
          <p><?php echo h($post['payment'])?> pessos</p>
          <p>期限:<?php echo h($post['due'])?></p>
          <p>投稿日:<?php echo h($post['created'])?></p> 
          [<a href="../student_nexseed/show?id=<?php echo h($post['id'])?>">show</a>]
        </div>
    <?php endwhile;?>

<?php elseif (isset($_POST['unaccepted'])):?>
<!-- 承認待ちデータの表示 -->

    <h4>承認待ち依頼</h4>
    <?php while ($post=mysqli_fetch_assoc($unverified_posts)):?>
        <div>
          <p><?php echo h($post['thing'])?></p>
          <img src="../../views/logistic/student_cebu/image_thing/<?php echo h($post['image'])?>" width=100 hight=100>
          <p>カテゴリー:<?php echo h($post['category'])?></p>
          <p><?php echo h($post['insentive'])?></p>
          <p><?php echo h($post['payment'])?>pesso</p>
          <p>期限:<?php echo h($post['due'])?></p>
          <p>投稿日:<?php echo h($post['created'])?></p>
          [<a href="../student_nexseed/show?id=<?php echo h($post['id'])?>">show</a>]
        </div>
    <?php endwhile;?>
<?php endif; ?>

