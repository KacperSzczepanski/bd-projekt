<HTML>
  <HEAD>
    <TITLE> Podręczniki - wydawnictwa </TITLE>
  </HEAD>
  <BODY>
    <H2> wydawnictwa: </H2>
    <?PHP
      session_start();
      $logn = "";
      if(isset($_SESSION['logn']))
        $logn = $_SESSION['logn'];
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
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
        echo "<BR><A HREF=\"ksiazki.php?publ=".$row['ID'].$cl.$sj.$typ.$aut."\">".$row['NAME']." - ksiazki <A>\n";
        echo ", <A HREF=\"wyd.php?publ=".$row['ID']."\">Szczegoly<A><BR>";
      }
      if ($logn != "") {
        echo "<BR><A HREF=\"dodajwydform.php\">Dodaj nowe wydawnictwo<A><BR>";
        echo "<BR><A HREF=\"logout.php\">Wyloguj<A><BR>\n";
      }
      else {
        echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
        echo "<BR><A HREF=\"register.html\">Zarejestruj<A><BR>\n";
      }
    ?>
  </BODY>
</HTML>
