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

  $queryPin = $pdo->prepare("SELECT pin FROM kahoot where kahoot_id=".$_SESSION['kahoot_id'].";");
    $queryPin->execute();
    $rowPin = $queryPin->fetch();
    $_SESSION['pin'] = $rowPin['pin'];
    echo "#".$rowPin['pin'];
?>
