<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> rejestracja: </H2>
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
          echo "login zajety";
        else {$_SESSION['logn']=$login;

          $stmt = oci_parse($conn, "INSERT INTO users_tab
          VALUES (:login, :pwd, :name, :email, :descr)");
          oci_bind_by_name($stmt, ":login", $login);
          oci_bind_by_name($stmt, ":pwd", $haslo);
          oci_bind_by_name($stmt, ":name", $_REQUEST['name']);
          oci_bind_by_name($stmt, ":email", $_REQUEST['email']);
          oci_bind_by_name($stmt, ":descr", $_REQUEST['opis']);
          /*echo $login."<br>";
          echo $haslo."<br>";
          echo $_REQUEST['name']."<br>";
          echo $_REQUEST['email']."<br>";
          echo $_REQUEST['opis']."<br>";*/
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);
          oci_commit($conn);
        }
      }
    ?>
    <br><A HREF='index.php'>Powrót<A><br>
  </BODY>
</HTML>
