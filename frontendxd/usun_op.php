<HTML>
  <HEAD>
    <TITLE> Usuwanie opinii </TITLE>
  </HEAD>
  <BODY>
    <H2> usuwanie opinii: </H2>
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

      $id = $_GET['id'];

      $book = oci_parse($conn, "SELECT book FROM ratetab WHERE id = :id AND userlog = :login");
      oci_bind_by_name($book, ":id", $id);
      oci_bind_by_name($book, ":login", $logn);
      oci_execute($book);
      $insert = oci_parse($conn, "DELETE ratetab WHERE id = :id AND userlog = :login");
      oci_bind_by_name($insert, ":id", $id);
      oci_bind_by_name($insert, ":login", $logn);
      oci_execute($insert);
      print_r(oci_error($insert));
    if($row = oci_fetch_array($book, OCI_BOTH))
      echo "<br><A HREF='ksiazka.php?book=".$row['BOOK']."'>Powrót<A><br>";
    ?>
  </BODY>
</HTML>
