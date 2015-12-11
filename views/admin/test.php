<?php 
    $sql = 'SELECT a.id, a.date, b.time, c.nickname AS teacher, d.nickname AS student 
            FROM lessons a, lesson_times b, users c, users d WHERE a.time_id = b.id 
            AND a.teacher_id = c.id  AND a.student_id = d.id';
    $tables = mysqli_query($db,$sql)or die(mysqli_error($db));
    $table=mysqli_fetch_assoc($tables);
    echo $table['date'];
var_dump($table);

 ?>

