<?php 

session_start();

 require "../config_file/config.php";

 if(empty($_SESSION['user_id']) && empty($_SESSION['login_time'])){
    header("Location: user_list.php");
  }
// echo $_SESSION['login_time'];
// exit();

  if($_POST){

    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['gridRadios'])){
        $name= $_POST['name'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $role= $_POST['gridRadios'];

        $stat= $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id=".$_GET['id']);
        $success= $stat->execute();

        if($success){
            echo "<script>alert('Successfully Updated.');window.location.href='user_list.php'</script>";
        }
    }else{
            echo "<script>alert('Form is not completed. Try Again!');</script>";
         }
    

        
    
        
    
        
    //  }

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
            <h1 class="m-0">User Edition</h1>
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
                        
                        $stat= $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
                        $stat->execute();
                        $result= $stat-> fetch(PDO::FETCH_ASSOC);


                        // print "<pre>";
                        // print_r($result);
                        // exit();

                    ?>
                    <form action="" method="post" >
                        <input type="hidden" name="id" class=''>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $result['name']?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required value="<?php echo $result['email']?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required value="<?php echo $result['password']?>">
                        </div>
                        <fieldset class="form-group" required>
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Role</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" <?php if($result['role']==1){echo 'checked="checked"';}?>>
                                    <label class="form-check-label" for="gridRadios1">
                                        Admin
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0" <?php if($result['role']==0){echo 'checked="checked"';}?>>
                                    <label class="form-check-label" for="gridRadios2">
                                        User
                                    </label>
                            </div>
                        </fieldset>
                        <input type="submit" name="submit" class="btn btn-success" value="SUBMIT">
                        <a href="user_list.php" type="button" class="btn btn-warning">Back</a>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php')?>