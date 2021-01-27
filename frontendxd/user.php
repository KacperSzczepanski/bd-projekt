<HTML>
  <HEAD>
    <TITLE> Dane użytkownika </TITLE>

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
      <h2>Dane użytkownika</h2>
      <?PHP
        session_start();
        include('config.php');
        $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }
        $logn = "";
        if(isset($_SESSION['logn'])){
          $logn = $_SESSION['logn'];
        }
        $stmt = oci_parse($conn, "SELECT * FROM users_tab WHERE login = :lgn");
        if(isset($_GET['u']))
        oci_bind_by_name($stmt, ":lgn", $_GET['u']);
        else oci_bind_by_name($stmt, ":lgn", $logn);
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
          echo "<h3>Imię i nazwisko: ".$row['NAME']."</h3>";
          echo "<h3>Opis: ".$row['DESCR']."</h3>";
          if($row['LOGIN']==$logn) {
            echo "<h3>Email: ".$row['EMAIL']."</h3>";
            echo "<h3>Login: ".$row['LOGIN']."</h3>";
            echo "<form action=\"edit.php\" method=\"POST\" style=\"padding: 0px; margin: 0px; display: inline-block;\">";
              echo "<button type=\"submit\" class=\"btn btn-primary\">Zmień swoje dane</button>";
            echo "</form>";
            echo "<form action=\"index.php\" method=\"POST\" class=\"moveButtonToRight\">";
              echo "<button type=\"submit\" class=\"btn btn-primary\">Powrót</button>";
            echo "</form>";
          }
        }
      ?>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
