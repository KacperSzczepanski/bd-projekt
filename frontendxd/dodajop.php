<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> dodawanie opinii: </H2>
    <?PHP
      session_start();
      $logn = "";
      if(isset($_SESSION['logn']))
        $logn = $_SESSION['logn'];
        include('config.php');
        $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }

      $bk = $_GET['book'];
      $og = $_REQUEST['val'];
      $hds = $_REQUEST['tru'];
      $op = $_REQUEST['opis'];

      $insert = oci_parse($conn, "INSERT INTO ratetab (rateval, difficval, book, userlog, descr)
                 VALUES (:vl, :df, :bk, :us, :dsr)");
      oci_bind_by_name($insert, ":vl", $og);
      oci_bind_by_name($insert, ":df", $hds);
      oci_bind_by_name($insert, ":bk", $bk);
      oci_bind_by_name($insert, ":us", $logn);
      oci_bind_by_name($insert, ":dsr", $op);
      oci_execute($insert, OCI_NO_AUTO_COMMIT);
      print_r(oci_error($insert));
      oci_commit($conn);
    echo "<br><A HREF='ksiazka.php?book=".$bk."'>Powrót<A><br>";
    ?>
  </BODY>
</HTML>
