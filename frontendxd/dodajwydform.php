<HTML>

<HEAD>
    <TITLE> Dodaj wydawnictwo </TITLE>
</HEAD>

<BODY>
    <?PHP
      session_start();
      $logn = "";
      if(isset($_SESSION['logn']))
        $logn = $_SESSION['logn'];
      echo "Uzytkownik: ".$logn."<br>";
      ?>
      <form action="dodajwyd.php" method="POST">
        Nazwa: <INPUT type="text" name="nazwa"><br>
        Adres: <INPUT type="text" name="address"><br>
        email: <input type="email" name="email"><br>
        Telefon: <input type="number" name="telefon"><br>
        <input type="submit" value="Dodaj">
      </form>
  </BODY>
</HTML>
