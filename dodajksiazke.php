<HTML>
  <HEAD>
    <TITLE> Dodawanie książki </TITLE>
  </HEAD>
  <BODY>
    <H2> wydawnictwa: </H2>
    <?PHP
      $conn = oci_connect("", "");
      if (!$conn) {
        echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
    
      $NazwaKsiazki = $_REQUEST['nazwa'];
      $Autorzy = $_REQUEST['autorzy'];
      $Wydawnictwo = $_REQUEST['wydawnictwo'];
      $Przedmiot = $_REQUEST['przedmiot'];
      $RodzajKsiazki = $_REQUEST['rodzajksiazki'];
      $RokNauczania = $_REQUEST['roknauczania'];
      $Ocena = $_REQUEST['ocena'];
      $RokWydania = $_REQUEST['rokwydania'];
      $PoziomTrudnosci = $_REQUEST['poziomtrudnosci'];
      $Cena = $REQUEST['cena'];
      
      //sprawdzamy poprawność
      
      { //sprawdzanie przedmiotu
        $query = oci_parse($conn, "SELECT id FROM publish_house WHERE name = $Przedmiot");
        oci_execute($query, OCI_NO_AUTO_COMMIT);
        //sprawdzamy poprawność
        $result = $conn->($query);
        
        if ($result->num_rows = 0) {
            
        }
      }
      
      { //sprawdzanie poziomu trudności
        $query = oci_parse($conn, "SELECT id FROM levels WHERE name = $PoziomTrudnosci");
        oci_execute($query, OCI_NO_AUTO_COMMIT);
        //sprawdzamy poprawność
        $result = $conn->($query);
        
        if ($result->num_rows = 0) {
            
        }
      }
      
      { //sprawdzanie rodzaju książki
        $query = oci_parse($conn, "SELECT id FROM book_type WHERE btype = $RodzajKsiazki");
        oci_execute($query, OCI_NO_AUTO_COMMIT);
        //sprawdzamy poprawność
        $result = $conn->($query);
        
        if ($result->num_rows = 0) {
            
        }
      }
      
      { //sprawdzanie roku nauczania
        $query = oci_parse($conn, "SELECT id FROM class_level WHERE name = $RokNauczania");
        oci_execute($query, OCI_NO_AUTO_COMMIT);
        //sprawdzamy poprawność
        $result = $conn->($query);
        
        if ($result->num_rows = 0) {
            
        }
      }
      
      { //sprawdzanie wydawnictwa
        $query = oci_parse($conn, "SELECT id FROM publish_house WHERE name = $Wydawnictwo");
        oci_execute($query, OCI_NO_AUTO_COMMIT);
        //sprawdzamy poprawność
        $result = $conn->($query);
        
        if ($result->num_rows = 0) {
            
        }
      }
      
      { //dodawanie książki
        $id = seq_books.nextval;
        $name = $NazwaKsiazki;
        $subj = oci_parse($conn, "SELECT id FROM subject WHERE name = $Przedmiot");
        oci_execute($subj, OCI_NO_AUTO_COMMIT);
        $lev = oci_parse($conn, "SELECT id FROM levels WHERE name = $PoziomTrudnosci");
        oci_execute($lev, OCI_NO_AUTO_COMMIT);
        $type = oci_prase($conn, "SELECT id FROM book_types WHERE btype = $RodzajKsiazki");
        oci_execute($type, OCI_NO_AUTO_COMMIT);
        $class = oci_parse($conn, "SELECT id FROM class_levels WHERE name = $RokNauczania");
        oci_execute($class, OCI_NO_AUTO_COMMIT);
        $pub = oci_parse($conn, "SELECT id FROM publish_house WHERE name = $Wydawnictwo");
        oci_execute($pub, OCI_NO_AUTO_COMMIT);
      }
      
      $insert = oci_parse($conn, "INSERT INTO books (id, name, subj, lev, type, class, pub)
                 VALUES ($id, $name, $subj, $lev, $type, $class, $pub)");
      oci_execute($insert, OCI_NO_AUTO_COMMIT);
    ?>
  </BODY>
</HTML>
