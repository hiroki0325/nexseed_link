<?php
    date_default_timezone_set('Asia/Tokyo');

    //入力しなかった場合入力を促す
    if(!empty($_POST)){
      if($_POST["name"]==''){
         $error["name"]='blank';
      }
      if($_POST["eg_name"]==''){
         $error["eg_name"]='blank';
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
      if($_POST["start_day"]==''){
        $error["start_day"]='blank';
      }
      if($_POST["end_day"]==''){
        $error["end_day"]='blank';
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

<<<<<<< HEAD
          // もし$_POST['start_day']が後だったら入学前なので、
      if(date("Y-m-d") < $_POST['start_day']){
          $status = 'future_student';
          // もし$_POST['start_day']が前で、かつ$_POST['end_day']が後だったら在学生なので、
      }elseif($_POST['start_day'] < date("Y-m-d") && date("Y-m-d")<$_POST['end_day']){
          $status = 'stay_student';
          // もし$_POST['start_day']が前で、かつ$_POST['end_day']が前だったら卒業生なので、
      }else{
          $status = 'graduate_student';
      }
=======
      if (isset($_POST['teacher'])) {
          $status = 5;
      } elseif (isset($_POST['admin'])){
          $status = 1;
      } else {
              // もし$_POST['start_day']が後だったら入学前なので、
          if(date("Y-m-d") <= $_POST['start_day']){
              $status = 2;
              // もし$_POST['start_day']が前で、かつ$_POST['end_day']が後だったら在学生なので、
          }elseif($_POST['start_day'] <= date("Y-m-d") && date("Y-m-d") <= $_POST['end_day']){
              $status = 3;
              // もし$_POST['start_day']が前で、かつ$_POST['end_day']が前だったら卒業生なので、
          }else{
              $status = 4;
          }
      }

      
>>>>>>> 2515986... ログイン画面の微調整

      if(empty($error)){
        $image=date('YmdHis').$_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], './views/member/user_picture/'.$image);
        $_SESSION["join"]=$_POST;
        $_SESSION["join"]["image"]=$image;
        $_SESSION["join"]["status"]=$status;
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
  <title>Nexseed Link-新規登録</title>
</head>
<body>
  <h1>新規登録</h1>
  <p>会員情報を入力してください</p>

  <form action="" method="post" enctype="multipart/form-data">

  <div>
    <label for="">名前</label>
    <?php
      if(isset($_POST["name"])){
          echo sprintf('<input type="text" name="name" value="%s">',
          h($_POST["name"])
        );
      }else{
          echo'<input type="text" name="name">';
      }
    ?>
    <?php if(isset($error["name"])): ?>
      <?php if ($error["name"]=='blank'): ?>
        <p class="error">* 名前を入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div>
    <label for="">English Name</label>
    <?php
      if(isset($_POST["eg_name"])){
          echo sprintf('<input type="text" name="eg_name" pattern="^[0-9A-Za-z]+$" value="%s">＊半角英字',
          h($_POST["eg_name"])
        );
      }else{
          echo'<input type="text" name="eg_name" pattern="^[0-9A-Za-z]+$">＊半角英字';
      }
    ?>
    <?php if(isset($error["eg_name"])): ?>
    <?php if ($error["eg_name"]=='blank'): ?>
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
    <?php if(isset($error["start_day"])): ?>
        <?php if ($error["start_day"]=='blank'): ?>
            <p class="error">* 日付を選択してください</p>
        <?php endif;?>
    <?php endif; ?>
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
    <?php if(isset($error["end_day"])): ?>
        <?php if ($error["end_day"]=='blank'):  ?>
            <p class="error">* 日付を選択してください</p>
        <?php endif;?>
    <?php endif; ?>
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

