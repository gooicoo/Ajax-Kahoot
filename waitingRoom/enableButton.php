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



  //Hardcode kahoot_id=2
  $queryComprobarJugadoresActivos = $pdo->prepare("SELECT * FROM gamer where kahoot_id=".$_SESSION['kahoot_id'].";");
  $queryComprobarJugadoresActivos->execute();
  $rowJugador = $queryComprobarJugadoresActivos->fetch();
  if($rowJugador!=""){
    echo '<input type="hidden" name="kahoot_id" value="2">';
    echo '<button type="sumbit" class="btn">Play</button>';
  }else{
    echo '<button type="sumbit" disabled class="btn">Play</button>';
  }
?>
