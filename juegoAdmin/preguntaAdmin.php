<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pregunta Admin</title>
  </head>
  <body>
    <?php
      try {
         $hostname = "localhost";
         $dbname = "kahoot";
         $username = "admin_kahoot";
         $pw = "P@ssw0rd";
         $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
       } catch (PDOException $e) {
         echo "Failed to get DB handle: " . $e->getMessage() . "\n";
         exit;
       }
         session_start();
    ?>
    <?php

      $queryGamer = $pdo -> prepare(" update kahoot set start_game=1 where pin='".$_SESSION['pin']."'; ");
      $queryGamer -> execute();

    ?>






    primera pregunta
  </body>
</html>
