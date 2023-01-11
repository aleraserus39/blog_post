<?php 

    require "../config_file/config.php";

    if(empty($_SESSION['username']) && empty($_SESSION['login_time'])){
        header("Location: login.php");
      }

    $stat= $pdo->prepare("DELETE FROM posts WHERE post_id=".$_GET['id']);
    $stat->execute();

    header('Location: index.php');

?>