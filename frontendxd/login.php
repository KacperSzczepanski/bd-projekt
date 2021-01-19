<HTML>
  <HEAD>
    <TITLE> Logowanie </TITLE>
  </HEAD>
  <BODY>
    <H2> Logowanie </H2>
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
      $haslo = $_REQUEST['haslo'];
      //echo $haslo."<br>";
      $stmt = oci_parse($conn, "SELECT pwd FROM users_tab WHERE login = :log");
      oci_bind_by_name($stmt, ":log", $login);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if($row = oci_fetch_array($stmt, OCI_BOTH))
      {
        if (password_verify($haslo, $row['PWD']))
        {
          $_SESSION['logn'] = $login;
          echo "Zalogowano poprawnie";
        }
        else {
          echo "Bledne haslo";
        }
      }
      else echo "Bledny login";
    ?>
    <br><A HREF='index.php'>Powrót<A><br>
  </BODY>
</HTML>
