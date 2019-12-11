<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>player PIN</title>
    <link rel="stylesheet" type="text/css" href="./CSS/playerPIN.css" media="all">
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
      session_start();
      if ( isset($_POST['pin']) ) {
        $_SESSION['pin'] = $_POST['pin'];
      }
    ?>

    <div id="contenido">
      <form class="" action="salaEspera.php" method="post">
        <input id="codePin" type="text" name="nickname" placeholder="NICK NAME">
        <input id="submitPin" type="submit" value="ENTRAR">
      </form>
    </div>



  </body>
</html>
