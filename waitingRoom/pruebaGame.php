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

	$queryEstadoKahoot = $pdo->prepare("Update kahoot Set active=false Where kahoot_id=".$_SESSION['kahoot_id'].";");
	$queryEstadoKahoot->execute();


	echo "Kahoot ID = ".$_POST['kahoot_id']."<br>";
	echo "Estado kahoot = false";
?>