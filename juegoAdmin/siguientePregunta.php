<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>siguiente pregutna</title>
    <meta http-equiv="refresh" content="5;URL=preguntaAdmin.php" >
    <link rel="stylesheet" href="./CSS/styleSiguientePreg.css">
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
      if ($_SESSION['countPregunta']>=$_SESSION['totalPreguntas']) {
        header("Location: ./finJuegoAdmin.php");
      }
    ?>

    <div class="cuentaAtras">
      <p class="text">siguiente pregunta en:</p>
      <p class="num"> <span class="numeros"></span> </p>
    </div>


  </body>
</html>
