<?php
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
                move_uploaded_file($_FILES['image']['tmp_name'],'/var/www/html/nexseed_link/views/logistic/logistic/image_thing/'.$image);  
      
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
        $sql = sprintf(
            'UPDATE logistic_posts SET thing="%s", category="%s", image="%s", insentive="%s", payment="%s", due="%s" WHERE id=%d',
            $_SESSION['thing'],
            $_SESSION['category'],
            $_SESSION['new_image'],
            $_SESSION['insentive'],
            $_SESSION['payment'],
            $_SESSION['due'],
            $_REQUEST['id']
        );
        mysqli_query($db,$sql) or die(mysqli_error($db));
        header(sprintf('Location:show?id=%d',$_REQUEST['id']));
        exit();   
    }
?>
<!-- 投稿の編集form バリデーション済み -->
<div id="edit_form">
  <h4>投稿の編集はこちら</h4>
  <form action="" method="post" enctype="multipart/form-data" >
    <p>依頼するもの</p>
    <input type="text" name="thing" value="<?php echo $_SESSION['thing']; ?>">
    <p>ジャンル</p>
    <select name="category" >
      <option value="<?php echo $_SESSION['category'] ;?>"></option>
      <option value="書籍">書籍</option>
      <option value="食べ物">食べ物</option>
      <option value="衣類">衣類</option>
      <option value="アメニティ">アメニティ</option>
    </select>
    <p>インセンティブ</p>
    <input type="text" name="insentive" value="<?php echo $_SESSION['insentive']; ?>">
    <p>金額</p>
    <input type="text" name="payment" value="<?php echo $_SESSION['payment']; ?>">
    <p>到着日</p>
    <input type="date" name="due" value="<?php echo $_SESSION['due']; ?>">
    <p>イメージ画像</p>
    <input type="file" name="image">
  </fom>
</div>
<div>
 <input type= "submit" value="編集を実行" name="update">
</div>



