<!DOCTYPE html>
<html>
	<head>
		<link rel=stylesheet href="./CSS/pagPrincipal.css">
		<link rel=stylesheet href="./CSS/CSSinputs.css">
		<script type="text/javascript" src="../js/scriptsEventsInputs.js"></script>
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

		<?php 
			session_start();
			$user_id = $_SESSION['userId'];
			$query = $pdo->prepare("SELECT token from token WHERE user_id = $user_id  and type = 'TOS' and expired=1");
			$success = $query->execute();
	    if ($success) {
	      $row = $query->fetch();
				if (!$row) {
					header("Location: editarPerfil.php");
				}
	    } else {
				header("Location: .");
			}
		 ?>

		<div id="barra-menu" style="z-index: 100;">
			<input type="checkbox" class="checkbox" id="menu-toogle"/>
			<label for="menu-toogle" class="menu-toogle"></label>

			<nav class="nav">
			  <a href="editarPerfil.php" class="nav__item">Editar perfil</a>
			  <a href="index.php" class="nav__item">Cerrar sesión</a>
			</nav>

			<div class="identidad">
				<?php
					//echo "Bienvenido ".$_SESSION['user'];
					//echo "Id Usuario = ".$_SESSION['userId'];

					$usuario = $_SESSION['user'];
					$user = $_SESSION['userId'];
					$query = $pdo -> prepare("SELECT * FROM users where user_id=$user;");
					$query -> execute();
					$row = $query -> fetch();
					echo "<img src='../imatges_kahoot/imatges_profile/".$row['profile_image']."' style='width: 70px; height: 60px; margin-right:5px;'>";
					echo $usuario;

				?>
			</div>
		</div>

		<div id="main">
			<div id="crear-pregunta">
				<form class="" action="../creator.php" method="post">
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
							if(isset($_POST['gender']) and isset($_POST['jugar'])){
								session_start();
								$_SESSION['kahoot_id'] = $_POST['gender'];
								header('Location: ../waitingRoom/index.php');
							}elseif(isset($_POST['gender']) and isset($_POST['eliminar'])){
								$queryQuestion = $pdo -> prepare(" SELECT * FROM question where kahoot_id=".$_POST['gender']."; ");
								$queryQuestion -> execute();
								$rowQuestion = $queryQuestion -> fetch();
								while ($rowQuestion) {
									$queryEliminarAnswer = $pdo -> prepare('DELETE FROM answer where question_id='.$rowQuestion['question_id'].';');
									$queryEliminarAnswer -> execute();
									$queryEliminarQuestion = $pdo -> prepare('DELETE FROM question where question_id='.$rowQuestion['question_id'].';');
									$queryEliminarQuestion -> execute();
									$rowQuestion = $queryQuestion->fetch();
							}
							$queryEliminarKahoot = $pdo -> prepare('DELETE FROM kahoot where kahoot_id='.$_POST['gender'].';');
							$success = $queryEliminarKahoot -> execute();
							}elseif(isset($_POST['gender']) and isset($_POST['editar'])){
								$queryDatosKahoot = $pdo -> prepare(" SELECT * FROM kahoot where kahoot_id=".$_POST['gender']."; ");
								$queryDatosKahoot -> execute();
								$rowDatos = $queryDatosKahoot -> fetch();
								session_start();
								$_SESSION['kahoot_id'] = $_POST['gender'];
								$_SESSION["titulo-kahoot"] = $rowDatos['kahoot_name'];
								header('Location: ../creator.php');
							}


							$user = $_SESSION['userId'];
							$query = $pdo -> prepare(" SELECT kahoot_name,kahoot_id FROM kahoot where user_id=$user; ");
							$query -> execute();
							$row = $query -> fetch();
							$contador = 0;
							while ($row) {
								$partida = $row['kahoot_name'];
								$id_kahoot = $row['kahoot_id'];
								echo "<input id='$contador' class='nombre-juego' type='radio' name='gender' value='$id_kahoot' /><label for='$contador'>".$partida." </label> <br>";
								$row = $query->fetch();
								$contador ++;
							}
						?>
						<input name="jugar" id="JUGAR" class="opcion-jugar botones_kahoot boton_play" type="submit" value="" style="margin-top: 50px; margin-left: 50px;" />
	    				<input name="editar" id="EDITAR" class="opcion-jugar botones_kahoot boton_editar" type="submit" value=""/>
	    				<input name="eliminar" id="ELIMINAR" class="opcion-jugar botones_kahoot boton_eliminar" type="submit" value="" />
					</form>

				</div>

			</div>

		</div>


	</body>
</html>
