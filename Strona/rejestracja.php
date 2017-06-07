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
                    <h2>Panel Uzytkowania</h2>
          <div class="container">
              <section class="item2">
                          <h2>Logowanie</h2>
                <form method="post">
                        Login: <input type="text" name="user">
                        <br>
                        Hasło: <input type="password" name="password">
                        <br>
                        Email: <input type="email" name="email">
                        <br>
                        <input type="submit">
                </form>
              </section>
          </div>
          <?php
          try{
            $dbh = new PDO ('mysql:host=localhost;dbname=blog','root','');
            $dbh->query("SET NAMES utf8");
            if( isset($_POST["user"]) && isset($_POST["password"]) && isset($_POST["email"]) )
            {
              $flaga = 3;
              $login = $_POST["user"];
              $pass = $_POST["password"];
              $email = $_POST["email"];
              $haslohash = hash('sha256',$pass);
              $sql = 'SELECT nick,email FROM konta';
              foreach($dbh->query($sql) as $konto)
              {
                if($konto['nick'] == $login)
                {
                $flaga=3;
                break;
                }
                else
                if($konto['email'] == $email)
                {
                $flaga=4;
                break;
              }else {
                $flaga=0;
              }
              }
              if($flaga == 0)
              {
                $admin = 0;
                $rs = $dbh->prepare("INSERT INTO konta VALUES( NULL, :nick, :email, :admin, :haslohash) ");
                $rs->execute([ ':nick' => $login , ':email' => $email , ':admin' => $admin , ':haslohash' => $haslohash]);
                header('Location: index.php');
                exit;
              }else
              if($flaga==3)
              {
                echo "<script type=\"text/javascript\">window.alert( \"Login zajety\" );</script>";
                exit;
              }else
              if($flaga==4)
              {
                echo "<script type=\"text/javascript\">window.alert(\"email zajety\" );</script>";
                exit;
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
