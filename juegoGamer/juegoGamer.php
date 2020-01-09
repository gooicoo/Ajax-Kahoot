<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Juego Gamer</title>
    <script src="js/cuentaAtrasQuestion.js"></script>
    <link rel="stylesheet" href="./CSS/style.css">
  </head>
  <body>
    <?php
      try {
         $hostname = "localhost";
         $dbname = "kahoot";
         $username = "admin_kahoot";
         $pw = "P@ssw0rd";
         $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname;charset=utf8;","$username","$pw");
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
      $questionType = $rowPregunta['question_type'];

      $queryRespuestas = $pdo -> prepare(" select * from answer where question_id='".$_SESSION['question_id']."'; ");
      $queryRespuestas -> execute();
      $rowRespuestas = $queryRespuestas -> fetch();


    ?>




    <div class="numeroPregunta">
      <?php echo '<div style="margin-left: 50px;">PREGUNTA '.$orden.'/'.$totalPreguntas.'</div>';?>
      <?php echo "<div id='tiempo' style='margin-right: 50px;'>".$rowPregunta['time']."</div>"; ?>
    </div>
    
    <div class="opciones">
      <?php if ($questionType == "FILL_GAPS"): ?>
        <form action="opcionSelec.php" method="post">
          <?php
          // Importar Drag & Drop
          echo '<script type="text/javascript" src="js/DnD.js"></script>';

          $answers = array();
          while ($rowRespuestas) {
            array_push($answers, $rowRespuestas['answer_name']);
            $rowRespuestas = $queryRespuestas -> fetch();
          }
          $countAnswers = count($answers);
          $cont = 0;
          for ($i=0; $i < $countAnswers; $i++) {
            $rand = rand(0, count($answers)-1);
            $answerRnd = $answers[$rand];
            echo "<div class='respuestas caja$cont flex'>
                    <p class='form-p' draggable='true'>$answerRnd</p>
                    <input type='hidden' name='respuesta".($i+1)."' value='$answerRnd'></input>
                  </div>";
            array_splice($answers, $rand, 1);
            if ($cont == 3) {
              $cont = 0;
            } else {
              $cont++;
            }
          }
          ?>
          <input type="submit" value="Validar este orden"></input>
          <input type='hidden' value=<?=$countAnswers;?> name='totalAnswers'></input>
        </form>
      <?php else:?>
        <form class="" action="opcionSelec.php" method="post">
          <?php
          $cont=0;
          while ($rowRespuestas) {
            echo "<input class='respuestas caja".$cont."' type='submit' name='respuesta' value='".$rowRespuestas['answer_name']."'></input>";
            if ($cont == 3) {
              $cont = 0;
            } else {
              $cont++;
            }
            $rowRespuestas = $queryRespuestas -> fetch();
          }
          ?>
        </form>
      <?php endif; ?>

    </div>
    
    <?php
      if ($countRespuesta>$totalPreguntas) {
        header("Location: ./finJuegoGamer.php");
      }
    ?>


  </body>
</html>
