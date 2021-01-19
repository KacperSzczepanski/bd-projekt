<HTML>
  <HEAD>
    <TITLE> Podręczniki - przedmioty </TITLE>
  </HEAD>
  <BODY>
    <H2> Przedmiot: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $cl = "";
      $wyd = "";
      $typ = "";
      $aut="";
      if(isset($_GET["class"])) {
        $cl = "&class=".$_GET["class"];
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
      $stmt = oci_parse($conn, "SELECT * FROM subject");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazki.php?subj=".$row['ID'].$cl.$wyd.$typ.$aut."\">".$row['NAME']."<A><BR>\n";
      }
    ?>
  </BODY>
</HTML>
