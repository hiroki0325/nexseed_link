<?php 
    $sql = 'SELECT * FROM users';
    $tables = mysqli_query($db,$sql)or die(mysqli_error($db));


 ?>
 <div id="page-wrapper">

  <div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">ユーザー管理表 </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div>

    <p>ソートはカラム名をクリック</p>

    <div class="panel-body">
        <div class="table-responsive">
            <!-- <table  id="sampleTable" class="tablesorter"> -->
            <table  id="sampleTable" class="table table-bordered table-hover table-striped">

                <thead>
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>ニックネーム</th>
                        <th>E-mail</th>
                        <th>ステータス</th>
                        <th>留学開始日</th>
                        <th>留学終了日</th>
                        <th>ログイン回数</th>
                        <th>最終ログイン日</th>
                        <th>作成日</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($table = mysqli_fetch_assoc($tables)): ?> 
                      <tr>
                          <td><?php echo $table['id']; ?></td>
                          <td><?php echo $table['fullname']; ?></td>
                          <td><?php echo $table['nickname']; ?></td>
                          <td><?php echo $table['email']; ?></td>
                          <td>
                            <?php 
                              if ($table['status_id'] == 1) {
                                  echo '管理者';
                              } elseif ($table['status_id'] == 2) {
                                  echo '来学予定者';
                              } elseif ($table['status_id'] == 3) {
                                  echo "在学生";
                              } elseif ($table['status_id'] == 4) {
                                  echo "卒業生";
                              } elseif ($table['status_id'] == 5) {
                                  echo "先生";
                              }
                             ?>
                         </td>
                          <td><?php echo $table['start_day']; ?></td>
                          <td><?php echo $table['end_day']; ?></td>
                          <td><?php echo $table['login_count']; ?></td>
                          <td><?php echo $table['visit_log_time']; ?></td>
                          <td><?php echo $table['created']; ?></td>
                      </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <script type="text/javascript">
               $(document).ready(function() 
                   { 
                       $("#sampleTable").tablesorter();
                   } 
               ); 
            </script>
        </div>
    </div>

  </div>
</div>




