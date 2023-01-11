<?php 

    require "../config_file/config.php";

    if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
        header("Location: login.php");
      }

    $stat= $pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
    $stat->execute();

    header('Location: user_list.php');

?>