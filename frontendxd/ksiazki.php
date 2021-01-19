<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazki </TITLE>
  </HEAD>
  <BODY>
    <H2> ksiazka: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      $conn = oci_connect("","","//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
      	echo "oci_connect failed\n";
      	$e = oci_error();
      	echo $e['message'];
      }

      $zap = "SELECT id b_id, name b_name,
              (SELECT S.name FROM subject S WHERE S.id = B.subj) b_subj,
              (SELECT L.name FROM levels L WHERE L.id = B.lev) b_lev,
              (SELECT T.btype FROM book_types T WHERE T.id = B.type) b_typ,
              (SELECT C.name FROM class_levels C WHERE C.id = B.class) b_class,
              (SELECT P.name FROM publish_house P WHERE P.id = B.pub) b_pub,
              (SELECT AVG(R.rateval) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_rate FROM books B";
      $sj = "";
      $wyd = "";
      $typ = "";
      $aut="";
      $cl="";
      $any = true;
      if(isset($_GET["subj"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        $sj = "&subj=".$_GET["subj"];
        $zap .= "B.subj=".$_GET["subj"];
      }
      if(isset($_GET["publ"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $wyd = "&publ=".$_GET["publ"];
        $zap .= "B.pub=".$_GET["publ"];
      }
      if(isset($_GET["type"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $zap .= "B.type=".$_GET["type"];
        $typ = "&type=".$_GET["type"];
      }
      if(isset($_GET["author"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $aut = "&author=".$_GET["author"];
        $zap .= "B.id IN (SELECT id_book FROM auth_book WHERE id_au=".$_GET["author"].")";
      }
      if(isset($_GET["class"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $cl = "&class=".$_GET["class"];
        $zap .= "B.class=".$_GET["class"];
      }
      $stmt = oci_parse($conn, $zap);
      if(isset($_GET["debug"]))
        echo $zap;
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        echo "<BR><A HREF=\"ksiazka.php?book=".$row['B_ID']."\">".$row['B_NAME']."<A><BR>\n";
        $authzap = "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book=".$row['B_ID'];
        $stmtau = oci_parse($conn, $authzap);
        oci_execute($stmtau, OCI_NO_AUTO_COMMIT);
        while ($rowauth = oci_fetch_array($stmtau,OCI_BOTH)) {
          echo $rowauth['NAM'].", ";
        }
        echo $row['B_SUBJ'].", ";
        echo $row['B_LEV'].", ";
        echo $row['B_TYP'].", ";
        echo $row['B_CLASS'].", ";
        echo $row['B_PUB'].", ";
        echo $row['B_RATE']."/10";
        echo "<BR>";
      }
      echo "<BR><A HREF=\"index.php?".$sj.$wyd.$typ.$aut.$cl."\">Dodaj filtr<A><BR>\n";
      echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>\n";
    ?>
  </BODY>
</HTML>
