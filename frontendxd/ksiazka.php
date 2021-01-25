<!DOCTYPE HTML>
  <HEAD>
    <TITLE> Książka </TITLE>

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
      <?PHP 
        if ($row = oci_fetch_array($stmt, OCI_BOTH)) {
          echo "<h2>".$row['B_NAME']."</h2>";
          echo "<h3>Przedmiot: ".$row['B_SUBJ']."</h3>";
          if(isset($row['B_LEV'])) if($row['B_LEV']!="") {
            echo "<h3>Poziom: ".$row['B_LEV']."</h3>";
          }
          echo "<h3>Typ książki: ".$row['B_TYP']."</h3>";
          echo "<h3>Klasa: ".$row['B_CLASS']."</h3>";
          echo "<h3>Wydawnictwo: <a href=\"wyd.php\">".$row['B_PUB']."</a></h3>";
          echo "<h3>Autorzy: ";
          $stmtau = oci_parse($conn, "SELECT A.name nam FROM author A RIGHT JOIN auth_book AB ON AB.id_au = A.id WHERE AB.id_book= :bk");
          oci_bind_by_name($stmtau,":bk", $row['B_ID']);
          oci_execute($stmtau, OCI_NO_AUTO_COMMIT);
          $i = false;
          while ($rowauth = oci_fetch_array($stmtau,OCI_BOTH)) {
            if($i) echo ", ";
            echo $rowauth['NAM'];
            $i = true;
          }
          echo "</h3><br>";
          echo "<h3>Ogólna ocena: ".$row['B_RATE']."/10</h3>";
          echo "<h3>Ocena trudności: ".$row['B_HARD']."/10</h3>";
          $lbl = oci_fetch_array($bledysql, OCI_BOTH);
          if($lbl['A'] > 0) {
            echo "<a href=\"bledy.php?book=".$_GET['book']."\"><h3>Błędy: ".$lbl['A']."</h3></a><br>";
          }
          echo "<form action=\"dodajbladform.php?book=".$_GET['book']."\" method=\"POST\">";
            echo "<button type=\"submit\" class=\"btn btn-primary\">Zgłoś błąd</button>";
          echo "</form>";
          echo "<br><br><h3>Opinie:";
          echo "<div style=\"height: 10px; width: 100%;\"></div>";
          $stmtop = oci_parse($conn, "SELECT R.rateval rat, R.difficval dif, (SELECT U.name FROM users_tab U WHERE
            R.userlog = U.login) us, R.descr des, R.userlog ul FROM ratetab R WHERE R.book= :bid");
          oci_bind_by_name($stmtop, ":bid", $row["B_ID"]);
          oci_execute($stmtop);
          while ($rowrates = oci_fetch_array($stmtop,OCI_BOTH)) {
            echo "<h3>Od: <a href=\"user.php?u=".$rowrates['UL']."\">".$rowrates['US']."</a></h3>";
            echo "<h3>Ocena: ".$rowrates['RAT']."</h3>";
            echo "<h3>Trudność: ".$rowrates['DIF']."</h3>";
            echo "<h3>Opis: ".$rowrates['DES']."</h3><br>";
          }
          if ($logn != "") {
            $checkop = oci_parse($conn, "SELECT id FROM ratetab WHERE book = :bk AND userlog = :ul");
            oci_bind_by_name($checkop, ":bk", $_GET['book']);
            oci_bind_by_name($checkop, ":ul", $logn);
            oci_execute($checkop);
            if($rowp = oci_fetch_array($checkop, OCI_BOTH)) {
              echo "<form style=\"position: absolute; bottom: 15px; left: 15px;\" action=\"usun_op.php?id=".$rowp['ID']."\" method=\"POST\">";
                echo "<button type=\"submit\" class=\"btn btn-primary\">Usuń swoją opinię</button>";
              echo "</form><br>";
            } else {
              echo "<form style=\"position: absolute; bottom: 15px; left: 15px;\" action=\"dodajopform.php?book=".$_GET['book']."\" method=\"POST\">";
                echo "<button type=\"submit\" class=\"btn btn-primary\">Dodaj swoją opinię</button>";
              echo "</form><br>";
            }
          }
          echo "</h3><br>";
        }
      ?>

      <form action="index.php" method="POST" class="moveButtonToRight">
        <button type="submit" class="btn btn-primary">Powrót</button>
      </form>
    </div>

    <div style="width: 100%; height: 25px"></div>
  </BODY>
</HTML>
