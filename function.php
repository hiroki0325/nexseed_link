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
      if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
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
      $sql=sprintf('SELECT*FROM users WHERE id=%d',
          mysqli_real_escape_string($db,$_SESSION['id'])
      );
      $record=mysqli_query($db,$sql)or die(mysqli_error($db));
      $user=mysqli_fetch_assoc($record);

      //来学予定者
      return $user['status']=='future_student';
      //在学生
      return $user['status']=='stay_student';
      //卒業生
      return $user['status']=='graduate_student';
    }


    //ログアウト
    function logout(){
       $_SESSION= array();
       if(ini_get("session.use_cokkie_params")){
         $params=session_get_cookie_params();
         setcookie(session_name(),'', time() - 42000,
           $params["path"],$params["domain"],
           $params["secure"],$params["httponly"]
           );
       }
       session_destroy();

       setcookie('email','',time()-3600);
       setcookie('password','',time()-3600);

       header('Location: login/login');
       exit();
    }

    // テキストチャットを安全にする関数
    function json_safe_encode($data){
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }
?>
