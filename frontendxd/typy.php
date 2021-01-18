<HTML>
  <HEAD>
    <TITLE> Podręczniki - typ książki </TITLE>
  </HEAD>
  <BODY>
    <H2> Przedmiot: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      $conn = oci_connect("","","//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $sj = "";
      $wyd = "";
      $cl = "";
      $aut="";
      if(isset($_GET["subj"])) {
        $sj = "&subj=".$_GET["subj"];
      }
      if(isset($_GET["publ"])) {
        $wyd = "&publ=".$_GET["publ"];
      }
      if(isset($_GET["class"])) {
        $cl = "&class=".$_GET["class"];
      }
      if(isset($_GET["author"])) {
        $aut = "&author=".$_GET["author"];
      }
      $stmt = oci_parse($conn, "SELECT * FROM book_types");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazki.php?type=".$row['ID'].$sj.$wyd.$cl.$aut."\">".$row['BTYPE']."<A><BR>\n";
      }
      echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
    ?>
  </BODY>
</HTML>
