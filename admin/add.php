<?php 
session_start();
require "../config_file/config.php";

if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
  header("Location: login.php");
}

if($_POST){
  $title= $_POST['title'];
  $content= $_POST['content'];
  

  $targetFile= '../images/'.($_FILES['image']['name']);
  $imageFileType= pathinfo($targetFile,PATHINFO_EXTENSION);

  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif"){
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed');</script>";
    }else{
      $img= $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);

      $stat= $pdo->prepare("INSERT INTO posts (title,content,image,author_id) VALUES (:title,:content,:image,:author_id)" );
      $result =$stat->execute(
        array(':title'=>$title,'content'=>$content,'image'=>$img,'author_id'=>$_SESSION['user_id'])
      );
    }

  if($result){
    echo("<script>alert('Successfully posted.');window.location.href='index.php'</script>");
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
            <h1 class="m-0">Posting Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <form action="add.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control"  rows="5" name='content' required ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label><br/>
                            <input type="file" name="image"  class="" required>
                        </div>
                        <input type="submit" name="submit" class="btn btn-success" value="SUBMIT">
                        <a href="index.php" type="button" class="btn btn-warning">Back</a>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php')?>
        