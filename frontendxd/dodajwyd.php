<HTML>
  <HEAD>
    <TITLE> Wydawnictwo </TITLE>
  </HEAD>
  <BODY>
    <H2> Dodaj wydawnictwo: </H2>
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

      $NazwaWyd = $_REQUEST['nazwa'];
      $Adres = $_REQUEST['address'];
      $mail = $_REQUEST['email'];
      $numer = $_REQUEST['telefon'];

      $insert = oci_parse($conn, "INSERT INTO publish_house (name, address, email, phone, added_by)
                 VALUES ( :name, :addr, :em, :ph, :ad )");
      oci_bind_by_name($insert, ":name", $NazwaWyd);
      oci_bind_by_name($insert, ":addr", $Adres);
      oci_bind_by_name($insert, ":em", $mail);
      oci_bind_by_name($insert, ":ph", $numer);
      oci_bind_by_name($insert, ":ad", $logn);
      /*echo $NazwaWyd;
      echo $Adres;
      echo $mail;
      echo $numer;
      echo $logn;*/
      oci_execute($insert);
      print_r( oci_error($insert));
    ?>
    Dodano.
    <A HREF='wydawnictwa.php'>Powrót<A><br>
  </BODY>
</HTML>
