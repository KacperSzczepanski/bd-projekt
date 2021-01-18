<HTML>
  <HEAD>
    <TITLE> Podręczniki </TITLE>
  </HEAD>
  <BODY>
    <H2> Wybierz: </H2>
    <BR><A HREF=\"index.php\">Wyczyść<A><BR>
    <?PHP
    $sj = "";
    $wyd = "";
    $typ = "";
    $aut="";
    $cl="";
    if(isset($_GET["subj"])) {
      $sj = "&subj=".$_GET["subj"];
    }
    if(isset($_GET["publ"])) {
      $wyd = "&publ=".$_GET["publ"];
    }
    if(isset($_GET["type"])) {
      $typ = "&type=".$_GET["type"];
    }
    if(isset($_GET["author"])) {
      $aut = "&author=".$_GET["author"];
    }
    if(isset($_GET["class"])) {
      $cl = "&class=".$_GET["class"];
    }
    echo "<BR><A HREF=\"login.html\">Zaloguj<A><BR>";
    echo "<BR><A HREF=\"przedmioty.php?".$sj.$wyd.$typ.$aut.$cl."\">Przedmiot<A><BR>";
    echo "<BR><A HREF=\"klasy.php?".$sj.$wyd.$typ.$aut.$cl."\">klasa<A><BR>";
    echo "<BR><A HREF=\"wydawnictwa.php?".$sj.$wyd.$typ.$aut.$cl."\">Wydawnictwo<A><BR>";
    echo "<BR><A HREF=\"autorzy.php?".$sj.$wyd.$typ.$aut.$cl."\">Autorzy<A><BR>";
    echo "<BR><A HREF=\"typy.php?".$sj.$wyd.$typ.$aut.$cl."\">Typ książki<A><BR>";
    ?>
  </BODY>
</HTML>
