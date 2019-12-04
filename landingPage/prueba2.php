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


    $query = $pdo -> prepare(" SELECT * FROM kahoot where pin='".$_SESSION['pin']."'; ");
    $query -> execute();
    $row = $query -> fetch();

    echo "Pin Kahoot = ".$_SESSION['pin']."<br>";
    echo "Nick name gamer = ".$_POST['nickname']."<br>";
    echo "Kahoot ID = ".$row['kahoot_id'];
    
    $queryGamer = $pdo -> prepare("INSERT INTO gamer (gamer_name, kahoot_id) values ('".$_POST['nickname']."',".$row['kahoot_id'].");");
    $queryGamer -> execute();
    $row = $queryGamer->fetch();

?>