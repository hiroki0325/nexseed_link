<?php
    //入力しなかった場合入力を促す
    if (!empty($_POST)) {
      if ($_POST["nickname"] == '') {
         $error["nickname"] = 'blank';
      }
      $fileName=$_FILES["image"]["name"];
      if (!empty($fileName)) {
        $ext=substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'gif') {
          $error["image"] = "type";
        } 
      }

      if (empty($error)) {
        $image = date('YmdHis') . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], './views/user/user_picture/' . $image);
        $_SESSION["join"]["image"] = $image;
      }
    }

    var_dump($_POST);
    if (!empty($_POST)) {
      $sql=sprintf('UPDATE users SET nickname="%s", picture="%s" WHERE id=%d',
        mysqli_real_escape_string($db,$_POST['nickname']),
        mysqli_real_escape_string($db,$_SESSION['join']['image']),
        mysqli_real_escape_string($db,$_SESSION['join']['id'])
        );
        var_dump($sql);
        mysqli_query($db,$sql)or die(mysqli_error($db));
        header('Location: index');
        exit();
    }

?>


<h1>ユーザー情報の追加画面</h1>
<form action="" method="post" enctype="multipart/form-data">

  <div>
    <label for="">ニックネーム</label>
    <?php
      if (isset($_POST["nickname"])){
          echo sprintf('<input type="text" name="nickname" value="%s">',
          h($_POST["nickname"])
          );
      } else {
          echo'<input type="text" name="nickname">';
      }
    ?>
    <?php if (isset($error["nickname"])): ?>
      <?php if ($error["nickname"]=='blank'): ?>
        <p class="error">* ニックネームを入力してください</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>


  <div>
    <lavel for="">プロフィール画像</lavel>
    <?php if (isset($error["image"])): ?>
        <?php if ($error["image"]=='type'): ?>
          <p class="error">* 画像形式はjpgもしくはgifを指定してください。</p>
        <?php endif;?>
        <?php if (!empty($error)): ?>
          <p class="error">* 画像を改めて指定してください。</p>
        <?php endif;?>
    <?php endif;?>
    <input type="file" name="image">
  </div>

<button type="submit">追加する</button>


</form>

</body>
</html>

