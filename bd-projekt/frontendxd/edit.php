<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Edycja danych </TITLE>

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
  <BODY class="bodyRegister">
    <div style="width: 100%; height: 125px"></div>

    <div class="container menu40">
      <?PHP
        session_start();
        $logn = "";
        if(isset($_SESSION['logn'])){
          $logn = $_SESSION['logn'];
        }
        include('config.php');
        $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }
        $stmt = oci_parse($conn, "SELECT * FROM users_tab WHERE login = :lgn");
        oci_bind_by_name($stmt, ":lgn", $logn);
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        $row = oci_fetch_array($stmt, OCI_BOTH);
        echo "<H2>Edycja danych</H2>";
        echo "<form action=\"edits.php\" method=\"POST\">";
          echo "<div class=\"form-group\">";
            echo "<label for=\"haslo\">Nowe hasło:</label>";
            echo "<input type=\"password\" name=\"haslo\" class=\"form-control form-control-sm\" id=\"haslo\" placeholder=\"Wprowadź nowe hasło\" required>";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"name\">Nowe imię i nazwisko:</label>";
            echo "<input type=\"text\" name=\"name\" class=\"form-control form-control-sm\" id=\"name\" placeholder=\"Wprowadź nowe imię i nazwisko\" value=\"".$row['NAME']."\">";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"email\">Nowy email:</label>";
            echo "<input type=\"email\" name=\"email\" class=\"form-control form-control-sm\" id=\"email\" placeholder=\"Wprowadź nowy email\" value=\"".$row['EMAIL']."\">";
          echo "</div>";
          echo "<div class=\"form-group\">";
            echo "<label for=\"opis\">Nowy opis:</label>";
            echo "<textarea name=\"opis\" rows=\"5\" style=\"width: 100%; border-radius: 5px\" placeholder=\"Wprowadź nowy opis\">".$row['DESCR']."</textarea>";
          echo "</div>";
          ?>
        <button type="submit" class="btn btn-primary">Zmień</button>
      </form>
    </div>
    
    <div style="width: 100%; height: 25px"></div>

  </BODY>
</HTML>
