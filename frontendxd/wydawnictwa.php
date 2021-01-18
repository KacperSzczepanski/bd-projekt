<HTML>
  <HEAD>
    <TITLE> Podręczniki - wydawnictwa </TITLE>
  </HEAD>
  <BODY>
    <H2> wydawnictwa: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      $conn = oci_connect("","","//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $cl = "";
      $sj = "";
      $typ = "";
      $aut="";
      if(isset($_GET["class"])) {
        $cl = "&class=".$_GET["class"];
      }
      if(isset($_GET["subj"])) {
        $sj = "&subj=".$_GET["subj"];
      }
      if(isset($_GET["type"])) {
        $typ = "&type=".$_GET["type"];
      }
      if(isset($_GET["author"])) {
        $aut = "&author=".$_GET["author"];
      }
      $stmt = oci_parse($conn, "SELECT id,name FROM publish_house");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazki.php?publ=".$row['ID'].$cl.$sj.$typ.$aut."\">".$row['NAME']."<A><BR>\n";
      }
      echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
    ?>
  </BODY>
</HTML>
