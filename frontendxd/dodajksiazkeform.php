<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>

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
        $sub = oci_parse($conn, "SELECT * FROM subject");
        oci_execute($sub, OCI_NO_AUTO_COMMIT);
        $pub = oci_parse($conn, "SELECT * FROM publish_house");
        oci_execute($pub, OCI_NO_AUTO_COMMIT);
        $typ = oci_parse($conn, "SELECT * FROM book_types");
        oci_execute($typ, OCI_NO_AUTO_COMMIT);
        $cla = oci_parse($conn, "SELECT * FROM class_levels ORDER BY id");
        oci_execute($cla, OCI_NO_AUTO_COMMIT);
        $zak = oci_parse($conn, "SELECT * FROM levels ORDER BY id");
        oci_execute($zak, OCI_NO_AUTO_COMMIT);
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
      <h2>Dodaj książkę do naszego zbioru!</h2>

      <?PHP
        echo "<form action=\"dodajksiazke.php\" method=\"POST\">";

          echo "<div class=\"form-group>";
            echo "<label for=\"nazwa\">Nazwa książki:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"nazwa\" placeholder=\"Wprowadź nazwę książki\" required>";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autora\">Autor 1:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autora\" placeholder=\"Wprowadź nazwisko i imię autora\" required>";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autorb\">Autor 2:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autorb\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autorc\">Autor 3:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autorc\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autord\">Autor 4:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autord\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autore\">Autor 5:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autore\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autorf\">Autor 6:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autorf\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          echo "<div class=\"form-group>";
            echo "<label for=\"autorg\">Autor 7:</label>";
            echo "<input class=\"form-control form-control-sm\" type=\"text\" name=\"autorg\" placeholder=\"Wprowadź nazwisko i imię autora\">";
          echo "</div>";
          
          echo "<div class=\"form-group\">";
            echo "<label for=\"wydawnictwo\">Wydawnictwo:</label>";
            echo "<select class=\"form-control form-control-sm\" name=\"wydawnictwo\">";
            while ($row = oci_fetch_array($pub, OCI_BOTH)) {
              echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
            }
            echo "</select>";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"przedmiot\">Przedmiot:</label>";
            echo "<select class=\"form-control form-control-sm\" name=\"przedmiot\">";
            while ($row = oci_fetch_array($sub, OCI_BOTH)) {
              echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
            }
            echo "</select>";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"rodzajksiazki\">Typ książki:</label>";
            echo "<select class=\"form-control form-control-sm\" name=\"rodzajksiazki\">";
            while ($row = oci_fetch_array($typ, OCI_BOTH)) {
              echo "<option value=\"".$row['ID']."\">".$row['BTYPE']."</option>";
            }
            echo "</select>";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"klasa\">Klasa:</label>";
            echo "<select class=\"form-control form-control-sm\" name=\"klasa\">";
            while ($row = oci_fetch_array($cla, OCI_BOTH)) {
              echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
            }
            echo "</select>";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"zakres\">Zakres:</label>";
            echo "<select class=\"form-control form-control-sm\" name=\"zakres\">";
            echo "<option value=\"-1\"></option>";
            while ($row = oci_fetch_array($zak, OCI_BOTH)) {
              echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
            }
            echo "</select>";
          echo "</div>";

          echo "<button type=\"submit\" class=\"btn btn-primary\">Dodaj</button>";
        echo "</form>"
      ?>

      <form action="index.php" method="POST" class="moveButtonToRight">
        <button type="submit" class="btn btn-primary">Powrót</button>
      </form>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
