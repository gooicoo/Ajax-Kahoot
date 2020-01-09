<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel=stylesheet href="waitingCSS.css">
	<meta http-equiv="refresh" content="2;URL=index.php" >
</head>
<body>
	<div class="container">
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
		?>
		<?php
			session_start();
			if (isset($_SESSION['kahoot_id'])) {
				$queryEstadoKahoot = $pdo->prepare("Update kahoot Set active=true Where kahoot_id=".$_SESSION['kahoot_id'].";");
				$queryEstadoKahoot->execute();
			}

			$_SESSION['countPregunta'] = 0;
		?>
		<div class="container_pin"><?php require('pinKahoot.php'); ?></div>
		<div class="jugadores">
			<div class="waiting">Waiting for players...</div>
			<div class="jugador">
				<?php require('gamersActive.php'); ?>
			</div>
		</div>
		<form method="post" action="../juegoAdmin/preguntaAdmin.php">
			<?php require ('enableButton.php');  ?>
		</form>

		<form method="post" action="./../login_singIn/loginCorrect.php">
			<button type="sumbit" class="btn">Volver</button>
		</form>

	</div>
</body>
</html>
