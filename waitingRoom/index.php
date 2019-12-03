<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel=stylesheet href="waitingCSS.css">
	<meta http-equiv="refresh" content="5;URL=waitingRoom.php" >
</head>
<body>
	<div class="container">
		<div class="container_pin"><?php require('pinKahoot.php'); ?></div>
		<div class="jugadores">
			<div class="waiting">Waiting for players...</div>
			<div class="jugador">
				<?php require('gamersActive.php'); ?>
			</div>
		</div>
		<form method="post" action="pruebaGame.php">
			<?php require ('enableButton.php');  ?>
		</form>
	</div>
</body>
</html>