<?php 
session_start();
require "../config_file/config.php";
require "../config_file/common.php";

if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
  header("Location: login.php");
}

if($_POST){
  echo $_SESSION['csrf'];
  exit();
  if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
    if(empty($_POST['name'])){
      $nameError= "Name cann't be null";
    }
    if(empty($_POST['email'])){
      $emailError= "Email cann't be null";
    }
    if(empty($_POST['password'])){
      $passwordError= "Password cann't be null";
    }
  }elseif(strlen($_POST['password']) < 6){
    if(strlen($_POST['password']) < 6){
      $passwordError= "Password must above 6 character.";
    }
  }else{
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['gridRadios'])){
    
      $name= $_POST['name'];
      $email= $_POST['email'];
      $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
      $role= $_POST['gridRadios'];
    
      $stat= $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (:name,:email,:password,:role)" );
      $result =$stat->execute(
        array(':name'=>$name,':email'=>$email,':password'=>$password,'role'=>$role)
      );
      if($result){
        echo("<script>alert('Successfully created.');window.location.href='user_list.php'</script>");
      }
    }else{
      echo("<script>alert('From is not completed. Please try again!');</script>");
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
        <form action="" method="post">
        <input name="csrf" type="hidden" value="<?php echo ($_SESSION['csrf']); ?>">
        <!-- <input type="hidden" name="post_id" class=''> -->
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label><p style="color:red;"><?php echo !isset($nameError) ? "" : '*'.$nameError;?></p>
                <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label><br/><p style="color:red;"><?php echo !isset($emailError) ? "" : '*'.$emailError;?></p>
                <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label><br/><p style="color:red;"><?php echo !isset($passwordError) ? "" : '*'.$passwordError;?></p>
                <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
                </div>
            </div>
            <fieldset class="form-group" required>
                <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Role</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" >
                    <label class="form-check-label" for="gridRadios1">
                        Admin
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0">
                    <label class="form-check-label" for="gridRadios2">
                        User
                    </label>
                    
                </div>
            </fieldset>

            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="user_list.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </div>
        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
 
 <!-- Main Footer -->
 <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" type="button" class="btn btn-default" >Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 6-Dec-2022 <a href="https://adminlte.io">Aprogrammer</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
