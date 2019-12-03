<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>player PIN</title>
    <link rel="stylesheet" type="text/css" href="./playerPIN.css" media="all">
  </head>
  <body>
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

    <div id="contenido">
      <form class="" method="post">

        <input id="codePin" type="text" name="pin" placeholder="CODE KAHOOT">
        <input id="submitPin" type="submit" name="" value="ENTRAR">
      </form>

    </div>

    <div id="pinIncorrecto">
      <?php

        if ( isset($_POST['pin']) ) {
          $pinGame = $_POST['pin'];
          $query = $pdo -> prepare(" SELECT * FROM kahoot where pin='$pinGame'; ");
          $query -> execute();
          $row = $query -> fetch();

          if ($row!="") {
            $queryPin = $pdo -> prepare("SELECT pin FROM kahoot where pin='$pinGame';");
            session_start();
            $_SESSION['pin'] = $pinGame;

            $queryPin -> execute();
            $rowId = $queryPin->fetch();
            header("Location: ./playerNick.php");
            exit;
          }else{
            echo "<span> EL CODE NO EXISTE </span>";
          }

        }

      ?>
    </div>



  </body>
</html>
