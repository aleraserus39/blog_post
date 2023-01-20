<?php 

session_start();

 require "../config_file/config.php";
 require "../config_file/common.php";

 if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
    header("Location: login.php");
  }

if($_POST){
    if(empty($_POST['title']) || empty($_POST['content'])){
        if(empty($_POST['title'])){
          $titleError= "Title cann't be null";
        }
        if(empty($_POST['content'])){
          $contentError= "Content cann't be null";
        }
    }else{
        $title= $_POST['title'];
        $content= $_POST['content'];
        $filename= $_FILES['image']['name'];


        if($filename){
            $target_file= "../images/".$filename;
            $imageFileType= pathinfo($target_file,PATHINFO_EXTENSION);


        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"){
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed');</script>";
            }else{
                    // print_r($_FILES['image']['tmp_name']);
            move_uploaded_file($_FILES['image']['tmp_name'],$target_file);

            $stmt= $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$filename' WHERE post_id=".$_GET['id']);
            $success= $stmt->execute();

            if($success){
                echo "<script>alert('Successfully Updated.');window.location.href='index.php'</script>";
            }
        
            }
        }else{
            $stmt= $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE post_id=".$_GET['id']);
            $success= $stmt->execute();

            if($success){
                echo "<script>alert('Successfully Updated.');window.location.href='index.php'</script>";
            }
}
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
            <h1 class="m-0">Post Edition</h1>
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
                    <?php 
                        
                        $stat= $pdo->prepare("SELECT * FROM posts WHERE post_id=".$_GET['id']);
                        $stat->execute();
                        $result= $stat-> fetch(PDO::FETCH_ASSOC);


                        // print "<pre>";
                        // print_r($result['image']);
                        // exit();

                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                    <input name="csrf" type="hidden" value="<?php echo ($_SESSION['csrf']); ?>">
                        <input type="hidden" name="post_id" class=''>
                        <div class="form-group">
                            <label for="title">Title</label><p style="color:red;"><?php echo !isset($titleError) ? "" : '*'.$titleError;?></p>
                            <input type="text" name="title" class="form-control" required value="<?php echo $result['title']?>">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label><p style="color:red;"><?php echo !isset($contentError) ? "" : '*'.$contentError;?></p>
                            <textarea class="form-control"  rows="5" name='content' required ><?php echo $result['content']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Update Image</label><br/>
                            <img src="../images/<?php echo $result['image'] ?>" alt="" width='100' height='100'><br/><br/>
                            <input type="file" name="image"  class="" >
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