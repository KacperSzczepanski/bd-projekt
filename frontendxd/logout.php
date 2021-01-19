<HTML>

<HEAD>
    <TITLE> Podręczniki </TITLE>
</HEAD>

<BODY>
      <?PHP
      session_start();
      session_unset();
      session_destroy();
      ?>
    Wylogowano.
    <br><A HREF='index.php'>Powrót<A><br>
  </BODY>
</HTML>
