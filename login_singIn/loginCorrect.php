<!DOCTYPE html>
<html>
<head>
</head>
<link rel=stylesheet href="./CSS/loginCorrectCSS.css">
<body>
	<?php
		session_start();
		echo "Bienvenido ".$_SESSION['user'];
		echo "<br>";
		echo "Id Usuario = ".$_SESSION['userId'];
	?>
</body>
</html>