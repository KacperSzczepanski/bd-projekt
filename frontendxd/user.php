<HTML>
  <HEAD>
    <TITLE> Podręczniki - wydawnictwo </TITLE>
  </HEAD>
  <BODY>
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
        echo " <BR>Imię: ".$row['NAME'];
        echo " <BR>Opis: ".$row['DESCR'];
        if($row['LOGIN']==$logn) {
          echo " <BR>email: ".$row['EMAIL'];
          echo " <BR>login: ".$row['LOGIN'];
          echo "<BR><A HREF=\"edit.php\">Zmień swoje dane<A>";
        }
      }
    ?>
  </BODY>
</HTML>
