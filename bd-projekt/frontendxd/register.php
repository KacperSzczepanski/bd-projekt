<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Rejestracja </TITLE>

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
        include('config.php');
        $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }

        $login = $_REQUEST['login'];
        $haslo = password_hash($_REQUEST['haslo'], PASSWORD_DEFAULT);

        $check = oci_parse($conn, "SELECT COUNT(*) A FROM users_tab WHERE login = :log");
        oci_bind_by_name($check, ":log", $login);
        oci_execute($check, OCI_NO_AUTO_COMMIT);
        if($row = oci_fetch_array($check, OCI_BOTH))
        {
          if ($row['A'] == 1)
            echo "<h3>Login zajęty</h3>";
          else {$_SESSION['logn']=$login;

            $stmt = oci_parse($conn, "INSERT INTO users_tab
            VALUES (:login, :pwd, :name, :email, :descr)");
            oci_bind_by_name($stmt, ":login", $login);
            oci_bind_by_name($stmt, ":pwd", $haslo);
            oci_bind_by_name($stmt, ":name", $_REQUEST['name']);
            oci_bind_by_name($stmt, ":email", $_REQUEST['email']);
            oci_bind_by_name($stmt, ":descr", $_REQUEST['opis']);
            oci_execute($stmt, OCI_NO_AUTO_COMMIT);
            oci_commit($conn);
            echo "<h3>Rejestracja udana</h3>";
          }
        }
      ?>
      <form action="index.php" method="POST">
        <button type="submit" class="btn btn-primary">Powrót</button>
      </form>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
