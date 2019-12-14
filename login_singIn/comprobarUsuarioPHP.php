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
    if ((isset($_POST['user_name'])) and (isset($_POST['password']))){
        session_start();
        $user = $_POST['user_name'];
        $_SESSION['user'] = $user;

        $password = $_POST['password'];
        $password = hash('sha512', $password);

        login($user,$password,$pdo);
    }


    function login($user,$password,$pdo){
        $query = $pdo->prepare("SELECT * FROM users where user_name='".$user."' and password='".$password."';");
        $query->execute();
        $row = $query->fetch();
        if ($row!="") {
            $queryId = $pdo->prepare("SELECT user_id FROM users where user_name='".$user."';");
            $queryId->execute();
            $rowId = $queryId->fetch();
            $_SESSION['userId'] = $rowId['user_id'];
            $_SESSION['email'] = $row['email'];
            header("Location: ./loginCorrect.php");
            exit;
        }else{
            echo "<span id='rojo'> Usuario o contraseña incorrecto!</span>";
        }
    }
?>
