<?php
    date_default_timezone_set('Asia/Tokyo');

    //入力しなかった場合入力を促す
    if(!empty($_POST)){
      if($_POST["first_name"]==''){
         $error["first_name"]='blank';
      }
      if($_POST["last_name"]==''){
         $error["last_name"]='blank';
      }
      if($_POST["eg_first_name"]==''){
         $error["eg_first_name"]='blank';
      }
      if($_POST["eg_last_name"]==''){
         $error["eg_last_name"]='blank';
      }
       if($_POST["email"]==''){
        $error["email"]='blank';
      }
      if(strlen($_POST["password"])<4){
        $eroor["password"]='length';
      }
      if($_POST["password"]==''){
        $error["password"]='blank';
      }
      $fileName=$_FILES["image"]["name"];
      if(!empty($fileName)){
        $ext=substr($fileName, -3);
        if($ext !='jpg'&& $ext !='gif'){
          $error["image"]="type";
        } 
      }

      //重複アカウントのチェック
      if(empty($error)){
        $sql=sprintf('SELECT count(*) AS cnt FROM users
          WHERE email="%s"',
          mysqli_real_escape_string($db,$_POST['email'])
          );
        $record=mysqli_query($db,$sql)or die(mysqli_error($db));
        $table=mysqli_fetch_assoc($record);
        if($table['cnt']>0){
          $error['email']='duplicate';
        }
      }

      // 登録時点でのステータス判定
      // $_POST['start_day']に入っているユーザーが入力した開始日と、
      // 現在の日付(date関数？)を取得して比べる

      if (isset($_POST['teacher'])) {
          $status = 5;
      } elseif (isset($_POST['admin'])){
          $status = 1;
      } else {
              // もし$_POST['start_day']が後だったら入学前なので、
          if(date("Y-m-d") < $_POST['start_day']){
              $status = 2;
              // もし$_POST['start_day']が前で、かつ$_POST['end_day']が後だったら在学生なので、
          }elseif($_POST['start_day'] < date("Y-m-d") && date("Y-m-d") < $_POST['end_day']){
              $status = 3;
              // もし$_POST['start_day']が前で、かつ$_POST['end_day']が前だったら卒業生なので、
          }else{
              $status = 4;
          }
      }

      

      if(empty($error)){
        $image=date('YmdHis').$_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], './views/member/user_picture/'.$image);
        $_SESSION["join"]=$_POST;
        $_SESSION["join"]["image"]=$image;
        $_SESSION["join"]["status_id"]=$status;
        header('Location: check');
        exit();
      }

    }

    //書き直し処理
    if(isset($_REQUEST['action'])){
      if($_REQUEST['action']=='rewrite'){
          $_POST = $_SESSION['join'];
          $error['rewrite']=true;
      }
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Nexseed Link-管理者用ユーザー登録画面</title>
</head>
<body>
  <h1>管理者用ユーザー登録画面</h1>
  <p>ユーザー情報を入力してください</p>

  <form action="" method="post" enctype="multipart/form-data">

  <div>
    <label for="">姓</label>
    <?php
      if(isset($_POST["last_name"])){
          echo sprintf('<input type="text" name="last_name" value="%s">',
          h($_POST["last_name"])
          );
      }else{
          echo'<input type="text" name="last_name">';
      }
    ?>
    <?php if(isset($error["last_name"])): ?>
      <?php if ($error["last_name"]=='blank'): ?>
        <p class="error">* 名前を入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div>
    <label for="">名</label>
    <?php
      if(isset($_POST["first_name"])){
          echo sprintf('<input type="text" name="first_name" value="%s">',
          h($_POST["first_name"])
          );
      }else{
          echo'<input type="text" name="first_name">';
      }
    ?>
    <?php if(isset($error["first_name"])): ?>
      <?php if ($error["first_name"]=='blank'): ?>
        <p class="error">* 名前を入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>


  <div>
    <label for="">First Name</label>
    <?php
      if(isset($_POST["eg_first_name"])){
          echo sprintf('<input type="text" name="eg_first_name" pattern="^[0-9A-Za-z]+$" value="%s">＊半角英字',
          h($_POST["eg_first_name"])
        );
      }else{
          echo'<input type="text" name="eg_first_name" pattern="^[0-9A-Za-z]+$">＊半角英字';
      }
    ?>
    <?php if(isset($error["eg_first_name"])): ?>
    <?php if ($error["eg_first_name"]=='blank'): ?>
        <p class="error">* 名前を入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div>
    <label for="">Last Name</label>
    <?php
      if(isset($_POST["eg_last_name"])){
          echo sprintf('<input type="text" name="eg_last_name" pattern="^[0-9A-Za-z]+$" value="%s">＊半角英字',
          h($_POST["eg_last_name"])
        );
      }else{
          echo'<input type="text" name="eg_last_name" pattern="^[0-9A-Za-z]+$">＊半角英字';
      }
    ?>
    <?php if(isset($error["eg_last_name"])): ?>
    <?php if ($error["eg_last_name"]=='blank'): ?>
        <p class="error">* 名前を入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div>
    <label for="">メールアドレス</label>
    <?php 
      if(isset($_POST["email"])){
          echo sprintf(' <input type="text" name="email" value="%s">',
          h($_POST["email"])
        );
      }else{
        echo '<input type="text" name="email">';
      }
    ?>
    <?php if(isset($error["email"])): ?>
        <?php if ($error["email"]=='blank'): ?>
            <p class="error">* メールアドレスを入力してください。</p>
        <?php endif;?>
        <?php if($error['email']=='duplicate'): ?>
            <p class="error">*指定されたメールアドレスはすでに登録さています</p>
        <?php endif; ?>
    <?php endif;?>
  </div>

  <div>
    <label for="">パスワード</label>
      <?php 
        if(isset($_POST["password"])){
            echo sprintf(' <input type="password" name="password" value="%s">',
            h($_POST["password"])
          );
        }else{
            echo '<input type="password" name="password">';
        }
      ?>
      <?php if(isset($error["password"])): ?>
          <?php if ($error["password"]=='blank'): ?>
              <p class="error">* パスワードを入力してください。</p>
          <?php endif;?>
          <?php if ($error["password"]=='length'): ?>
              <p class="error">* パスワードは４文字以上入力してください</p>
          <?php endif;?>
      <?php endif;?>
  </div>

  <div>
    <p>学生以外の登録は以下にチェックをつけてください</p>
 
    <input type="checkbox" name="teacher" value="1">Engilish teacher
    <br>
    <input type="checkbox" name="admin" value="2">管理者
  </div>

  <div>
    <label for="">留学開始日</label>  
    <?php 
      if(isset($_POST["start_day"])){
          echo sprintf(' <input type="date" name="start_day" min="2013-04-01" max="2017-12-31" value=%d >',
          h($_POST["start_day"])
          );
      }else{
          echo '<input type="date" name="start_day">';
      }
    ?>
  </div>

  <div>
    <label for="">留学終了日</label>
    <?php 
      if(isset($_POST["end_day"])){
          echo sprintf(' <input type="date" name="end_day" min="2013-04-01" max="2017-12-31" value=%d >',
          h($_POST["end_day"])
          );
      }else{
          echo '<input type="date" name="end_day">';
      }
    ?>
  </div>

    <div>
      <lavel for="">プロフィール画像</lavel>
      <?php if(isset($error["image"])): ?>
          <?php if ($error["image"]=='type'): ?>
              <p class="error">* 画像形式はjpgもしくはgifを指定してください。</p>
          <?php endif;?>
          <?php if (!empty($error)): ?>
              <p class="error">* 画像を改めて指定してください。</p>
          <?php endif;?>
      <?php endif;?>
      <input type="file" name="image">
    </div>

    <button type="submit">入力内容の確認</button>


</form>


</body>
</html>

