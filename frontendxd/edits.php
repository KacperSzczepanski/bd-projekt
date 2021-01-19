<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> Zmiana danych: </H2>
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

      $haslo = password_hash($_REQUEST['haslo'], PASSWORD_DEFAULT);

          $stmt = oci_parse($conn, "UPDATE users_tab SET pwd= :pwd, name = :nam, email = :em, descr = :des
          WHERE login = :lg");
          oci_bind_by_name($stmt, ":lg", $logn);
          oci_bind_by_name($stmt, ":pwd", $haslo);
          oci_bind_by_name($stmt, ":nam", $_REQUEST['name']);
          oci_bind_by_name($stmt, ":em", $_REQUEST['email']);
          oci_bind_by_name($stmt, ":des", $_REQUEST['opis']);
          /*echo $login."<br>";
          echo $haslo."<br>";
          echo $_REQUEST['name']."<br>";
          echo $_REQUEST['email']."<br>";
          echo $_REQUEST['opis']."<br>";*/
          oci_execute($stmt, OCI_NO_AUTO_COMMIT);
          oci_commit($conn);
    ?>
    <br><A HREF='user.php'>Powrót<A><br>
  </BODY>
</HTML>
