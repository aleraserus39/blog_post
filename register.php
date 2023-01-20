<?php 
session_start();

require "config_file/config.php";
require "config_file/common.php";

if($_POST){
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
    $name= $_POST['name'];
    $email= $_POST['email'];
    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stat= $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stat->bindValue(':email',$email);
    $stat->execute();

    $user= $stat->fetch(PDO::FETCH_ASSOC);
    if($user['email']){
        echo "<script>alert('Email is already exit. Please Login.');window.location.href='login.php';</script>";
    }

    $stat= $pdo->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)" );
      $result =$stat->execute(
        array(':name'=>$name,':email'=>$email,':password'=>$password)
    );
    if($result){
        echo("<script>alert('Successfully Registered.');window.location.href='login.php'</script>");
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Register</b>Form</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <form action="register.php" method="post" enctype="" autocomplete="off">
            <input name="csrf" type="hidden" value="<?php echo ($_SESSION['csrf']); ?>">
            <div class="form-group">
                <label for="name">Name</label><p style="color:red;"><?php echo !isset($nameError) ? "" : '*'.$nameError;?></p>
                <input type="text" name="name" class="form-control"  value="">
            </div>
            <div class="form-group">
                <label for="content">Email</label><p style="color:red;"><?php echo !isset($emailError) ? "" : '*'.$emailError;?></p>
                <input type="email" name="email" class="form-control"  value="" autocomplete="false">
            </div>
            <div class="form-group">
                <label for="password">Password</label><p style="color:red;"><?php echo !isset($passwordError) ? "" : '*'.$passwordError;?></p>
                <input type="password" name="password" class="form-control"  value="" autocomplete="false">
            </div>
           
            <input type="submit" name="register" class="btn btn-success btn-block" value="Register">
            <a href="login.php" type="button" class="btn btn-warning btn-block">Back</a>

    </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
