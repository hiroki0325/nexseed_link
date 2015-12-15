<?php
    session_start();
    date_default_timezone_set('Asia/Tokyo');


    //// +++ DB接続 +++ ////
    require('dbconnect.php');

    //// +++ function.phpの呼び出し +++ ////
    include('function.php');

    //// +++ ルーティング +++ ////
    $params = explode('/', $_GET['url']);

    $function = $params[0];

    if (isset($params[1])) {
        $directry = $params[1];
    }

    if (count($params) > 2) {
        $page = $params[2];
        if (count($params) > 3) {
            $id = $params[3];
        }
    }

    // リソース名を複数形に変換する処理
    //// 今は完全なMVCフレームワークでないため、コメントアウト

    // $plural_resorce = singular2plural($resource);

    //viewの形成を楽にするヘルパーを読み込み
    include('./views/helpers/application_helper.php');

    if ($params[0]=='admin') { //管理者ファイルを読み込み
        include('./views/layouts/admin.php');

    } elseif ($params[0]=='user') { //ログインファイルを読み込み
        include('./views/layouts/login.php');

    } elseif ($params[1]=='class') { //英会話ファイルを読み込み
        include('./views/layouts/onlineEnglish.php');

    }else { // レイアウトファイルを読み込み
        include('./views/layouts/application.php');
    }

?>
