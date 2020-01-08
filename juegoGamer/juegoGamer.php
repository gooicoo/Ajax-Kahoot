<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Juego Gamer</title>
    <script src="js/cuentaAtrasQuestion.js"></script>
    <link rel="stylesheet" href="./CSS/style.css">


  </head>
  <body onload="cronoInicio()">
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
      $query = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $query -> execute();
      $row = $query -> fetch();

      $totalPreguntas = 0;
      while ($row) {
        $totalPreguntas ++;
        $row = $query -> fetch();
      }

      $_SESSION['countRespuesta'] += 1;
      $countRespuesta = $_SESSION['countRespuesta'];
      $queryPregunta = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$countRespuesta."; ");
      $queryPregunta -> execute();
      $rowPregunta = $queryPregunta -> fetch();

      $_SESSION['question_id'] = $rowPregunta['question_id'];
      $orden = $rowPregunta['orden'];

      $queryRespuestas = $pdo -> prepare(" select * from answer where question_id='".$_SESSION['question_id']."'; ");
      $queryRespuestas -> execute();
      $rowRespuestas = $queryRespuestas -> fetch();


    ?>




    <div class="numeroPregunta">
      <?php echo 'PREGUNTA '.$orden.'/'.$totalPreguntas ;?>
    </div>

      <?php 
        echo "<p id='tiempo' class='cuentaAtras' style='margin-top:150px;'>".$rowPregunta['time']."</p>";
      ?>

    <div class="opciones">
      <form class="" action="opcionSelec.php" method="post">
        <?php
          echo '<input id="tiempoContestar" type="hidden" name="tiempoContestar" value='.$rowPregunta["time"].'></input>';
          $cont=0;
          while ($rowRespuestas) {
            echo "<input class='respuestas caja".$cont."' type='submit' name='respuesta' value='".$rowRespuestas['answer_name']."'></input>";
            $cont ++;
            $rowRespuestas = $queryRespuestas -> fetch();
          }
        ?>
      </form>

    </div>

    <?php
      if ($countRespuesta>$totalPreguntas) {
        header("Location: ./finJuegoGamer.php");
      }
    ?>

  </body>
</html>
