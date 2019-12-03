 <?php
  try {
    $hostname = "localhost";
    $dbname = "kahoot";
    $username = "joel";
    $pw = "P@ssw0rd";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }

	//Hardcode kahoot_id=2
	$queryJugadores = $pdo->prepare("SELECT * FROM gamer where kahoot_id=".$_SESSION['kahoot_id'].";");
  $queryJugadores->execute();
  $rowJugador = $queryJugadores->fetch();

	while($rowJugador){
		echo "<div class='letter'>".$rowJugador['gamer_name']."</div>";
		$rowJugador = $queryJugadores->fetch();
	}
?>
