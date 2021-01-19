<HTML>

<HEAD>
    <TITLE> Podręczniki </TITLE>
</HEAD>

<BODY>
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
      echo "Uzytkownik: ".$logn."<BR>";
      $sub = oci_parse($conn, "SELECT * FROM subject");
      oci_execute($sub, OCI_NO_AUTO_COMMIT);
      $pub = oci_parse($conn, "SELECT * FROM publish_house");
      oci_execute($pub, OCI_NO_AUTO_COMMIT);
      $typ = oci_parse($conn, "SELECT * FROM book_types");
      oci_execute($typ, OCI_NO_AUTO_COMMIT);
      $cla = oci_parse($conn, "SELECT * FROM class_levels ORDER BY id");
      oci_execute($cla, OCI_NO_AUTO_COMMIT);
      $zak = oci_parse($conn, "SELECT * FROM levels ORDER BY id");
      oci_execute($zak, OCI_NO_AUTO_COMMIT);
        echo "<form action=\"dodajksiazke.php\" method=\"POST\">";
        echo "Nazwa książki: <INPUT type=\"text\" name=\"nazwa\" placeholder=\"Algebra z *\"><br>";
        echo "Autor 1: <INPUT type=\"test\" name=\"autora\"><br>";
        echo "Autor 2: <INPUT type=\"test\" name=\"autorb\"><br>";
        echo "Autor 3: <INPUT type=\"test\" name=\"autorc\"><br>";
        echo "Autor 4: <INPUT type=\"test\" name=\"autord\"><br>";
        echo "Autor 5: <INPUT type=\"test\" name=\"autore\"><br>";
        echo "Autor 6: <INPUT type=\"test\" name=\"autorf\"><br>";
        echo "Autor 7: <INPUT type=\"test\" name=\"autorg\"><br>";
        echo "Wydawnictwo: <select name=\"wydawnictwo\">";
        while ($row = oci_fetch_array($pub, OCI_BOTH)) {
          echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
        }
        echo "</select><BR>";
        echo "Przedmiot: <select name=\"przedmiot\">";
        while ($row = oci_fetch_array($sub, OCI_BOTH)) {
          echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
        }
        echo "</select><BR>";
        echo "Rodzaj książki: <select name=\"rodzajksiazki\">";
        while ($row = oci_fetch_array($typ, OCI_BOTH)) {
          echo "<option value=\"".$row['ID']."\">".$row['BTYPE']."</option>";
        }
        echo "</select><BR>";
        echo "Klasa: <select name=\"klasa\">";
        while ($row = oci_fetch_array($cla, OCI_BOTH)) {
          echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
        }
        echo "</select><BR>";
        echo "Zakres: <select name=\"zakres\">";
        echo "<option value=\"-1\"></option>";
        while ($row = oci_fetch_array($zak, OCI_BOTH)) {
          echo "<option value=\"".$row['ID']."\">".$row['NAME']."</option>";
        }
        echo "</select><BR>";
        echo "<input type=\"submit\" value=\"Dodaj\">";
      echo "</form>"
      ?>

  </BODY>
</HTML>
