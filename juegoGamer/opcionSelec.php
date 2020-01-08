<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>opcion selec</title>
    <link rel="stylesheet" href="./CSS/styleOpcionSelec.css">
    <meta http-equiv="refresh" content="1;URL=opcionSelec.php" >
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
      if ( isset($_POST['respuesta']) ) {
        $_SESSION['respuesta'] = $_POST['respuesta'];
      }
      if (isset($_GET['tiempo'])) {
        $_SESSION['tiempo'] = $_GET['tiempo'];
      }
     ?>


     <div class="animacionEspera">
       <img id="relojArena" src="./IMG/relojArena.png" alt="">
     </div>


     <?php
       $queryPreguntaNext = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$_SESSION['countRespuesta']."; ");
       $queryPreguntaNext -> execute();
       $rowPreguntaNext = $queryPreguntaNext -> fetch();
       $pregunaNext = $rowPreguntaNext['next'];
       $_SESSION['puntosPregunta'] = $rowPreguntaNext['question_points'];

       $queryRespuestaCorrect = $pdo -> prepare(" select * from answer where question_id='".$_SESSION['question_id']."' and answer_name='".$_SESSION['respuesta']."'; ");
       $queryRespuestaCorrect -> execute();
       $rowRespuestaCorrect = $queryRespuestaCorrect -> fetch();
       $respuestaCorrect = $rowRespuestaCorrect['correct'];
       $answerID = $rowRespuestaCorrect['answer_id'];
       $_SESSION['answer_id'] = $answerID;

       $respuesta = $_SESSION['respuesta'];
       $gamerID = $_SESSION['gamerID'];
       $tiempoContestar = '3';

       if ($respuesta=='1') {
         $respuesta = 'Verdadero';
       }elseif ($respuesta=='2') {
         $respuesta = 'Falso';
       }

      if (isset($_SESSION['tiempo'])) {
        if ($pregunaNext==1) {
          unset($_SESSION['tiempo']);
          header("Location: ./respuestaIncorrect.php");
        }
      }else if ($pregunaNext==1 and $respuestaCorrect==1) {
        header("Location: ./respuestaCorrect.php");
      }else if ($pregunaNext==1 and $respuestaCorrect==0) {
        header("Location: ./respuestaIncorrect.php");
      }else if ($respuestaCorrect==1){
        if ( isset($_POST['respuesta']) ) {
          $querySelect = $pdo -> prepare( " INSERT INTO selected (answer_name , answer_id , gamer_id , time) values ('$respuesta' , '$answerID' , '$gamerID' , $tiempoContestar); " );
          $querySelect -> execute();
        }
      }
     ?>
  </body>
</html>
