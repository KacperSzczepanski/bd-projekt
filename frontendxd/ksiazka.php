<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazka </TITLE>
  </HEAD>
  <BODY>
    <?PHP
      $conn = oci_connect("","","//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }
      $stmt = oci_parse($conn, "SELECT id b_id, name b_name,
              (SELECT S.name FROM subject S WHERE S.id = B.subj) b_subj,
              (SELECT L.name FROM levels L WHERE L.id = B.lev) b_lev,
              (SELECT T.btype FROM book_types T WHERE T.id = B.type) b_typ,
              (SELECT C.name FROM class_levels C WHERE C.id = B.class) b_class,
              (SELECT P.name FROM publish_house P WHERE P.id = B.pub) b_pub,
              (SELECT AVG(R.rateval) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_rate,
              (SELECT AVG(R.difficval) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_hard
              FROM books B WHERE B.id = ".$_GET['book']);
      $bledysql = oci_parse($conn, "SELECT COUNT(*) a FROM mist WHERE mist.book=".$_GET['book']);
      oci_execute($bledysql, OCI_NO_AUTO_COMMIT);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['B_NAME']."</H2><BR>\n";
        echo " <BR>Przedmiot: ".$row['B_SUBJ'];
        if(isset($row['B_LEV'])) if($row['B_LEV']!="")
          echo " <BR>Poziom: ".$row['B_LEV'];
        echo " <BR>Typ książki: ".$row['B_TYP'];
        echo " <BR>Klasa: ".$row['B_CLASS'];
        echo " <BR>Wydawnictwo: ".$row['B_PUB'];
        echo " <BR>Autorzy: ";
        $stmtau = oci_parse($conn, "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book=".$row['B_ID']);
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
        echo "<BR><BR>Opinie:";
        $stmtop = oci_parse($conn, "SELECT R.rateval rat, R.difficval dif, (SELECT U.name FROM users_tab U WHERE
          R.userlog = U.login) us, R.descr des FROM ratetab R WHERE R.book=".$row['B_ID']);
        oci_execute($stmtop, OCI_NO_AUTO_COMMIT);
        while ($rowrates = oci_fetch_array($stmtop,OCI_BOTH)) {
          echo "<BR>Od: ".$rowrates['US'];
          echo "<BR>Ocena: ".$rowrates['RAT'];
          echo "<BR>Trudność: ".$rowrates['DIF'];
          echo "<BR>Opis: ".$rowrates['DES']."<BR><BR>";
        }
      }

      echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
    ?>
  </BODY>
</HTML>
