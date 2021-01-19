<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazka </TITLE>
  </HEAD>
  <BODY>
    <?PHP
      session_start();
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $logn = "";
      if(isset($_SESSION['logn'])){
        $logn = $_SESSION['logn'];
      }
      $stmt = oci_parse($conn, "SELECT id b_id, name b_name,
              (SELECT S.name FROM subject S WHERE S.id = B.subj) b_subj,
              (SELECT L.name FROM levels L WHERE L.id = B.lev) b_lev,
              (SELECT T.btype FROM book_types T WHERE T.id = B.type) b_typ,
              (SELECT C.name FROM class_levels C WHERE C.id = B.class) b_class,
              (SELECT P.name FROM publish_house P WHERE P.id = B.pub) b_pub,
              (SELECT CAST(AVG(R.rateval) AS DECIMAL(10,2)) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_rate,
              (SELECT CAST(AVG(R.difficval) AS DECIMAL(10,2)) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_hard
              FROM books B WHERE B.id = :bk");
      oci_bind_by_name($stmt,":bk", $_GET['book']);
      $bledysql = oci_parse($conn, "SELECT COUNT(*) a FROM mist WHERE mist.book= :bk ");
      oci_bind_by_name($bledysql,":bk", $_GET['book']);
      oci_execute($bledysql, OCI_NO_AUTO_COMMIT);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['B_NAME']."</H2><BR>\n";
        echo "<BR><A HREF='index.php'>Start<A>";
        echo " <BR>Przedmiot: ".$row['B_SUBJ'];
        if(isset($row['B_LEV'])) if($row['B_LEV']!="")
          echo " <BR>Poziom: ".$row['B_LEV'];
        echo " <BR>Typ książki: ".$row['B_TYP'];
        echo " <BR>Klasa: ".$row['B_CLASS'];
        echo " <BR>Wydawnictwo: ".$row['B_PUB'];
        echo " <BR>Autorzy: ";
        $stmtau = oci_parse($conn, "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book= :bk");
        oci_bind_by_name($stmtau,":bk", $row['B_ID']);
        oci_execute($stmtau, OCI_NO_AUTO_COMMIT);
        $i = false;
        while ($rowauth = oci_fetch_array($stmtau,OCI_BOTH)) {
          if($i) echo ", ";
          echo $rowauth['NAM'];
          $i = true;
        }
        echo "<BR>Ogólna ocena: ".$row['B_RATE']."/10";
        echo "<BR>Ocena trudności: ".$row['B_HARD']."/10";
        $lbl = oci_fetch_array($bledysql, OCI_BOTH);
        if($lbl['A'] > 0)
          echo "<BR><A HREF=\"bledy.php?book=".$_GET['book']."\">Błędy: ".$lbl['A']."<A>";
        else echo "<BR><A HREF=\"dodajbladform.php?book=".$_GET['book']."\">Dodaj nowy błąd<A><BR><BR>";
        echo $logn;
        echo "<BR>Opinie:<br>";
        if ($logn != "") {
          $checkop = oci_parse($conn, "SELECT id FROM ratetab WHERE book = :bk AND userlog = :ul");
          oci_bind_by_name($checkop, ":bk", $_GET['book']);
          oci_bind_by_name($checkop, ":ul", $logn);
          oci_execute($checkop);
          if($rowp = oci_fetch_array($checkop, OCI_BOTH))
            echo "<BR><A HREF=\"usun_op.php?id=".$rowp['ID']."\">Usuń swoją opinię<A><br>";
          else echo "<BR><A HREF=\"dodajopform.php?book=".$_GET['book']."\">Dodaj opinię<A><BR>";
          echo "<BR><A HREF=\"logout.php\">Wyloguj<A><BR>\n";
        }
        else {
          echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
          echo "<BR><A HREF=\"register.html\">Zarejestruj<A><BR>\n";
        }
        $stmtop = oci_parse($conn, "SELECT R.rateval rat, R.difficval dif, (SELECT U.name FROM users_tab U WHERE
          R.userlog = U.login) us, R.descr des, R.userlog ul FROM ratetab R WHERE R.book= :bid");
        oci_bind_by_name($stmtop, ":bid", $row["B_ID"]);
        oci_execute($stmtop);
        while ($rowrates = oci_fetch_array($stmtop,OCI_BOTH)) {
          echo "<BR>Od: <A HREF=\"user.php?u=".$rowrates['UL']."\">".$rowrates['US']."<A>";
          echo "<BR>Ocena: ".$rowrates['RAT'];
          echo "<BR>Trudność: ".$rowrates['DIF'];
          echo "<BR>Opis: ".$rowrates['DES']."<BR><BR>";
        }
      }
    ?>
  </BODY>
</HTML>
