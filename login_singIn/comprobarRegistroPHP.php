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
        if ($_FILES['image']["name"]!="") {
            $nombre = basename($_FILES["image"]["name"]);
        }else{
            $nombre = "img_defecto.png";
        }
        session_start();
        $user = $_POST['user_name'];
        $_SESSION['user'] = $user;
        $email = $_POST['email']; 
        $password = $_POST['password']; 
        singInUser($user,$email,$password,$pdo,$nombre);
    }


    function singInUser($user,$email,$password,$pdo,$image){
        //Query para comprobar si ya hay un nombre igual en la base de datos.
        $query = $pdo->prepare("SELECT * FROM users where user_name='".$user."';");
        $query2 = $pdo->prepare("SELECT * FROM users where email='".$email."';");
        $query->execute();
        $query2->execute();
        $row = $query->fetch();
        $row2 = $query2->fetch();
        if ($row!="") {
            echo "<span id='rojo'>Nombre de usuario ya existente</span>";
        }elseif ($row2!="") {
            echo "<span id='rojo'>Email ya existente</span>";
        }else{
            if ($user=="") {
                echo "<span id='rojo'>Introduce nombre de usuario</span>";
            }elseif ($password=="") {
                echo "<span id='rojo'>Introduce contraseña</span>";
            }elseif ($email=="") {
                echo "<span id='rojo'>Introduce email</span>";
            }else{
                if ($image != "img_defecto.jpg") {
                    $dir_subida = '../imatges_kahoot/imatges_profile/';
                    $origen=$_FILES["image"]["tmp_name"];
                    @move_uploaded_file($origen,$dir_subida.$image);
                }
                $query = $pdo->prepare("INSERT INTO users (user_name,password,email,user_type,profile_image) VALUES ('".$user."',sha2('".$password."',512),'".$email."','admin','".$image."');");
                $query->execute();
                $row = $query->fetch();

                header("Location: ./index.php");
                exit;
            }
        }
    }
?>
