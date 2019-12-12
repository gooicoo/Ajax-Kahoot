<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Juego Gamer</title>
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
      $queryPregunta = $pdo -> prepare(" select orden from question where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $queryPregunta -> execute();
      $rowNumPreg = $queryPregunta -> fetch();

      $orden = $rowNumPreg['orden'];

      $totalPreguntas = 0;
      while ($rowNumPreg) {
        $totalPreguntas ++;
        $rowNumPreg = $queryPregunta -> fetch();
      }
    ?>




    <div class="numeroPregunta">
      <?php echo 'PREGUNTA '.$orden.'/'.$totalPreguntas; ?>
    </div>
    <div class="opciones">
      <form class="" action="opcionSelec.php" method="post">
        <?php
          $queryRespuestas = $pdo -> prepare(" select * from answer where question_id='".$_SESSION['question_id']."'; ");
          $queryRespuestas -> execute();
          $rowRespuestas = $queryRespuestas -> fetch();

          $cont=0;
          while ($rowRespuestas) {
            echo "<input class='respuestas caja".$cont."' type='submit' name='respuesta' value='".$rowRespuestas['answer_name']."'></input>";
            $cont ++;
            $rowRespuestas = $queryRespuestas -> fetch();
          }
        ?>
      </form>

    </div>




  </body>
</html>
