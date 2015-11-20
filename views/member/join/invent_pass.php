<?php 

    //入力しなかった場合入力を促す
    if(!empty($_POST)){

      if($_POST["invent_pass"]==''){
         $error["invent_pass"]='blank';
      }elseif($_POST["invent_pass"]!='hoge'){
        $error['invent_pass']='incorrect';
      }

      if(empty($error)){
          header('Location: index');
          exit();
      }
    }


 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="UTF-8">
   <title>招待コード確認画面</title>

 </head>
 <body>
   <h1>招待コード確認画面</h1>

    <form action="" method="post">
      <div>
          <label for="">招待コード</label>
          <?php
          if(isset($_POST["invent_pass"])){
            echo sprintf('<input type="text" name="invent_pass" value="%s">',
              h($_POST["invent_pass"])
              );
          }else{
            echo'<input type="text" name="invent_pass">';
          }
         ?>

        <?php if(isset($error["invent_pass"])): ?>

          <?php if ($error["invent_pass"]=='blank'): ?>
            <p class="error">* 招待コードを入力してください</p>
          <?php endif; ?>

          <?php if($error['invent_pass']=='incorrect'): ?>
            <p class="error">* 招待コードを正しく入力してください</p>
          <?php endif; ?>
          
        <?php endif; ?>
      </div>

     <button type="submit">認証する</button>

    </form>  
 </body>
 </html>
