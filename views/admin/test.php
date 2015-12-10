<?php 
    $sql = 'SELECT a.id, a.date, b.time, c.nickname, c.nickname
            FROM lessons a, lesson_times b, users c
            WHERE a.time_id = b.id
            AND a.teacher_id = c.id
            AND a.student_id = c.id';
    $tables = mysqli_query($db,$sql)or die(mysqli_error($db));
var_dump($tables);

 ?>
