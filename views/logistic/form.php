 
<?php
    session_start();
    //DBに接続
    include('dbconnect.php');
    //文字入力のバグ対応
    function h($value){
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    //use_idを仮設定
    $_SESSION['login_id'] = 1;
    
    //入力のエラー判定
    if (!empty($_POST)){
        //入力漏れエラー判定
        if ($_POST['thing']  == ''){
            $error['thing'] = 'Blanck';
        }
        if ($_POST['insentive']  == ''){
            $error['insentive'] = 'Blanck';
        }
        if ($_POST['payment']  == ''){
            $error['payment']= 'Blanck';
        }
        if ($_POST['due']  == ''){
            $error['due']= 'Blanck';
        }
        //画像ファイルの拡張子に対してのエラー判定
        if (isset($_FILES)){
            $filename = $_FILES['image']['name'];
            $ext = substr($filename, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png'){
                $error['image'] = 'type';
            }
        }
        //画像をファイルにアップロード
        if (empty($error)) {
            if($filename != "" ) {
                $image = $filename;  
                move_uploaded_file($_FILES['image']['tmp_name'],'thing_image/'.$image);  
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

    //期限切れデータを表示 あとで使用する
    $sql = sprintf('SELECT * FROM logistic_posts WHERE client_id=%d AND due < NOW()',
       $_SESSION['login_id']
    );
    $impossible_posts = mysqli_query($db, $sql) or die (mysqli_error($db));

?>

<!DOCTYPE html >
<html  lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="imagetoolbar" content="no" />
    <title>logistic mypage</title>
    <link rel="stylesheet" type="text/css" href="/content/lib/global.css" />
    <link rel="stylesheet" href="tub.css" />
    <!-- JS タブの生成-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript">
      $(function(){
        $("a.tab").click(function(){
           $(".activo").removeClass("activo");
           $(this).addClass("activo");
           $(".contenido").hide('slow');
           var muestra = $(this).attr("title");
           $("#"+muestra).show('slow'); 
        });  
      });
    </script>     
    <link rel="stylesheet" type="text/css" href="/common/css/example.css">
  </head>
  <body id='example3' class='example'><div class="ads" style="margin:32px auto;text-align:center;">
    <div id="wrap">
      <div id="tab_contenedor">
        <ul class="titulos">
           <li><a href="#" title="post" class="tab activo">form</a></li>
           <li><a href="#" title="bookmark" class="tab">accepted</a></li>
           <li><a href="#" title="email" class="tab">not yet</a></li>
        </ul>
        <div id="tab_contenido">
        <div id="post" class="contenido">
          <!-- 欲しいものの登録画面 -->
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
            <input type="submit">
          </form>
        </div>
        <!-- 承認済みデータの表示 -->
        <div id="bookmark" class="contenido">
          <h4>承認済み依頼</h4>
          <?php while ($post=mysqli_fetch_assoc($accepted_posts)):?>
              <div>
                <img src="thing_image/<?php echo h($post['image'])?>" width=100 hight=100>
                <p><?php echo h($post['thing'])?></p>
                <p><?php echo h($post['category'])?></p>
                <p><?php echo h($post['insentive'])?></p>
                <p><?php echo h($post['payment'])?></p>
                <p><?php echo h($post['due'])?></p>
                <p><?php echo h($post['created'])?></p> 
                [<a href="show.php?id=<?php echo h($post['id'])?>">show</a>]
              </div>
          <?php endwhile;?>
        </div>
        <!-- 承認待ちデータの表示 -->
        <div id="email" class="contenido">
          <h4>承認待ち依頼</h4>
          <?php while ($post=mysqli_fetch_assoc($unverified_posts)):?>
              <div>
                <img src="thing_image/<?php echo h($post['image'])?>" width=100 hight=100>
                <p><?php echo h($post['thing'])?></p>
                <p><?php echo h($post['category'])?></p>
                <p><?php echo h($post['insentive'])?></p>
                <p><?php echo h($post['payment'])?></p>
                <p><?php echo h($post['due'])?></p>
                <p><?php echo h($post['created'])?></p>
                [<a href="show.php?id=<?php echo h($post['id'])?>">show</a>]
              </div>
          <?php endwhile;?>
        </div>
      </div>
    </div>
  </body>
</html>
