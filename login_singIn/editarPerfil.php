<html>
	<head>
		<link rel=stylesheet href="./CSS/editarPerfil_CSS.css">
	</head>

	<body>
		<div id="barra-menu">
			<input type="checkbox" class="checkbox" id="menu-toogle"/>
			<label for="menu-toogle" class="menu-toogle"></label>

			<nav class="nav">
			  <a href="loginCorrect.php" class="nav__item">Inicio</a>
			  <a href="index.php" class="nav__item">Cerrar sesión</a>
			</nav>

			<div class="identidad">
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
					$usuario = $_SESSION['user'];
					$user = $_SESSION['userId'];
					$query = $pdo -> prepare("SELECT * FROM users where user_id=$user;");
					$query -> execute();
					$row = $query -> fetch();
					$email = $row['email'];
					$user_img = $row['profile_image'];
					echo "<img src='../imatges_kahoot/imatges_profile/".$row['profile_image']."' style='width: 70px; height: 60px; margin-right:5px;'>";
					echo $usuario;
				?>
			</div>
		</div>

		<div id="main">
			<hr id="separador">
			<div id="editar-perfil">
				<p>Editar perfil</p>
					<form method="POST" enctype="multipart/form-data">
						<div id="datos">
							<?php
								echo "Name: <input class='nombre-juego' name='name' value='$usuario'></input> <br>";
								echo "Email: <input class='nombre-juego' name='email' value='".$email."'></input> <br>";
								echo "Profile Image: <img src='../imatges_kahoot/imatges_profile/".$user_img."' style='width: 70px; height: 60px; margin-right:5px;'/>";
								echo '<input type="file" name="image" style="font-size: 15px;"/>';
							?>
						</div>
						<button type="submit" class="enviar-opcion opcion-jugar" id="confirmar">Confirmar</button>
					</form>
				<?php

					$user_img_editado = $row['profile_image'];
					if (isset($_POST['name']) and isset($_POST['email'])) {
						$name_editado = $_POST['name'];
						$user_email_editado = $_POST['email'];
						if ($_FILES['image']["name"]!="") {
							$user_img_editado = $_FILES['image']['name'];
						}else{
							$user_img_editado = $user_img;
						}
						editarPerfil($name_editado,$user_email_editado,$user_img_editado);
					}
					
					
					function editarPerfil($name,$email,$img){
						$hostname = "localhost";
						$dbname = "kahoot";
						$username = "admin_kahoot";
						$pw = "P@ssw0rd";
						$pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
						$query = $pdo->prepare("SELECT * FROM users where user_name='".$name."';");
        				$query2 = $pdo->prepare("SELECT * FROM users where email='".$email."';");
        				$query->execute();
				        $query2->execute();
				        $row = $query->fetch();
				        $row2 = $query2->fetch();
			
				        if ($row!="" and $name!=$_SESSION['user']) {
				            echo "<span id='rojo'>Nombre de usuario ya existente</span>";
				        }elseif ($row2!="" and $email!=$_SESSION['email']) {
				            echo "<span id='rojo'>Email ya existente</span>";
				        }else{
				        	if ($img != "img_defecto.jpg") {
								//echo "holaaaaaaaa";
			                    $dir_subida = '../imatges_kahoot/imatges_profile/';
			                    $origen=$_FILES["image"]["tmp_name"];
			                    @move_uploaded_file($origen,$dir_subida.$img);
	                		}
	                		//echo "holaa";
	                		$_SESSION['user'] = $name;
	                		$_SESSION['email'] = $email;
	                		$query = $pdo->prepare("UPDATE users SET user_name ='".$name."', email='".$email."' ,profile_image='".$img."' WHERE user_id =".$_SESSION['userId'].";");
			                $query->execute();
			                $row = $query->fetch();
			                header("Location: ./loginCorrect.php");
            				exit;
				        }
					}
				?>
		</div>
	</body>
</html>
