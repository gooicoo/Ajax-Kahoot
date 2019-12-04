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
			 $username = "admin_kahoot";
			 $pw = "P@ssw0rd";
			 $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
			 } catch (PDOException $e) {
				 echo "Failed to get DB handle: " . $e->getMessage() . "\n";
				 exit;
			 }

		?>


		<div id="barra-menu">
			<input type="checkbox" class="checkbox" id="menu-toogle"/>
			<label for="menu-toogle" class="menu-toogle"></label>
			<nav class="nav">
			  <a href="#" class="nav__item">Perfil</a>
			  <a href="#" class="nav__item">Cerrar sesión</a>
			</nav>

			<div class="identidad">
				<?php
					session_start();
					//echo "Bienvenido ".$_SESSION['user'];
					//echo "Id Usuario = ".$_SESSION['userId'];
					$usuario = $_SESSION['user'];
					echo $usuario;
				?>
			</div>
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
					<form method="post">

						<?php
							$user = $_SESSION['userId'];
							$query = $pdo -> prepare(" SELECT kahoot_name,kahoot_id FROM kahoot where user_id=$user; ");
							$query -> execute();
							$row = $query -> fetch();

							while ($row) {
								$partida = $row['kahoot_name'];
								$id_kahoot = $row['kahoot_id'];
								echo "<input class='nombre-juego' type='radio' name='gender' value='$id_kahoot' >".$partida." </input> <br>";
								$row = $query->fetch();
							}
							if(isset($_POST['gender'])){
								session_start();
								$_SESSION['kahoot_id'] = $_POST['gender'];
								header('Location: ../waitingRoom/index.php');
							}
						?>

						<input class="enviar-opcion opcion-jugar" type="submit" value="JUGAR">
					</form>

				</div>

			</div>

		</div>
	</body>
</html>
