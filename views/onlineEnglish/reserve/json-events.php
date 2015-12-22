<?php
// カレンダー開始日時
// $start = date('Y-m-d H:i:s', $_GET['start']);
// カレンダー終了日時の1秒前
// $end = date('Y-m-d H:i:s', $_GET['end'] - 1);

// イベントデータを出力
// echo json_encode(array(
//     array(
//         'title' => "start:" . $start,
//         'start' => $start
//     ),

//     array(
//         'title' => "end:" . $end,
//         'start' => $end,
//     )
echo json_encode(array(
    array(
        'title' => "Event1",
        'start' => '2015-12-7'
    )
));
