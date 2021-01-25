<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Strona główna </TITLE>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
      body {
        background-repeat: no-repeat;
        background-size: cover;
      }

      .bodyIndex {
          background-image: url("obrazy/index-tlo.jpg");
      }

      .bodyForms {
          background-image: url("obrazy/formy-tlo.jpg");
      }

      .bodyRegister {
          background-image: url("obrazy/rejestracja-tlo.jpg");
      }

      .bodyLogin {
          background-image: url("obrazy/logowanie-tlo.jpg");
      }

      .menuAuto {
          background-color: rgba(50, 50, 50, 0.8);
          border-radius: 10px;
          display: block;
          color: white;
          width: auto;
          margin: auto;
          padding: 15px;
          position: relative;
      }

      .menu40 {
          background-color: rgba(50, 50, 50, 0.8);
          border-radius: 10px;
          display: block;
          color: white;
          width: 40%;
          margin: auto;
          padding: 15px;
          position: relative;
      }

      a {
          display: inline-block;
      }

      a:link {
          color: white;
          background-color: transparent;
          text-decoration: none;
      }

      a:visited {
          color: white;
          background-color: transparent;
          text-decoration: none;
      }

      a:hover {
          color: blue;
          background-color: transparent;
          text-decoration: none;
      }

      a:active {
          color: darkblue;
          background-color: transparent;
          text-decoration: none;
      }

      .moveButtonToRight {
          padding: 0px;
          margin: 0px;
          position: absolute;
          right: 15px;
          bottom: 15px;
      }
    </style>
  </HEAD>
  <BODY class="bodyIndex">
    <?PHP
      session_start();
      $logn = "";
      if(isset($_SESSION['logn'])){
        $logn = $_SESSION['logn'];
      }
      $sj = "";
      $wyd = "";
      $typ = "";
      $aut="";
      $cl="";
      if(isset($_GET["subj"])) {
        $sj = "&subj=".$_GET["subj"];
      }
      if(isset($_GET["publ"])) {
        $wyd = "&publ=".$_GET["publ"];
      }
      if(isset($_GET["type"])) {
        $typ = "&type=".$_GET["type"];
      }
      if(isset($_GET["author"])) {
        $aut = "&author=".$_GET["author"];
      }
      if(isset($_GET["class"])) {
        $cl = "&class=".$_GET["class"];
      }
    ?>
    
    <nav class="navbar bg-dark navbar-dark">
      <?PHP
        if ($logn != "") {
          echo "<span class=\"navbar-brand\">Zalogowano jako ".$logn."</span>";
        } else {
          echo "<span class=\"navbar-brand\">Nikt nie jest teraz zalogowany</span>";
        }
      ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <?PHP 
            if ($logn != "") {
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"dodajksiazkeform.php\">Dodaj książkę</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"user.php\">Moje konto</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"logout.php\">Wyloguj</a>";
              echo "</li>";
            } else {
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"login.html\">Zaloguj</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"register.html\">Zarejestruj</a>";
              echo "</li>";
            }
          ?>
        </ul>
      </div>
    </nav>

    <div style="width: 100%; height: 69px"></div>

    <div class="menu40 container">
      <h2>Zastosuj filtry</h2>
        <a href="index.php"><h3>Wyczyść</h3></a><br>
        <?PHP 
          echo "<a href=\"przedmioty.php?".$sj.$wyd.$typ.$aut.$cl."\"><h3>Przedmiot</h3></a><br>";
          echo "<a href=\"klasy.php?".$sj.$wyd.$typ.$aut.$cl."\"><h3>Klasa</h3></a><br>";
          echo "<a href=\"wydawnictwa.php?".$sj.$wyd.$typ.$aut.$cl."\"><h3>Wydawnictwo</h3></a><br>";
          echo "<a href=\"autorzy.php?".$sj.$wyd.$typ.$aut.$cl."\"><h3>Autorzy</h3></a><br>";
          echo "<a href=\"typy.php?".$sj.$wyd.$typ.$aut.$cl."\"><h3>Typ książki</h3></a><br> ";
        ?>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
