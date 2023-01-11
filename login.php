<?php 
session_start();

require "config_file/config.php";

if($_POST){
    $email= $_POST['email'];
    $password= $_POST['password'];

    $stat= $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stat->bindValue(':email',$email);
    $stat->execute();

    $user= $stat->fetch(PDO::FETCH_ASSOC);
    // print_r($user['role']);
    // exit();

    if($user){

        

        if($user['password']== $password){
            $_SESSION['user_id']= $user['id'];
            $_SESSION['login_time']= time();

            header("Location: index.php");
            
        }else{
          echo "<script>alert('Password is not correct. Try again!');</script>";
        }
    }
    echo "<script>alert('Email doesn\'t exit. Please register first.');</script>";

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
    <a href="../../index2.html"><b>Login</b>Form</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login in to start your session</p>

      <form action="login.php" method="post" autocomplete="off">
        <div class="input-group mb-3">
          <input type="email" name='email'class="form-control" placeholder="Email" autocomplete="false" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name='password' class="form-control" placeholder="Password" autocomplete="false">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <a href="register.php" class="btn btn-default btn-block">Register</a>
          </div>
          <!-- /.col -->
        </div>
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
