<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2</title>
</head>
<body>

    <header><h1><a id="logo" href="index.php" title="Logo"><img src="foto/logo.png" alt="logo"></a></h1>
      <nav id="menu">
          <ul>
            <li><a href="index.php">strona główna</a></li>
            <?php
                        session_start();
                        if(isset($_SESSION['zalogowany']))
                        {
                          try
                          {
                            $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
                            $dbh->query("SET NAMES utf8");
                            $sql2 = "SELECT nick,admin FROM konta";
                            foreach ($dbh->query($sql2) as $kontoadm)
                             {
                                if(isset($_SESSION['zalogowany']))
                                {
                                  if( $_SESSION['zalogowany']==$kontoadm['nick'])
                                  {
                                    if($kontoadm['admin']==1)
                                    {
                                      echo "<li><a href=\"dodaj_artykul.php\">dodaj artykul</a></li>";
                                      echo "<li><a href=\"zbanuj.php\">BAN</a></li>";
                                    }
                                  }
                                }
                            }
                          }
                          catch(PDOException $e)
                          {
                            echo 'Connection failed: ' . $e->getMessage();
                          }
                            if($_SESSION['zalogowany'] != "")
                            {
                                echo "<li>";
                                echo $_SESSION['zalogowany'];
                                echo "</li>";
                                echo "<li>";
                                echo "<a href=\"wyloguj.php\">wyloguj</a>";
                                echo "</li>";
                            }else
                            {
                              echo "<li><a href=\"logowanie.php\">logowanie</a></li>";
                              echo "<li><a href=\"rejestracja.php\">rejestracja</a></li>";
                            }

                        }else
                        {
                          echo "<li><a href=\"logowanie.php\">logowanie</a></li>";
                          echo "<li><a href=\"rejestracja.php\">rejestracja</a></li>";
                        }
                ?>
          </ul>
      </nav>
    </header>
  <div id="center">
    <main>
        <article class="content">
          <div class="container">
          <section class="item2">
          <?php
          header( 'Content-Type: text/html; charset=utf-8' );
          try{
            $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
            $dbh->query("SET NAMES utf8");
            if(!isset($_POST["hiddID"])){
              header('Location: index.php');
              exit;
            }
            $id=$_POST['hiddID'];
            $sql= 'SELECT id_artykulu,nazwa,artykul,data,IloscWejsc FROM artykuly';
            foreach ($dbh->query($sql) as $posta)
            {
              if($posta['id_artykulu']==$id)
              {
                echo "  <section class=\"item2\">";
                echo "<h2>";
                echo $posta['nazwa'];
                echo "</h2>";
                echo "<p>";
                echo $posta['artykul'];
                echo "</p>";

                $suma = (int)$posta['IloscWejsc']+1;
                $sql="UPDATE artykuly SET IloscWejsc='$suma' WHERE id_artykulu='$id'";
                $dbh->query($sql);
              }
            }
            $sql2 = "SELECT nick,admin,id_konta FROM konta";
            foreach ($dbh->query($sql2) as $konto) {
                if(isset($_SESSION['zalogowany']))
                {
                  if( $_SESSION['zalogowany']==$konto['nick'])
                  {
                    if($konto['admin']==1){

                      echo "<form method=\"post\" action=\"usun_art.php\">";
                      echo "<input type=\"hidden\" name=\"hiddID\" value=\"";
                      echo $id;
                      echo "\"/>";
                      echo "<input type=\"submit\" value=\"Usun artykul\" >";
                      echo "</form>";


                      echo "<form method=\"post\" action=\"modyf_artykul.php\">";
                      echo "<input type=\"hidden\" name=\"hiddID\" value=\"";
                      echo $id;
                      echo "\"/>";
                      echo "<input type=\"submit\" value=\"Modyfikuj artykul\" >";
                      echo "</form>";
                    }

                      echo "<form method=\"post\" action=\"dodaj_kom.php\">";

                      echo "<input type=\"hidden\" name=\"hiddID\" value=\"";
                      echo $id;
                      echo "\"/>";

                      echo "<input type=\"submit\" value=\"Dodaj Komentarz\" >";
                      echo "</form>";
                      echo "</section>";
                  }
                  }
                }
                $sql3 = "SELECT id_komentarza,id_art,id_konta,data,komentarz FROM komentarze WHERE id_art='$id'";

                echo "  <section class=\"item2\">";
                echo "<h2>Komentarze</h2>";
                foreach ($dbh->query($sql3) as $wartosci1) {
                //$sql4 = "SELECT id_konta,nick FROM konta WHERE id_konta='$wartosci1[id_konta]'";
                $sql4 = "SELECT id_konta,nick,admin FROM konta";
                  foreach($dbh->query($sql4) as $wartosci2){
                  if($wartosci1['id_konta']==$wartosci2['id_konta'])
                  {
                  echo "<p>";
                  echo $wartosci2['nick'];
                  echo ":";
                  echo $wartosci1['komentarz'];
                  }
                  if(isset($_SESSION['zalogowany']))
                  {
                    if(($_SESSION['zalogowany']==$wartosci2['nick'] && $wartosci1['id_konta']==$wartosci2['id_konta']) || ($_SESSION['zalogowany']==$wartosci2['nick'] && $wartosci2['admin']==1) )
                    {
                      echo "<form method=\"post\" action=\"usun_kom.php\">";
                      echo "<input type=\"hidden\" name=\"hiddIDKom\" value=\"";
                      echo $wartosci1['id_komentarza'];
                      echo "\"/>";
                      echo "<input type=\"submit\" value=\"Usun Komentarz\" >";
                      echo "</form>";


                      echo "<form method=\"post\" action=\"modyf_kom.php\">";
                      echo "<input type=\"hidden\" name=\"hiddIDKom\" value=\"";
                      echo $wartosci1['id_komentarza'];
                      echo "\"/>";
                      echo "<input type=\"submit\" value=\"Modyfikuj Komentarz\" >";
                      echo "</form>";
                    }
                  }
                  echo "</p>";

                }
              }
                echo "</section>";
          }
          catch(PDOException $e){
            echo 'Connection failed: ' . $e->getMessage();
          }
           ?>
          </div>
        </article>
        <aside class="bar">
        <div>
          <h3>Zegarek</h3>
          <div id="fCzas"></div>
        </div>
        <div>
          <h3>Najczęściej czytane</h3>
          <ul>
            <?php
            try
            {
              $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
              $dbh->query("SET NAMES utf8");
              $sql = "SELECT id_artykulu,nazwa,IloscWejsc FROM artykuly ORDER BY 3 DESC";
              foreach ($dbh->query($sql) as $wartosci3) {

                echo "<form method=\"post\" action=\"szablon_post.php\">";
                echo "<input type=\"hidden\" name=\"hiddID\" value=\"";
                echo $wartosci3['id_artykulu'];
                echo "\"/>";
                echo "<input class=\"btn-link\" type=\"submit\" value=\"";
                echo $wartosci3['nazwa'];
                echo "\" >";
                echo "</form>";
              }
            }catch(PDOException $e){
              echo 'Connection failed: ' . $e->getMessage();
            }
             ?>
          </ul>
        </div>
      </aside>
    </main>
    <footer><h6>na tym blogu dowiesz się jak tworzyć gry w c++, w bibliotece SFML</h6></footer>
  </div>
  <script type="text/javascript" src="zegarek.js"></script>

</body>
</html>
