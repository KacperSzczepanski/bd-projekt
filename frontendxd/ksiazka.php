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
              (SELECT AVG(R.val) FROM ratetab R WHERE R.book = B.id AND R.ratetype = 1 GROUP BY B.id) b_rate,
              (SELECT AVG(R.val) FROM ratetab R WHERE R.book = B.id AND R.ratetype = 2 GROUP BY B.id) b_hard
              FROM books B WHERE B.id = ".$_GET['book']);
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
        echo "<H2>".$row['B_NAME']."</H2><BR>\n";
        echo " <BR>Przedmiot: ".$row['B_SUBJ'];
        if(isset($row['B_LEV']) && $row['B_LEV']!="")
          echo " <BR>Poziom: ".$row['B_LEV'];
        echo " <BR>Typ książki: ".$row['B_TYP'];
        echo " <BR>Klasa: ".$row['B_CLASS'];
        echo " <BR>Wydawnictwo: ".$row['B_PUB'];
        echo " <BR>Autorzy: ";
        $stmt2 = oci_parse($conn, "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book=".$row['B_ID']);
        oci_execute($stmt2, OCI_NO_AUTO_COMMIT);
        $i = false
        while ($rowauth = oci_fetch_array($stmt2,OCI_BOTH)) {
          if($i) echo ", ";
          echo $rowauth['NAM'];
          $i = true;
        }
        echo "<BR>Ogólna ocena: ".$row['B_RATE']."/10";
        echo "<BR>Ocena trudności: ".$row['B_HARD']."/10";
        echo "<BR><BR>Opinie:";
        $stmt2 = oci_parse($conn, "SELECT R.val rat, (SELECT U.name FROM users_tab U WHERE
          R.userlog = U.login) us, R.descr des FROM ratetab WHERE R.book=".$row['B_ID']." AND R.ratetype = 1");
        oci_execute($stmt2, OCI_NO_AUTO_COMMIT);
        while ($rowrates = oci_fetch_array($stmt2,OCI_BOTH)) {
          echo "<BR>Od: ".$rowrates['US'];
          echo "<BR>Ocena: ".$rowrates['RAT'];
          echo "<BR>Opis: ".$rowrates['DES'];
        }
      }
      echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
    ?>
  </BODY>
</HTML>
