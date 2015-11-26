<?php
    $sql = sprintf(
        'UPDATE logistic_posts SET thing="%s", category="%s", image="%s", insentive="%s", payment="%s", due="%s" WHERE id=%d',
        $_SESSION['thing'],
        $_SESSION['category'],
        $_SESSION['new_image'],
        $_SESSION['insentive'],
        $_SESSION['payment'],
        $_SESSION['due'],
        $_REQUEST['id']
    );
    mysqli_query($db,$sql) or die(mysqli_error($db));
     

    $id = $_REQUEST['id'];

    header(sprintf('Location:show?id=%d',$id));
    exit();
?>

