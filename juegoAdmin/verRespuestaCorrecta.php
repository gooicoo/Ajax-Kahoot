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
       $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
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

      $_SESSION['question_id'] = $rowPregunta['question_id'];

      $respuesta = $_SESSION['respuesta'];

      if ($respuesta=='1') {
        $respuesta = 'Verdadero';
      }elseif ($respuesta=='2') {
        $respuesta = 'Falso';
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
