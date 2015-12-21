<?php
    if (isset($_REQUEST['id'])) {
        $sql = sprintf('SELECT  post_id FROM candidates WHERE id=%d',$_REQUEST['id']);
        $sql = mysqli_query($db,$sql) or die (mysqli_error($db));
        $post_id = mysqli_fetch_assoc($sql);

        $sql = sprintf('UPDATE logistic_posts SET candidate_id=%d, accepted=NOW() WHERE id=%d',
            $_REQUEST['id'],
            $post_id['post_id']
        );
        mysqli_query($db,$sql) or die (mysqli_error($db));

        $sql = sprintf('UPDATE candidates SET desicion=1 WHERE post_id=%d',
            $post_id['post_id']
        );
        mysqli_query($db,$sql) or die(mysqli_error($db));
        header('Location:top');
        exit();
    } else {
        header('Location:top');
        exit();
    }
?>
