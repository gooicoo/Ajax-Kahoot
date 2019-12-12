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
      $queryGamer = $pdo -> prepare(" update kahoot set start_game=1 where pin='".$_SESSION['pin']."'; ");
      $queryGamer -> execute();
    ?>

    <?php
      $queryPregunta = $pdo -> prepare(" select question_name , orden from question where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $queryPregunta -> execute();
      $row = $queryPregunta -> fetch();

      $orden = $row['orden'];
      $pregunta = $row['question_name'];
    ?>

    <div class="numeroPregunta">
      <?php echo 'PREGUNTA '.$orden; ?>
    </div>

    <div class="textoPregunta">
      <p class='pregunta'> <?php echo $pregunta; ?> </p>
    </div>


    <div class="botonNext">
      <input class="next" type="button" name="" value="CONTINUAR">
    </div>

  </body>
</html>
