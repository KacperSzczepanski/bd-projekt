<HTML>

<HEAD>
    <TITLE> Podręczniki </TITLE>
</HEAD>

<BODY>
    <H2>Dodaj opinię</H2><BR>
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
      $ks = oci_parse($conn, "SELECT name FROM books WHERE id = :id");
      oci_bind_by_name($ks, ":id", $_GET['book']);
      oci_execute($sub, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($ks, OCI_BOTH))
        echo "<H2>".$row['NAME']."</H2><BR>";
        echo "<form action=\"dodajop.php?book=".$_GET['book']."\" method=\"POST\">";
        ?>
          Ogólna ocena: <INPUT type="range" id="val" name="val" min="0" max="10"><br>
          Poziom trudności: <INPUT type="range" id="tru" name="tru" min="0" max="10"><br>
          Opis: <textarea name="opis" rows="10" cols="30"></textarea>
          <input type="submit" value="Dodaj">
        </form>

  </BODY>
</HTML>
