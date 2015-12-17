<?php 
    $status = status();
    if (!isLoginSuccess() || $status != 1) {
        header('Location: ../../user/auth/login');
        exit();
    }
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

        <!-- joinディレクトリ -->
        <title>NexSeedLink -Admin page-</title>
        <link rel="stylesheet" href="../../views/assets/css/bootstrap.css">
        <link rel="stylesheet" href="../../views/assets/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../../views/assets/css/admin/sb-admin.css">
        <link rel="stylesheet" href="../../views/assets/css/admin/plugins/morris.css">


    

</head>
<body>
    <div id="wrapper">

       <!-- Navigation -->
       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="index">NexSeedLink -Admin page-</a>
           </div>
           <!-- Top Menu Items -->
           <ul class="nav navbar-right top-nav">
               <li class="ユーザー管理">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                   <ul class="dropdown-menu message-dropdown">
                       <li class="message-preview">
                           <a href="#">
                               <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                                   <div class="media-body">
                                       <h5 class="media-heading"><strong>Natsuki teruya</strong>
                                       </h5>
                                       <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                       <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                   </div>
                               </div>
                           </a>
                       </li>
                       <li class="message-preview">
                           <a href="#">
                               <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                                   <div class="media-body">
                                       <h5 class="media-heading"><strong>Natsuki teruya</strong>
                                       </h5>
                                       <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                       <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                   </div>
                               </div>
                           </a>
                       </li>
                       <li class="message-preview">
                           <a href="#">
                               <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                                   <div class="media-body">
                                       <h5 class="media-heading"><strong>Natsuki teruya</strong>
                                       </h5>
                                       <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                       <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                   </div>
                               </div>
                           </a>
                       </li>
                       <li class="message-footer">
                           <a href="#">Read All New Messages</a>
                       </li>
                   </ul>
               </li>
               <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                   <ul class="dropdown-menu alert-dropdown">
                       <li>
                           <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                       </li>
                       <li>
                           <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                       </li>
                       <li>
                           <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                       </li>
                       <li>
                           <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                       </li>
                       <li>
                           <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                       </li>
                       <li>
                           <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                       </li>
                       <li class="divider"></li>
                       <li>
                           <a href="#">View All</a>
                       </li>
                   </ul>
               </li>
               <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Natsuki teruya <b class="caret"></b></a>
                   <ul class="dropdown-menu">
                       <li>
                           <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                       </li>
                       <li>
                           <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                       </li>
                       <li>
                           <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                       </li>
                       <li class="divider"></li>
                       <li>
                           <a href="../../user/auth/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                       </li>
                   </ul>
               </li>
           </ul>
           <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
           <div class="collapse navbar-collapse navbar-ex1-collapse">
               <ul class="nav navbar-nav side-nav">
                   <li class="active">
                       <a href="index"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                   </li>
                   <li>
                       <a href="charts"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                   </li>
                   <li>
                       <a href="forms"><i class="fa fa-fw fa-edit"></i> Forms</a>
                   </li>
                   <li>
                       <a href="bootstrap-elements"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                   </li>
                   <li>
                       <a href="bootstrap-grid"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                   </li>
                   <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> ユーザー管理 <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="demo" class="collapse">
                           <li>
                               <a href="../join/index">新規ユーザー登録</a>
                           </li>
                           <li>
                               <a href="../admin/user_admin">ユーザー管理</a>
                           </li>
                       </ul>
                   </li>
                   <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#hoge"><i class="fa fa-fw fa-arrows-v"></i> オンライン英会話 <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="hoge" class="collapse">
                           <li>
                               <a href="#">授業スケジュール</a>
                           </li>
                           <li>
                               <a href="#">クラス管理</a>
                           </li>
                       </ul>
                   </li>
                   <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#fuga"><i class="fa fa-fw fa-arrows-v"></i> 物流システム <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="fuga" class="collapse">
                           <li>
                               <a href="#">物流スケジュール</a>
                           </li>
                           <li>
                               <a href="#">物流管理</a>
                           </li>
                       </ul>
                   </li>
               </ul>
           </div>
           <!-- /.navbar-collapse -->
       </nav>

         <!-- jQuery -->
         <script src="../../views/assets/js/admin/jquery.js"></script>
         <!-- table_sort -->
         <script src="../../views/assets/js/admin/jquery.tablesorter.min.js"></script> 
      
       <?php
           if (!isset($page)) {
             include('./views/' . $function . '/' . $directry . '.php');
           } else {
             include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
           }

        ?>
    </div>
    <!-- /#wrapper -->

        <!-- Bootstrap Core JavaScript -->
        <script src="../../views/assets/js/admin/bootstrap.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="../../views/assets/js/admin/plugins/morris/raphael.min.js"></script>
        <script src="../../views/assets/js/admin/plugins/morris/morris.min.js"></script>
        <script src="../../views/assets/js/admin/plugins/morris/morris-data.js"></script>

        <!-- Flot Charts JavaScript -->
        <script src="../../views/assets/js/admin/plugins/flot/jquery.flot.js"></script>
        <script src="../../views/assets/js/admin/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="../../views/assets/js/admin/plugins/flot/jquery.flot.resize.js"></script>
        <script src="../../views/assets/js/admin/plugins/flot/jquery.flot.pie.js"></script>
        <script src="../../views/assets/js/admin/plugins/flot/flot-data.js"></script>


</body>
</html>

