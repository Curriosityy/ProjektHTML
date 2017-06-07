<?php
    session_start();
    try{
      $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
      $dbh->query("SET NAMES utf8");
      if(!isset($_POST["hiddIDKom"])){
        header('Location: index.php');
        exit;
      }
      $id=$_POST['hiddIDKom'];
      $sql = "DELETE FROM komentarze WHERE id_komentarza= '$id'";
      $dbh->query($sql);
      header('Location: index.php');
      exit;
    }
    catch(PDOException $e){
      echo 'Connection failed: ' . $e->getMessage();
    }
?>
