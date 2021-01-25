<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Wybrane książki </TITLE>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
      body {
        background-repeat: no-repeat;
        background-size: cover;
      }

      .bodyIndex {
          background-image: url("obrazy/index-tlo.jpg");
      }

      .bodyForms {
          background-image: url("obrazy/formy-tlo.jpg");
      }

      .bodyRegister {
          background-image: url("obrazy/rejestracja-tlo.jpg");
      }

      .bodyLogin {
          background-image: url("obrazy/logowanie-tlo.jpg");
      }

      .menuAuto {
          background-color: rgba(50, 50, 50, 0.8);
          border-radius: 10px;
          display: block;
          color: white;
          width: auto;
          margin: auto;
          padding: 15px;
          position: relative;
      }

      .menu40 {
          background-color: rgba(50, 50, 50, 0.8);
          border-radius: 10px;
          display: block;
          color: white;
          width: 40%;
          margin: auto;
          padding: 15px;
          position: relative;
      }

      a {
          display: inline-block;
      }

      a:link {
          color: white;
          background-color: transparent;
          text-decoration: none;
      }

      a:visited {
          color: white;
          background-color: transparent;
          text-decoration: none;
      }

      a:hover {
          color: blue;
          background-color: transparent;
          text-decoration: none;
      }

      a:active {
          color: darkblue;
          background-color: transparent;
          text-decoration: none;
      }

      .moveButtonToRight {
          padding: 0px;
          margin: 0px;
          position: absolute;
          right: 15px;
          bottom: 15px;
      }
    </style>
  </HEAD>
  <BODY class="bodyIndex">
    <?PHP
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
    ?>

    <nav class="navbar bg-dark navbar-dark">
      <?PHP
        if ($logn != "") {
          echo "<span class=\"navbar-brand\">Zalogowano jako ".$logn."</span>";
        } else {
          echo "<span class=\"navbar-brand\">Nikt nie jest teraz zalogowany</span>";
        }
      ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <?PHP 
            if ($logn != "") {
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"dodajksiazkeform.php\">Dodaj książkę</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"user.php\">Moje konto</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"logout.php\">Wyloguj</a>";
              echo "</li>";
            } else {
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"login.html\">Zaloguj</a>";
              echo "</li>";
              echo "<li class=\"nav-tiem\">";
                echo "<a class=\"nav-link\" href=\"register.html\">Zarejestruj</a>";
              echo "</li>";
            }
          ?>
        </ul>
      </div>
    </nav>

    <div style="width: 100%; height: 69px"></div>

    <div class="container menuAuto">
      <h2>Znalezione książki:</h2>
      <?PHP 
        while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
          echo "<a href=\"ksiazka.php?book=".$row['B_ID']."\"><h3>".$row['B_NAME']."</h3></a><br>\n";
          $authzap = "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book=".$row['B_ID'];
          $stmtau = oci_parse($conn, $authzap);
          oci_execute($stmtau, OCI_NO_AUTO_COMMIT);
          $i = false;
          echo "<h4>Autorzy: ";
          while ($rowauth = oci_fetch_array($stmtau,OCI_BOTH)) {
            if ($i) echo ", ";
            echo $rowauth['NAM'];
            $i = true;
          }
          echo "</h4>";
          echo "<h4>Przedmiot: ".$row['B_SUBJ']."</h4>";
          echo "<h4>Poziom: ".$row['B_LEV']."</h4>";
          echo "<h4>Rodzaj książki: ".$row['B_TYP']."</h4>";
          echo "<h4>Klasa: ".$row['B_CLASS']."</h4>";
          echo "<h4>Wydawnictwo: <a href=\"wyd.php\">".$row['B_PUB']."</a></h4>";
          echo "<h4>Ocena: ".$row['B_RATE']."/10</h4>";
          echo "<br>";
        }
        echo "<form action=\"index.php?".$sj.$wyd.$typ.$aut.$cl."\" method=\"POST\">";
          echo "<button type=\"submit\" class=\"btn btn-primary\">Dodaj filtr</button>";
        echo "</form>";
      ?>

      <form action="index.php" method="POST" class="moveButtonToRight">
        <button type="submit" class="btn btn-primary">Powrót</button>
      </form>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
