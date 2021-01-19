<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazka </TITLE>
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
      $stmt = oci_parse($conn, "SELECT id, (SELECT B.name FROM books B WHERE B.id = book) b_name, yr, page, descr FROM mist WHERE book = :bk ORDER BY yr DESC");
      oci_bind_by_name($stmt, ":bk", $_GET['book']);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['B_NAME']." - błędy</H2><BR>\n";
        echo "<BR><A HREF=\"ksiazka.php?book=".$_GET['book']."\">Powrót<A><BR><BR>";
        echo "<BR><A HREF=\"dodajbladform.php?book=".$_GET['book']."\">Dodaj nowy błąd<A><BR><BR>";
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
