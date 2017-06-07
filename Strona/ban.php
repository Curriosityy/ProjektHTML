<?php
    session_start();
    try{
      $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
      $dbh->query("SET NAMES utf8");
      if( isset($_POST["user"]))
      {
        $nazwa=$_POST["user"];
        $sql = "DELETE FROM konta WHERE nick='$nazwa'";
        $dbh->query($sql);
        header('Location: index.php');
        exit;
      }
    }
    catch(PDOException $e){
      echo 'Connection failed: ' . $e->getMessage();
    }
?>
