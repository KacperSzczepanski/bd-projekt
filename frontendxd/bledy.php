<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazka </TITLE>
  </HEAD>
  <BODY>
    <?PHP
      $conn = oci_connect("","","//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $stmt = oci_parse($conn, "SELECT id, (SELECT B.name FROM books B WHERE B.id = book) b_name, yr, page, descr FROM mist ORDER BY yr DESC");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['B_NAME']."</H2><BR>\n";
        $ost=0;
        do {
          if($ost!=$row['YR']) {
            echo "<BR><BR><BR> Wydanie ".$row['YR'].":<BR>";
            $ost = $row['YR'];
          }
          echo "<BR> Strona: ".$row['PAGE'];
          echo "<BR> Opis: ".$row['DESCR'];
        } while ($row = oci_fetch_array($stmt, OCI_BOTH));
      }
    ?>
  </BODY>
</HTML>
