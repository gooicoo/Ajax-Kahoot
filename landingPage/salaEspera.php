<!DOCTYPE html>
<html lang="sp" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Empezando juego</title>
    <link rel="stylesheet" href="./CSS/esperaJugar.css">
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

    <div class="animacionEspera">
      <img id="relojArena" src="./IMG/relojArena.png" alt="">
    </div>

    <div class="datosJugador">
      <?php
        $query = $pdo -> prepare(" SELECT * FROM kahoot where pin='".$_SESSION['pin']."'; ");
        $query -> execute();
        $row = $query -> fetch();

        $nickName = $_POST['nickname'];

        //echo "Pin Kahoot = ".$_SESSION['pin']."<br>";
        echo " <p class='nombreJugador'> $nickName </p> ";
        //echo "Kahoot ID = ".$row['kahoot_id'];

        $queryGamer = $pdo -> prepare("INSERT INTO gamer (gamer_name, kahoot_id) values ('".$_POST['nickname']."',".$row['kahoot_id'].");");
        $queryGamer -> execute();
        $row = $queryGamer->fetch();
      ?>
    </div>

    <div class="esperar">
      <p>esperando para comenzar <span class=puntos></span></p>

    </div>






  </body>
</html>
