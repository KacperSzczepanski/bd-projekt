<HTML>
  <HEAD>
    <TITLE> Podręczniki - przedmioty </TITLE>
  </HEAD>
  <BODY>
    <H2> Autorzy: </H2>
    <?PHP
      include ("config.php");
      echo $dblogin;
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $sj = "";
      $wyd = "";
      $typ = "";
      $cl="";
      if(isset($_GET["subj"])) {
        $sj = "&subj=".$_GET["subj"];
      }
      if(isset($_GET["publ"])) {
        $wyd = "&publ=".$_GET["publ"];
      }
      if(isset($_GET["type"])) {
        $typ = "&type=".$_GET["type"];
      }
      if(isset($_GET["class"])) {
        $cl = "&class=".$_GET["class"];
      }
      $stmt = oci_parse($conn, "SELECT * FROM author");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazki.php?author=".$row['ID'].$sj.$wyd.$typ.$cl."\">".$row['NAME']."<A><BR>\n";
      }
    ?>
  </BODY>
</HTML>
