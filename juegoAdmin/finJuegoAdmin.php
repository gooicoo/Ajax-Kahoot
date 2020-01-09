<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>fin juego admin</title>
    <link rel="stylesheet" href="./CSS/styleFin.css">
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

    <div class="finJuego">
      <h3>Fin del juego</h3>

<!--
      <h4>Ranking</h4>
      <?php
/*        $query = $pdo -> prepare(" select * from gamer where gamer_id=(select gamer_id from ranking where kahoot_id='".$_SESSION['kahoot_id']."') limit 3; ");
        $query -> execute();
        $row = $query -> fetch();

        while ($row) {
          echo $row['gamer_name'];
          $row = $query -> fetch();
        }
*/        
      ?>
-->

      <form class="" action="./../login_singIn/loginCorrect.php" method="post">
        <input class="volver" type="submit" name="" value="Inicio">
      </form>
    </div>


    <?php
          // -- reiniciar juego empezado [start_game] -- //
      $queryGamer = $pdo -> prepare(" update kahoot set start_game=0 where pin='".$_SESSION['pin']."'; ");
      $queryGamer -> execute();

          // -- reiniciar estado juego [active] -- //
      $queryGamer = $pdo -> prepare(" update kahoot set active=0 where pin='".$_SESSION['pin']."'; ");
      $queryGamer -> execute();

          // -- reiniciar siguiente pregunta [next] -- //
      $queryGamer = $pdo -> prepare(" update question set next=0 where kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $queryGamer -> execute();

          // -- borrar jugadores partida -- //
      $queryRanking = $pdo -> prepare(" DELETE FROM ranking WHERE kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $queryRanking -> execute();

      $queryGamer = $pdo -> prepare(" DELETE FROM gamer WHERE kahoot_id='".$_SESSION['kahoot_id']."'; ");
      $queryGamer -> execute();


    ?>


  </body>
</html>
