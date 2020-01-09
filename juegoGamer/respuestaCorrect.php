<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>respues correcta</title>
    <link rel="stylesheet" href="./CSS/respuesta.css">
    <meta http-equiv="refresh" content="10;URL=cuentaAtrasRespuesta.php" >
  </head>

  <body class="bodyCorrect">

    <div class="correct"></div>

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



      $queryOrden = $pdo -> prepare(" SELECT * FROM selected where answer_id='".$_SESSION['answer_id']."' ORDER BY selected_id; ");
      $queryOrden -> execute();
      $row = $queryOrden -> fetch();

      $puntos = $_SESSION['puntosPregunta'];
      while ($row) {
        $gamerID = $row['gamer_id'];
        $queryRanking = $pdo -> prepare(" update ranking set points=points+".$puntos." where gamer_id=".$gamerID."; ");
        $queryRanking -> execute();

        $puntos = $puntos-rand(20,50);

        $row = $queryOrden -> fetch();
      }
    ?>

    <?php
      $queryPreguntaNext = $pdo -> prepare(" select * from question where kahoot_id='".$_SESSION['kahoot_id']."' and orden=".$_SESSION['countRespuesta']."; ");
      $queryPreguntaNext -> execute();
      $rowPreguntaNext = $queryPreguntaNext -> fetch();


    ?>


    <?php
      $deleteSelected = $pdo -> prepare(" DELETE FROM selected; ");
      $deleteSelected -> execute();
     ?>
  </body>
</html>
