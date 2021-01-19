<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> rejestracja: </H2>
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
      echo "<H2>Edytuj</H2><br>";
      echo "<form action=\"edits.php\" method=\"POST\">";
        echo "Nowe hasło: <input type=\"password\" name=\"haslo\"><br>";
        echo "Imię: <input type=\"text\" name=\"name\" value=\"".$row['NAME']."\"><br>";
        echo "email: <input type=\"email\" name=\"email\" value=\"".$row['EMAIL']."\"><br>";
        echo "<textarea name=\"opis\" rows=\"10\" cols=\"30\">".$row['DESCR']."</textarea>";
        ?>
        <input type="submit" value="Dodaj">
      </form>
  </BODY>
</HTML>
