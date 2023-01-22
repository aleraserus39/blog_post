<?php 
session_start();
require "config_file/config.php";
require "config_file/common.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['login_time'])){
  header("Location: login.php");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog Posts</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="text-align: center;">
        <h1>Blog Posts</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" >
        <div class="row">

          <?php 

            if(!empty($_GET['pageno'])){
              $pageno= $_GET['pageno'];
            }else{
              $pageno=1;
            }

            $showRes= 6;
            $offset= ($pageno-1)*$showRes;
          
            $stat= $pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC");
            $stat->execute();
            $rawResult= $stat->fetchAll();
            $tPage= ceil(count($rawResult)/$showRes);

            $stat= $pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC LIMIT $offset,$showRes");
            $stat->execute();
            $result= $stat->fetchAll();
            
            $i= 1;

            foreach($result as $value){
          ?>
            <div class="col-md-4">

              <div class="card card-widget">
                <div class="card-header">
                  <div class="user-block" style="">
                    <h3><?php echo escape($value['title'])?></h3>
                  </div>
                  <!-- /.user-block -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" title="Mark as read">
                      <i class="far fa-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <a href="postdetail.php?id=<?php echo $value['post_id']?>"><img class="img-fluid pad" src="images/<?php echo $value['image']?>" alt="Photo" style="height:200px !important;width:100%;object-fit:cover;"></a>
                  

                  
                </div>

                
                
              </div>

            </div>
          <?php
            $i++;
            }
          ?>
          
          
  
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

  </div><br/>

      <!-- Pagination-->
  <nav aria-label='Page navigation example' style="display:flex;justify-content:center;align-item:center;">
                    <ul class='pagination'>
                      <li class='page-item'><a class="page-link" href="?pageno=1">First</a></li>
                      <li class="page-item <?php if($pageno <=1){echo "disabled";}?>">
                        <a class="page-link " href="<?php if($pageno <=1){echo'#';}else{echo '?pageno='.($pageno-1);}?>"><<</a>
                      </li>
                      <li class='page-item'><a class="page-link" href="#"><?php echo $pageno;?></a></li>
                      <li class='page-item <?php if($pageno >= $tPage){echo "disabled";}?>'>
                        <a class="page-link" href="<?php if($pageno >= $tPage){echo '#';}else{echo '?pageno='.($pageno+1);} ?>">>></a>
                      </li>
                      <li class='page-item'><a class="page-link" href="?pageno=<?php echo $tPage;?>">Last</a></li>
                    </ul>
  </nav>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important;">
    <div class="float-right d-none d-sm-inline">
        <a href="logout.php" type="button" class="btn btn-default" >Logout</a>
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
