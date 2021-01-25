<!DOCTYPE HTML>
  <HEAD>
    <TITLE>Zgłaszanie błędu</TITLE>

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
  <BODY class="bodyForms">
    <?PHP
      session_start();
      $logn = "";
      if(isset($_SESSION['logn']))
        $logn = $_SESSION['logn'];
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      $ks = oci_parse($conn, "SELECT name FROM books WHERE id = :id");
      oci_bind_by_name($ks, ":id", $_GET['book']);
      oci_execute($sub, OCI_NO_AUTO_COMMIT);
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

    <div class="container menuAuto">
      <h2>Zgłoś błąd w książce</h2>
      <?PHP 
        if ($row = oci_fetch_array($ks, OCI_BOTH)) {
          echo "<h2>".$row['NAME']."</h2>";
        }

        echo "<form action=\"dodajblad.php?book=".$_GET['book']."\" method=\"POST\">";
      ?>

        <div class="form-group">
          <label for="edi">Wydanie (rok):</label>
          <input type="number" name="edi" min="1900" max="2020" class="form-control form-control-sm" placeholder="Wprowadź rok wydania książki">
        </div>
        <div class="form-group">
          <label for >Strona:</label>
          <input type="number" name="pag" min="0" max="10000" class="form-control form-control-sm" placeholder="Wprowadź numer strony, na której jest błąd">
        </div>
        <div class="form-group">
          <label for="opis">Opis:</label>
          <textarea name="opis" rows="5" style="width: 100%; border-radius: 5px" placeholder="Opisz błąd"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Zgłoś</button>
      </form>

      <form action="index.php" method="POST" class="moveButtonToRight">
        <button type="submit" class="btn btn-primary">Powrót</button>
      </form>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
