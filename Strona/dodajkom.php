<?php
    session_start();
    try{
      $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
      $dbh->query("SET NAMES utf8");
      if(isset($_POST["message"]) )
      {
        $id=$_POST["hiddIDArt1"];
        $id2=$_POST["hiddIDKonta1"];
        $tersc=$_POST["message"];

        date_default_timezone_set('Europe/Warsaw');
        $date = date('Y-m-d H:i:s', time());
        $rs = $dbh->prepare("INSERT INTO komentarze VALUES( NULL, :id_art, :id_kon, :data,:koment) ");
        $rs->execute([':id_art' => $id , ':id_kon' => $id2 , ':data' => $date , ':koment' => $tersc]);
        header('Location: index.php');
        exit;
      }
      else {
        echo "<script type=\"text/javascript\">window.alert( \"brak\" );</script>";
      }
    }
    catch(PDOException $e){
      echo 'Connection failed: ' . $e->getMessage();
    }
?>
