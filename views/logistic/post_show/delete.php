<?php
  if (isset($_REQUEST['id'])){
      //idは画像のid
      $id = $_REQUEST['id'];
      //picturesの中から選択した写真(id)のデータを拾う
      $sql = sprintf('SELECT * FROM logistic_posts WHERE id = %d',
          $id
        );
      $record = mysqli_query($db, $sql) or die (mysqli_error($db));

      $table = mysqli_fetch_assoc($record);
      //picturesの投稿者idと$_SESSION[id]が一致ならDELETE発動
      //picturesの中から選択した写真のデータを消す
      if($table['id'] == $_REQUEST['id']){
          $sql = sprintf('DELETE from logistic_posts WHERE id = %d',
              mysqli_real_escape_string($db, $id)
          );
          mysqli_query($db, $sql) or die (mysqli_error($db));
      }
  }
    header('Location:../student_cebu/form');
    exit();
?>  
