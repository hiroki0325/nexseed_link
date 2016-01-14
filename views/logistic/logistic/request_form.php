<?php
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
                move_uploaded_file($_FILES['image']['tmp_name'],"views/logistic/logistic/image_thing/".$image);
                //'../logistic/logistic/image_thing/' application.php
                //'views/logistic/logistic/image_thing/' routes.php
                //'../../views/logistic/logistic/image_thing/' 表示させている画像のパス


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
<!-- 投稿の入力フォーム -->
<header id="form_header">
  <div class="container-fluid no-gutter row-nopadding">
    <div class="no-gutter row-nopadding">
      <div class="col-lg-6 col-lg-offset-3 ">
        <h2 style="margin-top:20px;">日本からお届け物が届きます。</h2>
        <div class="form_layout">
          <span >持ってきてほしいものは何ですか？</span>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="panel-form">
              <?php if (isset($error['thing'])):?>
                <input type="text" name="thing">
                <span>ご記入ください。</span>
              <?php elseif (isset($error)):?> 
                <input type="text" name="thing" value="<?php echo $_POST['thing']?>"> 
              <?php else : ?>
                <input type="text" name="thing">
              <?php endif; ?>
            </div> 
            <span>カテゴリーを選択してください</span>
            <div class="panel-form" >
              <select name="category">
                <option value="書籍">書籍</option>
                <option value="食べ物">食べ物</option>
                <option value="衣類">衣類</option>
                <option value="アメニティ">アメニティ</option>
              </select>
            </div>
            <span>いつまでにほしいですか？</span> 
            <div class="panel-form">
              <?php if (isset($error['due'])):?>
                <input type="date" name="due">
                <span>ご記入ください。</span> 
              <?php elseif (isset($error)):?>
                <input type="date" name="due" value="<?php echo $_POST['due']?>"> 
              <?php else : ?>
                <input type="date" name="due">
              <?php endif; ?>
            </div>
            <span>ほしいものの参考画像を添付してください</span>
            <div class="panel-form">
              <input type="file" name="image" style="font-size:18px; height:25px"> 
            </div>
            <span >いくら払いますか（フィリピン・ペソで入力）</span>
            <div class="panel-form">
              <?php if (isset($error['payment'])):?>
                <input type="text" name="payment" placeholder="pessoで入力してください">
                <span>ご記入ください。</span> 
              <?php elseif (isset($error)):?>
                <input type="text" name="payment" value="<?php echo $_POST['payment']?>">
              <?php else : ?>
                <input type="text" name="payment" placeholder="pessoで入力してください">
              <?php endif; ?>
            </div>
            <span>持ってきてくれた場合の謝礼を記入します</span>
            <div class="panel-form">
              <?php if (isset($error['insentive'])):?>
                <input type="text" name="insentive">
                <span>ご記入ください。</span> 
              <?php elseif (isset($error)):?>
                <input type="text" name="insentive" value="<?php echo $_POST['insentive']?>">
              <?php elseif (empty($error['insentive'])): ?>
                <input type="text" name="insentive">
              <?php endif; ?>
            </div>
            <input type="submit" name="form" value="Post!" style="height: 31px; margin-top: 20px; padding-top: 0px;">
          </form>   
        </div>  
      </div>
    </div>   
  </div>
</header>
<!-- 投稿が成功できたらデータを表示 -->
<?php if (isset($post_check)) { ?>
  <section class="services">
    <div class="container-fluid">
      <div class= "row"> 
        <div class= "media-row col-xs-12" style="margin-top:30px">
          <?php if($post_check == 'OK'): ?>
            <div class="list-inline list-unstyled post_data">
              <h3>投稿できたデータはこちらです</h3>
                <h4>お願いしたいもの:<?php echo h($_POST['thing'])?></h4>
                <?php if (isset($image)):?>
                  <img src="../../views/logistic/logistic/image_thing/<?php echo h($image)?>" width=100 hight=100>
                <?php else: ?>
                  <ul>画像は登録されていません</ul>
                <?php endif; ?>
                <ul>カテゴリー:<?php echo h($_POST['category'])?></ul>
                <ul>謝礼:<?php echo h($_POST['insentive'])?></ul>
                <ul>必要金額:<?php echo h($_POST['payment'])?>pesso</ul>
                <ul>期限:<?php echo h($_POST['due'])?></ul>
            </div> 
          <?php elseif ($post_check == 'NO'):?>
            <h3>投稿内容を確認してください</h3>
          <?php endif; ?>
        </div>
      </div>
    </div>  
  </section>
<?php } ?>

