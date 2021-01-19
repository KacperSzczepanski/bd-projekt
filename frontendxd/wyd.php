<HTML>
  <HEAD>
    <TITLE> Podręczniki - wydawnictwo </TITLE>
  </HEAD>
  <BODY>
    <?PHP
    include('config.php');
    $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $stmt = oci_parse($conn, "SELECT * FROM publish_house WHERE id = :id");
      oci_bind_by_name($stmt, ":id", $_GET['publ']);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['NAME']."</H2><BR>\n";
        echo " <BR>Adres: ".$row['ADDRESS'];
        echo " <BR>email: ".$row['EMAIL'];
        echo " <BR>Telefon: ".$row['PHONE'];
      }
    ?>
  </BODY>
</HTML>
