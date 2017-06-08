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
                              echo "<a href=\"zmiana.php\">Zmiana</a>";
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
                    <h2>Panel Uzytkowania</h2>
          <div class="container">
              <section class="item2">
                <form method="post">
                      Stare Hasło: <input type="password" name="passwords">
                      <br>
                      Nowe Hasło: <input type="password" name="passwordn">
                      <br>
                      <input type="submit">
                </form>
                <form method="post">
                        Nowy Email: <input type="email" name="email">
                        <br>
                        <input type="submit">
                </form>
              </section>
          </div>
          <?php
          try{
            $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
            $dbh->query("SET NAMES utf8");
            if(isset($_POST["passwords"]) && isset($_POST["passwordn"]) )
            {
              $flaga=1;
              $passs = $_POST["passwords"];
              $passn = $_POST["passwordn"];
              //$email = $_POST["email"];
              $hasloshash = hash('sha256',$passs);
              $haslonhash = hash('sha256',$passn);
              $id=$_SESSION['zalogowany'];
              $sql="SELECT haslo,nick FROM konta WHERE nick='$id'";
              foreach ($dbh->query($sql) as $konto)
               {
                  $sql2="UPDATE konta SET haslo='$haslonhash' WHERE nick='$id'";
                  if($konto['haslo']==$hasloshash){
                  $dbh->query($sql2);
                  $flaga=0;
                  }
                }
                if($flaga==1)
                {
                  echo "<script type=\"text/javascript\">window.alert(\"bledne haslo\" );</script>";
                  exit;
                }
            }
            if(isset($_POST["email"]) )
            {
              $flaga=0;
              $email = $_POST["email"];
              $id=$_SESSION['zalogowany'];
              $sql="SELECT email,nick FROM konta WHERE nick='$id'";
              foreach ($dbh->query($sql) as $konto)
               {
                 if($konto['email']!=$email)
                 {
                   $flaga=1;
                 }
               }
               if($flaga==1)
               {
                 echo "<script type=\"text/javascript\">window.alert(\"email zajety\" );</script>";
                 exit;
               }
               if($flaga==0){
                 $sql2="UPDATE konta SET email='$email' WHERE nick='$id'";
                 $dbh->query($sql2);
              }
            }
          }
          catch (PDOException $e)
          {
                echo 'Connection failed: ' . $e->getMessage();
          }

          ?>
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
