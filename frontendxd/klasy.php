<HTML>
  <HEAD>
    <TITLE> Podręczniki - klasy </TITLE>
  </HEAD>
  <BODY>
    <H2> klasy: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $sj = "";
      $wyd = "";
      $typ = "";
      $aut="";
      if(isset($_GET["subj"])) {
        $sj = "&subj=".$_GET["subj"];
      }
      if(isset($_GET["publ"])) {
        $wyd = "&publ=".$_GET["publ"];
      }
      if(isset($_GET["type"])) {
        $typ = "&type=".$_GET["type"];
      }
      if(isset($_GET["author"])) {
        $aut = "&author=".$_GET["author"];
      }
      $stmt = oci_parse($conn, "SELECT * FROM class_levels ORDER BY id");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazki.php?class=".$row['ID'].$sj.$wyd.$typ.$aut."\">".$row['NAME']."<A><BR>\n";
      }
    ?>
  </BODY>
</HTML>
