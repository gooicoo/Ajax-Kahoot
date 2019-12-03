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
?>


<?php

	//Hardcode kahoot_id=2
	$queryPin = $pdo->prepare("SELECT pin FROM kahoot where kahoot_id=2;");
    $queryPin->execute();
    $rowPin = $queryPin->fetch();
    echo "#".$rowPin['pin'];
?>