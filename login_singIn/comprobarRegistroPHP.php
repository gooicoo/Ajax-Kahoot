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
    if ((isset($_POST['user_name'])) and (isset($_POST['password'])) and (isset($_POST['email']))){
        session_start();
        $user = $_POST['user_name'];
        $_SESSION['user'] = $user;
        $email = $_POST['email']; 
        $password = $_POST['password']; 
        singInUser($user,$email,$password,$pdo);
    }


    function singInUser($user,$email,$password,$pdo){
        //Query para comprobar si ya hay un nombre igual en la base de datos.
        $query = $pdo->prepare("SELECT * FROM users where user_name='".$user."';");
        
        $query->execute();
        $row = $query->fetch();
        if ($row!="") {
            echo "<span id='rojo'>Nombre de usuario ya existente</span>";
        }else{
            if ($user=="") {
                echo "<span id='rojo'>Introduce nombre de usuario</span>";
            }elseif ($password=="") {
                echo "<span id='rojo'>Introduce contraseña</span>";
            }elseif ($email=="") {
                echo "<span id='rojo'>Introduce email</span>";
            }else{
                $query = $pdo->prepare("INSERT INTO users (user_name,password,email,user_type) VALUES ('".$user."',sha2('".$password."',512),'".$email."','admin');");
                $query->execute();
                $row = $query->fetch();

                header("Location: ./index.php");
                exit;
            }
        }
    }
?>
