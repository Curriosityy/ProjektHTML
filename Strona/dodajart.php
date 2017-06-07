<?php
    session_start();
    try{
      $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
      $dbh->query("SET NAMES utf8");
      if( isset($_POST["name"]) && isset($_POST["message"]) )
      {
        $nazwa=$_POST["name"];
        $tersc=$_POST["message"];
        $ilosc=0;
        date_default_timezone_set('Europe/Warsaw');
        $date = date('Y-m-d H:i:s', time());
        $rs = $dbh->prepare("INSERT INTO artykuly VALUES( NULL, :nazwa, :tresc, :data, :ilosc) ");
        $rs->execute([ ':nazwa' => $nazwa , ':tresc' => $tersc , ':data' => $date , ':ilosc' => $ilosc]);
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
