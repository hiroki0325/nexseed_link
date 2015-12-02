<?php
    session_start();
    require('dbconnect.php');
    echo $_REQUEST['id'];
    if (isset($_REQUEST['id'])){
        $sql = sprintf('SELECT * FROM comments WHERE id = %d',
            $_REQUEST['id']
          );
        $record = mysqli_query($db, $sql) or die (mysqli_error($db));

        $table = mysqli_fetch_assoc($record);
        var_dump($table);
        if($table['id'] == $_REQUEST['id']){
            $sql = sprintf('DELETE FROM comments WHERE id = %d',
                $table['id']
            );
            mysqli_query($db, $sql) or die (mysqli_error($db));
            echo 'ok';
        }
    }
    header(sprintf('Location:show.php?id=%d',$table['post_id']));
    exit();
?>
