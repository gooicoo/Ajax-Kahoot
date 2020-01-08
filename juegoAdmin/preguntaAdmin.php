<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pregunta Admin</title>
    <link rel="stylesheet" href="./CSS/style.css">
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
      // ----- jugador entra en la partida ----- //
      $queryGamer = $pdo -> prepare(" update kahoot set start_game=1 where pin='".$_SESSION['pin']."'; ");
      $queryGamer -> execute();
    ?>

    <?php
      $query = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $query -> execute();
      $row = $query -> fetch();

      $totalPreguntas = 0;
      while ($row) {
        $totalPreguntas ++;
        $row = $query -> fetch();
      }

      $_SESSION['countPregunta'] += 1;
      $countPregunta = $_SESSION['countPregunta'];

      $queryPregunta = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$countPregunta."; ");
      $queryPregunta -> execute();
      $rowPregunta = $queryPregunta -> fetch();

      $orden = $rowPregunta['orden'];
      $pregunta = $rowPregunta['question_name'];

      $_SESSION['question_id'] = $rowPregunta['question_id'];
    ?>

    <div class="numeroPregunta">
      <?php echo 'PREGUNTA '.$orden.'/'.$totalPreguntas; ?>
    </div>

    <div class="textoPregunta">
      <p class='pregunta'> <?php echo $pregunta; ?> </p>
    </div>


    <div class="botonNext">

      <form class="" action="verRespuestaCorrecta.php" method="post">
        <input class="next" type="submit" name="" value="CONTINUAR">
      </form>


    </div>

  </body>
</html>
