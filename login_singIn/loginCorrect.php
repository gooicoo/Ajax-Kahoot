<!DOCTYPE html>
<html>
	<head>
		<link rel=stylesheet href="./CSS/pagPrincipal.css">
	</head>

	<body>
		<?php
			try {
			 $hostname = "localhost";
			 $dbname = "kahoot";
			 $username = "didac";
			 $pw = "P@ssw0rd";
			 $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
			 } catch (PDOException $e) {
				 echo "Failed to get DB handle: " . $e->getMessage() . "\n";
				 exit;
			 }

		?>


		<div id="barra-menu">
			<?php
				session_start();
				echo "Bienvenido ".$_SESSION['user'];
				echo "Id Usuario = ".$_SESSION['userId'];
			?>
		</div>

		<div id="main">
			<div id="crear-pregunta">
				<form class="" action="" method="post">
					<input class="creador-titulo" type="text" name="titulo-kahoot" value="" placeholder="NOMBRE KAHOOT">
					<input class="enviar-opcion" type="submit" name="" value="CREAR">
				</form>
			</div>

			<hr id="separador">

			<div id="juegos-creados">
				<p>LISTADO DE JUEGOS</p>

				<div class="lista-juegos">
					<form class="" action="../waitingRoom/index.php" method="post">

						<?php
							$user = $_SESSION['userId'];
							$query = $pdo -> prepare(" SELECT kahoot_name FROM kahoot where user_id=$user; ");
							$query -> execute();
							$row = $query -> fetch();

							while ($row) {
								$partida = $row['kahoot_name'] ;
								echo "<input class='nombre-juego' type='radio' name='gender' value='$partida' >".$partida." </input> <br>";
								$row = $query->fetch();
							}

						?>

						<input class="enviar-opcion opcion-jugar" type="submit" name="" value="JUGAR">
					</form>

				</div>

			</div>

		</div>
	</body>
</html>
