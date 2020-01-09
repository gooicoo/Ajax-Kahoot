<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>siguientes respuestas</title>
    <meta http-equiv="refresh" content="5;URL=juegoGamer.php" >
    <link rel="stylesheet" href="../juegoAdmin/CSS/styleSiguientePreg.css">
  </head>
  <body>
    <div class="cuentaAtras">
      <p class="num"> <span class="numeros"></span> </p>
    </div>

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
      
        $queryPregunta = $pdo -> prepare("select * from question where kahoot_id='".$_SESSION['kahoot_id']."' ORDER BY orden DESC;");
        $queryPregunta -> execute();
        
      	$rowPregunta = $queryPregunta -> fetch();

        if ($_SESSION['countRespuesta']==$rowPregunta['orden']) {
        	header("Location: ./finJuegoGamer.php");
     	}
    ?>
  </body>
</html>