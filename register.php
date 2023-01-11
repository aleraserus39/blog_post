<?php 
session_start();

require "config_file/config.php";

if($_POST){
    $name= $_POST['name'];
    $email= $_POST['email'];
    $password= $_POST['password'];

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
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required value="">
            </div>
            <div class="form-group">
                <label for="content">Email</label>
                <input type="email" name="email" class="form-control" required value="" autocomplete="false">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required value="" autocomplete="false">
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
