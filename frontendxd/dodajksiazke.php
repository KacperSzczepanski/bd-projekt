<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> dodano: </H2>
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

      $NazwaKsiazki = $_REQUEST['nazwa'];
      $Autorzy = array (
        $_REQUEST['autora'],
       $_REQUEST['autorb'],
       $_REQUEST['autorc'],
       $_REQUEST['autord'],
       $_REQUEST['autore'],
       $_REQUEST['autorf'],
      $_REQUEST['autorg'] );
      $Wydawnictwo = $_REQUEST['wydawnictwo'];
      $Przedmiot = $_REQUEST['przedmiot'];
      $RodzajKsiazki = $_REQUEST['rodzajksiazki'];
      $Klasa = $_REQUEST['klasa'];
      $Zakres = $_REQUEST['zakres'];

      $insert = oci_parse($conn, "INSERT INTO books (name, subj, lev, type, class, pub, added_by)
                 VALUES (:name, :subj, :lev, :type, :class, :pub, :ad)");
      oci_bind_by_name($insert, ":name", $NazwaKsiazki);
      oci_bind_by_name($insert, ":subj", $Przedmiot);
      oci_bind_by_name($insert, ":lev", $Zakres);
      oci_bind_by_name($insert, ":type", $RodzajKsiazki);
      oci_bind_by_name($insert, ":class", $Klasa);
      oci_bind_by_name($insert, ":pub", $Wydawnictwo);
      oci_bind_by_name($insert, ":ad", $logn);
      oci_execute($insert, OCI_NO_AUTO_COMMIT);
      //print_r( $Autorzy);
      foreach( $Autorzy as $autor ) {
        if($autor=="") continue;
        //echo $autor;

        $aut = oci_parse($conn, "SELECT id FROM author WHERE name = :name");
        oci_bind_by_name($aut, ":name", $autor);
        oci_execute($aut, OCI_NO_AUTO_COMMIT);
        if($row = oci_fetch_array($aut, OCI_BOTH)) {
          $insautbk = oci_parse($conn, "INSERT INTO auth_book VALUES (:id, seq_books.CURRVAL)");
          oci_bind_by_name($insautbk, ":id", $row['ID']);
          oci_execute($insautbk, OCI_NO_AUTO_COMMIT);
        }
        else {
          $insauth = oci_parse($conn, "INSERT INTO author (name) VALUES (:aut)");
          oci_bind_by_name($insauth, ":aut", $autor);
          oci_execute($insauth, OCI_NO_AUTO_COMMIT);
          $insautbk = oci_parse($conn, "INSERT INTO auth_book VALUES (seq_auth.CURRVAL, seq_books.CURRVAL)");
          oci_execute($insautbk, OCI_NO_AUTO_COMMIT);
        }
      }
      oci_commit($conn);
    ?>
    <A HREF="index.php">Powrót<A><BR>
  </BODY>
</HTML>
