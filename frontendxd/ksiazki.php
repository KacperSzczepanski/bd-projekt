<HTML>
  <HEAD>
    <TITLE> Podręczniki - ksiazki </TITLE>
  </HEAD>
  <BODY>
    <H2> ksiazka: </H2>
    <?PHP
      echo "<BR><A HREF=\"index.php\">Wyczyść<A><BR>\n";
      include('config.php');
      $conn = oci_connect($dblogin,$dbpassword,"//labora.mimuw.edu.pl/LABS");
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
              (SELECT CAST(AVG(R.rateval) AS DECIMAL(10,2)) FROM ratetab R WHERE R.book = B.id GROUP BY B.id) b_rate FROM books B";
      $sj = "";
      $wyd = "";
      $typ = "";
      $aut="";
      $cl="";
      $bsj = false;
      $bwyd = false;
      $btyp = false;
      $baut=false;
      $bcl=false;
      $any = true;
      if(isset($_GET["subj"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        $sj = "&subj=".$_GET["subj"];
        $zap .= "B.subj= :sj";
        $bsj=true;
      }
      if(isset($_GET["publ"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $wyd = "&publ=".$_GET["publ"];
        $zap .= "B.pub= :wyd";
        $bwyd=true;
      }
      if(isset($_GET["type"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $zap .= "B.type= :typ";
        $typ = "&type=".$_GET["type"];
        $btyp=true;
      }
      if(isset($_GET["author"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $aut = "&author=".$_GET["author"];
        $zap .= "B.id IN (SELECT id_book FROM auth_book WHERE id_au= :aut)";
        $baut=true;
      }
      if(isset($_GET["class"])) {
        if($any) {
          $any = false;
          $zap .= " WHERE ";
        }
        else $zap .= " AND ";
        $cl = "&class=".$_GET["class"];
        $zap .= "B.class= :cl";
        $bcl=true;
      }
      $stmt = oci_parse($conn, $zap);
      if($bsj)
        oci_bind_by_name($stmt, ":sj", $_GET['subj']);
      if($bwyd)
        oci_bind_by_name($stmt, ":wyd", $_GET['publ']);
      if($btyp)
        oci_bind_by_name($stmt, ":typ", $_GET['type']);
      if($baut)
        oci_bind_by_name($stmt, ":aut", $_GET['author']);
      if($bcl)
        oci_bind_by_name($stmt, ":cl", $_GET['class']);

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
    ?>
  </BODY>
</HTML>
