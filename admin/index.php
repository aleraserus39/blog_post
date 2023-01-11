<?php 
session_start();
require "../config_file/config.php";

if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
  header("Location: login.php");
}

if($_SESSION['role'] != 1){
  echo "<script>alert('Account doesn\'t exit. Try again!');window.location.href='login.php';</script>";

}

if(!empty($_POST['search'])){
  setcookie('search',$_POST['search'],time() + (86400 * 30), "/");
}else{
  if(empty($_GET['pageno'])){
    unset($_COOKIE['search']); 
    setcookie('search', "",time() + (86400 * 30), "/"); 
  }
}

?>
<?php include("header.php")?>


     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Bordered Table</h5>
              </div>
              <div class="card-body">
                <div class=""><a href="add.php" class="btn btn-success">New Blog Post</a></div><br>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Content</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  
                  
                    if(!empty($_GET['pageno'])){
                      $pageno= $_GET['pageno'];
                    }else{
                      $pageno= 1;
                    }
                    $showRecs=3;
                    $offset= ($pageno-1)* $showRecs;

                    if(!empty($_POST['search']) || !empty($_COOKIE['search'])){
                    $searchRs= isset($_COOKIE['search']) ? $_COOKIE['search'] : $_POST['search'];

                    $stat= $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchRs%'");
                    $stat->execute();
                    $rawResult= $stat->fetchAll();

                    $total_pages= ceil(count($rawResult) / $showRecs);
   

                    $stat= $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchRs%' LIMIT $offset,$showRecs");
                    $stat->execute();
                    $result= $stat->fetchAll();
                    }else{
                    $stat= $pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC");
                    $stat->execute();
                    $rawResult= $stat->fetchAll();
                    // print_r($rawResult);exit;

                    $total_pages= ceil(count($rawResult) / $showRecs);

                    $stat= $pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC LIMIT $offset,$showRecs");
                    $stat->execute();
                    $result= $stat->fetchAll();
                    }

                    $i= 1;

                    foreach ($result as $value) {
                    
                  ?>
                     <tr>
                      <td><?php echo $i?></td>
                      <td><?php echo $value['title']?></td>
                      <td><?php echo substr($value['content'],0,50)?></td>
                      <td>
                        <!-- <a href="#" class="">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a> -->
                        <div class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['post_id']?>" type="button" class="btn btn-warning" >Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['post_id']?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php
                    $i++;
                    }
                  ?>
                  
                    
                  </tbody>
                </table>
                <nav aria-label='Page navigation example' style="float:right;">
                    <ul class='pagination'>
                      <li class='page-item'><a class="page-link" href="?pageno=1">First</a></li>
                      <li class="page-item <?php if($pageno <=1){echo "disabled";}?>">
                        <a class="page-link" href="<?php if($pageno <=1){echo '#';}else{echo '?pageno='.($pageno-1);}?>"><<</a>
                      </li>
                      <li class='page-item'><a class="page-link" href="#"><?php echo $pageno?></a></li>
                      <li class='page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>'>
                        <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);}?>">>></a>
                      </li>
                      <li class='page-item'><a class="page-link" href="?pageno=<?php echo ($total_pages);?>">Last</a></li>
                    </ul>
                </nav>
              </div>
            </div>
                    
            
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>



  

  <?php include('footer.php')?>

