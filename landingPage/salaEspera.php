<!DOCTYPE html>
<html lang="sp" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Empezando juego</title>
    <link rel="stylesheet" href="./CSS/esperaJugar.css">
    <meta http-equiv="refresh" content="3;URL=salaEspera.php" >
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
         if ( isset($_POST['nickname']) ) {
           $_SESSION['nickname'] = $_POST['nickname'];
         }
    ?>

    <div class="animacionEspera">
      <img id="relojArena" src="./IMG/relojArena.png" alt="">
    </div>

    <div class="datosJugador">
      <?php
        $query = $pdo -> prepare(" SELECT * FROM kahoot where pin='".$_SESSION['pin']."'; ");
        $query -> execute();
        $row = $query -> fetch();

        $nombreGamer = $_SESSION['nickname'];
        $kahootID = $row['kahoot_id'];
        $_SESSION['kahoot_id'] = $kahootID;

        echo " <p class='nombreJugador'> $nombreGamer </p> ";

        if ( isset($_POST['nickname']) ) {
          $queryGamer = $pdo -> prepare(" INSERT INTO gamer (gamer_name, kahoot_id) values ('$nombreGamer','$kahootID'); ");
          $queryGamer -> execute();
        }
      ?>
    </div>

    <div class="esperar">
      <p>esperando para comenzar <span class=puntos></span></p>
    </div>

    <?php
      $querycomprobarJugar = $pdo -> prepare(" SELECT start_game FROM kahoot where pin='".$_SESSION['pin']."'; ");
      $querycomprobarJugar -> execute();
      $rowcomprobarJugar = $querycomprobarJugar -> fetch();

      $comporbarEntrar = $rowcomprobarJugar['start_game'];

      if ($comporbarEntrar==1) {
        $_SESSION['countRespuesta'] = 0;
        header("Location: ../juegoGamer/cuentaAtrasRespuesta.php");
      }

    ?>



  </body>
</html>
