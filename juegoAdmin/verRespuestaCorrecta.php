<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Respuesta Correcta</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <meta http-equiv="refresh" content="5;URL=siguientePregunta.php" >
  </head>

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

  <body>
    <?php
      $query = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $query -> execute();
      $row = $query -> fetch();

      $totalPreguntas = 0;
      while ($row) {
        $totalPreguntas ++;
        $row = $query -> fetch();
      }
      $_SESSION['totalPreguntas'] = $totalPreguntas;

      $queryPregunta = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$_SESSION['countPregunta']."; ");
      $queryPregunta -> execute();
      $rowPregunta = $queryPregunta -> fetch();

      $orden = $rowPregunta['orden'];
      $pregunta = $rowPregunta['question_name'];
      $questionType = $rowPregunta['question_type'];

      $_SESSION['question_id'] = $rowPregunta['question_id'];
      $question_id = $rowPregunta['question_id'];

      $queryRespuestaCorrecta = $pdo -> prepare(" select * from answer where question_id='".$_SESSION['question_id']."' and correct=1; ");
      $queryRespuestaCorrecta -> execute();
      $rowRespuestaCorrecta = $queryRespuestaCorrecta -> fetch();
      $respuesta = $rowRespuestaCorrecta['answer_name'];
      while ($rowRespuestaCorrecta) {
        $rowRespuestaCorrecta = $queryRespuestaCorrecta -> fetch();
        $respuesta .= " ".$rowRespuestaCorrecta['answer_name'];
      }
      

      if ($questionType == 'FILL_GAPS') {
        $respuestas = array();
        $respuesta = $pregunta;

        $queryRespuestas = $pdo -> prepare("SELECT answer_name FROM answer WHERE question_id = $question_id");
        $queryRespuestas -> execute();
        $rowRespuestas = $queryRespuestas -> fetch();
        while ($rowRespuestas) {
          array_push($respuestas, $rowRespuestas['answer_name']);
          $rowRespuestas = $queryRespuestas -> fetch();
        }
        $lengthResp = count($respuestas);

        for ($i=0; $i < $lengthResp; $i++) {
          $needle = "_";
          $replace = strval($respuestas[0]);
          $haystack = $pregunta;
          $pos = strpos($haystack, $needle);
          $pregunta = substr_replace($haystack, $replace, $pos, strlen($needle));
          $respuesta = $pregunta;
          array_splice($respuestas, 0, 1);
        }
      } elseif ($questionType == 'TRUE/FALSE') {
        if ($respuesta=='1') {
          $respuesta = 'Verdadero';
        }elseif ($respuesta=='2') {
          $respuesta = 'Falso';
        }
      }

    ?>

    <div class="numeroPregunta">
      <?php echo 'RESPUESTA '.$orden.'/'.$totalPreguntas; ?>
    </div>

    <div class="textoPregunta">
      <p class='pregunta'> <?php echo $respuesta; ?> </p>
    </div>




    <?php
      $queryGamer = $pdo -> prepare(" update question set next=1 where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$_SESSION['countPregunta']."; ");
      $queryGamer -> execute();
    ?>


  </body>
</html>
