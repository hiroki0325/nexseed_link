<?php 
    $sql = 'SELECT a.id, a.date, b.time, c.nickname AS teacher, d.nickname AS student 
            FROM lessons a, lesson_times b, users c, users d WHERE a.time_id = b.id 
            AND a.teacher_id = c.id  AND a.student_id = d.id';
    $tables = mysqli_query($db,$sql)or die(mysqli_error($db));


    $sql = 'SELECT * FROM users ORDER BY created DESC';
    $users = mysqli_query($db,$sql)or die(mysqli_error($db));
    $user = mysqli_fetch_assoc($users);

    //レッスンが追加されるタイミングに下記を挿入する
    // $sql = 'SELECT * FROM lessons';
    // $lessons = mysqli_query($db,$sql)or die(mysqli_error($db));
    // $lesson = mysqli_fetch_assoc($lessons);

    // $sql = sprintf('INSERT INTO notifications SET lesson_id = %d,
    //                  notificaton_message_id = 2, created = NOW()',
    //         mysqli_real_escape_string($db,$lesson['id'])
    //     );
    // $lesson_notification = mysqli_query($db,$sql)or die(mysqli_error($db));

    //物流が追加されるタイミングに下記を挿入する
    // $sql = 'SELECT * FROM logistic_posts';
    // $logistic_posts = mysqli_query($db,$sql)or die(mysqli_error($db));
    // $logistic_post = mysqli_fetch_assoc($logistic_posts);

    // $sql = sprintf('INSERT INTO notifications SET logistic_post_id = %d,
    //                  notificaton_message_id = 3, created = NOW()',
    //         mysqli_real_escape_string($db,$logistic_post['id'])
    //     );
    // $logistic_post_notification = mysqli_query($db,$sql)or die(mysqli_error($db));

    $sql = 'SELECT * FROM notifications ORDER BY created DESC LIMIT 8';
    $notifications = mysqli_query($db,$sql)or die(mysqli_error($db));
    $notification = mysqli_fetch_assoc($notifications);
    
 ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    管理者画面 <small>test</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                  <?php 
                                      $sql = 'SELECT COUNT(*) AS count FROM lessons';
                                      $lesson_counts = mysqli_query($db,$sql)or die(mysqli_error($db));
                                      $lesson_count = mysqli_fetch_assoc($lesson_counts);
                                      echo $lesson_count['count'];
                                   ?>
                                </div>
                                <div>オンライン英会話</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">詳細をみる</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                  <?php 
                                      $sql = 'SELECT COUNT(*) AS count FROM users';
                                      $user_counts = mysqli_query($db,$sql)or die(mysqli_error($db));
                                      $user_count = mysqli_fetch_assoc($user_counts);
                                      echo $user_count['count'];
                                   ?>
                                </div>
                                <div>ユーザー管理</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">詳細をみる</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                  <?php 
                                        $sql = 'SELECT COUNT(*) AS count FROM logistic_posts';
                                        $logistic_counts = mysqli_query($db,$sql)or die(mysqli_error($db));
                                        $logistic_count = mysqli_fetch_assoc($logistic_counts);
                                        echo $logistic_count['count'];
                                   ?>
                                </div>
                                <div>物流システム</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">詳細をみる</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->

            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> 通知</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                        <?php while ($notification = mysqli_fetch_assoc($notifications)): ?> 
                            <a href="#" class="list-group-item">
                                <i class="fa fa-fw fa-check"></i> 
                                <span class="badge"><?php echo $notification['created']; ?></span>
                                <?php 
                                    $sql = sprintf('SELECT * FROM notification_message WHERE id = %d',
                                                mysqli_real_escape_string($db,$notification['notificaton_message_id'])
                                    );
                                    $notification_messages = mysqli_query($db,$sql)or die(mysqli_error($db));
                                    $notification_message = mysqli_fetch_assoc($notification_messages);

                                    
                                    $sql = sprintf('SELECT * FROM users WHERE id=%d',
                                                mysqli_real_escape_string($db,$notification['user_id'])
                                    );
                                    $notification_users = mysqli_query($db,$sql)or die(mysqli_error($db));
                                    $notification_user = mysqli_fetch_assoc($notification_users);
                                 ?>
                                 <?php echo $notification_user['fullname']; ?>
                                 <?php echo $notification_message['message']; ?> 
                            </a>
                        <?php endwhile; ?>
                        </div>
                        <div class="text-right">
                            <a href="#">全ての通知を確認する <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>今日の授業スケジュール</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Cubicle #</th>
                                        <th>Start time</th>
                                        <th>Teacher name</th>
                                        <th>Student name</th>
                                    </tr>
                                </thead>
                                <?php while ($table = mysqli_fetch_assoc($tables)): ?> 
                                  <tbody>
                                      <tr>
                                          <td><?php echo $table['id']; ?></td>
                                          <td><?php echo $table['date']; ?></td>
                                          <td><?php echo $table['teacher']; ?></td>
                                          <td><?php echo $table['student']; ?></td>
                                      </tr>
                                  </tbody>
                                <?php endwhile; ?>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="#">全てのスケジュールを確認する <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->



