<?php
    // date_default_timezone_set('Asia/Tokyo');
    //入力しなかった場合入力を促す


    //書き直し処理
    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == 'rewrite') {
          $_POST = $_SESSION['user'];
          $error['rewrite'] = true;
      }
    }
?>


<div id="page-wrapper">
  <div class="container-fluid">
    <h1 class="page-header">ユーザー新規登録 </h1>
    <!-- <ol class="breadcrumb">
        <li class="active">
            <i class="fa fa-dashboard"></i> Dashboard
        </li>
    </ol> -->
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-6 col-lg-offset-3">
          <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> フォーム</h3>
            </div>
            <div class="panel-body">

              <form action="" method="post" enctype="multipart/form-data">

                <div class="col-lg-6">
                  <label class="form-group">First Name</label>
                  <?php
                    if (isset($_POST["first_name"])) {
                        echo sprintf('<input type="text" class="form-control" name="first_name" pattern="^[0-9A-Za-z]+$" value="%s">
                          <p class="help-block">＊半角英数字</p>',
                        h($_POST["first_name"])
                      );
                    } else {
                        echo'<input type="text" class="form-control" name="first_name" pattern="^[0-9A-Za-z]+$">
                          <p class="help-block">＊半角英数字</p>';
                    }
                  ?>
                </div>
                <div class="form-group has-error">
                  <?php if (isset($error["first_name"])): ?>
                      <?php if ($error["first_name"] == 'blank'): ?>
                        <p class='control-label' for='inputError'> first nameを入力してください</p>;
                      <?php endif; ?>
                  <?php endif; ?>
                </div>
                

                <div class="col-lg-6">
                  <label class="form-group">Last Name</label>
                  <?php
                    if(isset($_POST["last_name"])){
                        echo sprintf('<input type="text" class="form-control" name="last_name" pattern="^[0-9A-Za-z]+$" value="%s">
                          <p class="help-block">＊半角英数字</p>',
                        h($_POST["last_name"])
                      );
                    }else{
                        echo'<input type="text" class="form-control" name="last_name" pattern="^[0-9A-Za-z]+$">
                          <p class="help-block">＊半角英数字</p>';
                    }
                  ?>
                </div>
                <div class="form-group has-error">
                  <?php if(isset($error["last_name"])): ?>
                      <?php if ($error["last_name"] == 'blank'): ?>
                        <p class='control-label' for='inputError'> last nameを入力してください</p>";
                      <?php endif; ?>
                  <?php endif; ?>
                </div>


                <div>
                  <label class="form-group">E-mail</label>
                  <?php
                    if(isset($_POST["email"])){
                        echo sprintf(' <input type="text" class="form-control"  name="email" value="%s">',
                        h($_POST["email"])
                      );
                    }else{
                      echo '<input type="text" class="form-control" name="email">';
                    }
                  ?>
                </div>
                <div class="form-group has-error">
                    <?php if(isset($error["email"])): ?>
                        <?php if ($error["email"] == 'blank'): ?>
                          <p class="control-label" for="inputError">E-mailを入力してください。</p>
                        <?php endif;?>
                        <?php if($error['email'] == 'duplicate'): ?>
                          <p class="control-label" for="inputError">指定されたメールアドレスはすでに登録さています</p>
                        <?php endif; ?>
                    <?php endif;?>
                </div>


                <div>
                  <label class="form-group">パスワード</label>
                    <?php 
                      if(isset($_POST["password"])){
                          echo sprintf(' <input type="password" class="form-control" name="password" value="%s">',
                          h($_POST["password"])
                        );
                      }else{
                          echo '<input type="password" class="form-control" name="password">';
                      }
                    ?>
                    <?php if(isset($error["password"])): ?>
                        <?php if ($error["password"] == 'blank'): ?>
                          <p class="control-label" for="inputError"> パスワードを入力してください。</p>
                        <?php endif;?>
                        <?php if ($error["password"] == 'length'): ?>
                          <p class="control-label" for="inputError"> パスワードは４文字以上入力してください</p>
                        <?php endif;?>
                    <?php endif;?>
                </div>


                <br>
                <div>
                  <label class="form-group">学生以外の登録は以下にチェックをつけてください</label>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" name="teacher" value="option1" >Engilish teacher
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" name="admin" value="option2" >管理者
                    </label>
                  </div>
                </div>  


                <div class="col-lg-6">
                  <label class="form-group">留学開始日</label>  
                  <br>
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


                <div class="col-lg-6">
                  <label class="form-group">留学終了日</label>
                  <br>
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

                <br>
                <br>
                <br>
                <br>
                <div class="row">
                  <div class="col-xs-6 col-md-6">     
                  </div>
                  <div class="col-xs-6 col-md-6 pull-right">
                    <button type="submit" class="btn btn-large btn-success pull-right">入力内容の確認</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
