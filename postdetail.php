<?php 
session_start();
require "config_file/config.php";
require "config_file/common.php";

if(empty($_SESSION['user_id']) && empty($_SESSION['login_time'])){
  header("Location: login.php");
}

// print "<pre>";
// print_r($authorArr);
// exit();


if(isset($_POST['comment']) && ! empty($_POST['comment'])){

    $stat= $pdo->prepare("INSERT INTO comments (content,author_id,post_id) VALUES (:content,:author_id,:postId)" );
    $result =$stat->execute(
    array(':content'=>$_POST["comment"],':author_id'=>$_SESSION['user_id'],':postId'=>$_GET['id'])
    );

    if($result){
      header("Locatioin: postdetail.php?id=".$_GET['id']);
    }

    

  }
  

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog Details</title>

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
        <h1>Blog Details</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" >
        <div class="row">
            <div class="col-md-12">

            <?php 
            $postStat= $pdo->prepare("SELECT * FROM posts WHERE post_id=".$_GET['id']);
            $postStat->execute();
            $postResult= $postStat->fetch(PDO::FETCH_ASSOC);
            ?>
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block" style="">
                  <h3><?php echo escape($postResult['title'])?></h3>
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
                <img class="img-fluid pad" src="images/<?php echo escape($postResult['image'])?>" alt="Photo" style="width:100%;height:600px;object-fit:cover;"><br/><br>
                <p><?php echo escape($postResult['content'])?></p>
                <h2>Comments<a href="index.php" type="button" class="btn btn-default btn-inline">Back</a></h2><hr/>
                <div class="card-footer card-comments">
                
                   <div class="card-comment">
                    <!-- User image -->
                    <div class="comment-text" style="margin-left:0px !important;">
                    <?php 
                    
                    
                    $statCm= $pdo->prepare("SELECT * FROM comments WHERE post_id=".$_GET['id']);
                    $statCm->execute();
                    $cmResult= $statCm->fetchAll();
                    
                    
                    
                    $authorArr= [];
                    if($cmResult){
                      foreach ($cmResult as $key => $value) {
                        $authorId= $cmResult[$key]['author_id'];
                        $statAu= $pdo->prepare("SELECT * FROM users WHERE id=".$authorId);
                        $statAu->execute();
                        $authorArr[]= $statAu->fetchAll();
                       
                      }
                    }
                    foreach ($cmResult as $key => $value) {               
                    ?>
                      <span class="username">
                        
                        <?php echo $authorArr[$key][0]['name'];?>
                        <span class="text-muted float-right"><?php  echo $value['created_at'];?></span>
                      </span>
                      <?php echo escape($value['content']);?>
                    <?php
                      }
                
                     ?>

                    </div>

                  
                  <!-- /.comment-text -->
                </div>
               
                
           
               
                
              </div>
              <!-- /.card-header -->

               <!-- /.card-footer -->
               <div class="card-footer">
                <form action="" method="post">
                <input name="csrf" type="hidden" value="<?php echo ($_SESSION['csrf']); ?>">
                  <div class="img-push">
                    <input type="text" name='comment' class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
              </div>
              <!-- /.card-body -->
              
              
            </div>
            <!-- /.card -->
          </div>
         
          
          
  
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

  </div>
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
