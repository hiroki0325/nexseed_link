

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../views/assets/css/login2.css">
    <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">
</head>
<body>
    
</body>
</html>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pr-wrap">
                <div class="pass-reset">
                    <label>Email </label> 　

                    <input type="email" placeholder="Email" />
                    <input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
                </div>
            </div>

            <div class="wrap">
                <p class="form-title">Sign In</p>
                <form action="" method="post" class="login">
                    <?php if(isset($_POST['email'])): ?>
                        <input type="text" name="email" value="<?php echo h($_POST['email']); ?>"
                          placeholder="Username" autofocus>
                    <?php else: ?>
                        <input type="text" name="email" class="form-control" placeholder="" autofocus>
                    <?php endif; ?>        
                        
                    <?php if(isset($error)): ?>
                        <?php if($error['login']=='blank'): ?>
                            <p class="error"> *メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>
                        <?php if($error['login']=='failed'): ?>
                            <p class="error"> *ログインに失敗しました。正しく情報をご記入ください</p>
                        <?php endif; ?>
                    <?php endif; ?>
                
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        

                <div>
                  <input type="checkbox" id="save" name="save" value="on">
                  <label for="">次回から自動ログインする</label>
                </div>


                <input type="submit" value="Sign In" class="btn btn-success btn-sm" />
                <div class="remember-forgot">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label><input type="checkbox" />Remember Me</label>
                            </div>
                        </div>
                        <div class="col-md-6 forgot-pass-content">
                            <a href="javascript:void(0)" class="forgot-pass">Forgot Password</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="posted-by">Posted By: <a href="http://www.jquery2dotnet.com">Bhaumik Patel</a></div>
</div>


