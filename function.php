<?php
    // 単数形resource名の単語を複数形に変換する関数
    function singular2plural($singular) {
        $dictionary = array(
            'man' => 'men',
            'seaman' => 'seamen',
            'snowman' => 'snowmen',
            'woman' => 'women',
            'person' => 'people',
            'child' => 'children',
            'foot' => 'feet',
            'crux' => 'cruces',
            'oasis' => 'oases',
            'phenomenon' => 'phenomena',
            'tooth' => 'teeth',
            'goose' => 'geese',
            'genus' => 'genera',
            'graffito' => 'graffiti',
            'mythos' => 'mythoi',
            'numen' => 'numina',
            'equipment' => 'equipment',
            'information' => 'information',
            'rice' => 'rice',
            'money' => 'money',
            'species' => 'species',
            'series' => 'series',
            'fish' => 'fish',
            'sheep' => 'sheep',
            'swiss' => 'swiss',
            'chief' => 'chiefs',
            'cliff' => 'cliffs',
            'proof' => 'proofs',
            'reef' => 'reefs',
            'relief' => 'reliefs',
            'roof' => 'roofs',
            'piano' => 'pianos',
            'photo' => 'photos',
            'safe' => 'safes'
        );

        if (array_key_exists($singular, $dictionary)) {
            $plural = $dictionary[$singular];
        } elseif (preg_match('/(a|i|u|e|o)o$/', $singular)) {
            $plural = $singular . "s";
        } elseif (preg_match('/(s|x|sh|ch|o)$/', $singular)) {
            $plural = preg_replace('/(s|x|sh|ch|o)$/', '$1es', $singular);
        } elseif (preg_match('/(b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z)y$/', $singular)) {
            $plural = preg_replace('/(b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z)y$/', '$1ies', $singular);
        } elseif (preg_match('/(f|fe)$/', $singular)) {
            $plural = preg_replace('/(f|fe)$/', 'ves', $singular);
        } else {
            $plural = $singular . "s";
        }
        return $plural;
    }

    //htmlspecialchars
    function h($value){
        return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }


    //ログイン判定
    function isLoginSuccess(){
        if(isset($_SESSION['join']['id']) && $_SESSION['time']+3600 > time()){
          //ログインしている
            return true;
        }else{
          //ログインしていない
          return false;
      }
    }


    //ステータス判定
    function status(){
        include('dbconnect.php');
        $sql = sprintf('SELECT*FROM users WHERE id=%d',
            mysqli_real_escape_string($db,$_SESSION['join']['id'])
        );
        $record = mysqli_query($db,$sql)or die(mysqli_error($db));
        $user = mysqli_fetch_assoc($record);

        return $user['status_id'];
    }


    //ログイしているユーザーの情報を取り出す関数
    function current_user($column){
        return $_SESSION['join'][$column];
    }

    // ログインユーザーの画像を表示する
    // サイズ指定と、第三引数に 「square」もしくは「circle」といれることで
    // 画像の形を指定できる。
    function current_user_image($width,$height,$shape){
        if ($shape == "circle"){
            return sprintf('<img class="circle" src="%s/views/member/user_picture/%s" width=%d height=%d>',
                root_path(),
                current_user('image'),
                $width,
                $height
            );
        } elseif ($shape == "square") {
            return sprintf('<img src="%s/views/member/user_picture/%s" width=%d height=%d>',
                root_path(),
                current_user('image'),
                $width,
                $height
            );
        }
    }

    // 画像やcssを指定する際のルートパスを返す
    function root_path() {
        return '../../nexseed_link';
    }


    //ログアウト処理
    function logout(){
        $_SESSION = array();
        if(ini_get("session.use_cokkie_params")){
            $params = session_get_cookie_params();
            setcookie(session_name(),'', time() - 42000,
              $params["path"],$params["domain"],
              $params["secure"],$params["httponly"]
            );
        }
        session_destroy();

        setcookie('email','',time()-3600);
        setcookie('password','',time()-3600);

        header('Location: auth/login');
        exit();
    }

    // テキストチャットを安全にする関数
    function json_safe_encode($data){
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    //最終閲覧時間を記録する（ページを開いたら時間が更新される）
    function visit_log_time(){
        include('dbconnect.php');
        $sql=sprintf('UPDATE users SET visit_log_time=NOW() WHERE id=%d ',
            mysqli_real_escape_string($db,$_SESSION['join']['id'])
            );
            mysqli_query($db, $sql) or die(mysqli_error());
    }

    //最終閲覧時間を確認できる
    function visit_log_time_show(){
        include('dbconnect.php');
        $sql = sprintf('SELECT*FROM users WHERE id=%d',
            mysqli_real_escape_string($db,$_SESSION['join']['id'])
        );
        $record = mysqli_query($db,$sql)or die(mysqli_error($db));
        $user = mysqli_fetch_assoc($record);
        return $user['visit_log_time'];
    }
?>
