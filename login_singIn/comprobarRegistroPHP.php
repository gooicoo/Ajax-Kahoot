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

    if ((isset($_POST['user_name'])) and (isset($_POST['password'])) and (isset($_POST['email'])) and (isset($_POST['type']))){
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
        $type = $_POST['type'];
        singInUser($user,$email,$password,$pdo,$nombre,$type);
    }


    function singInUser($user,$email,$password,$pdo,$image,$type) {
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
                $query = $pdo->prepare("INSERT INTO users (user_name,password,email,user_type,profile_image) VALUES ('".$user."',sha2('".$password."',512),'".$email."','$type','".$image."');");
                $query->execute();
                $row = $query->fetch();

                $user_id = $pdo->lastInsertId();

                // Generar el token
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                sendWelcomeMail($email, $user, $token);

                // Guardar el token en la base de datos
                $query = $pdo->prepare("INSERT INTO token (token, user_id, type, expired) VALUES ('$token', $user_id, 'TOS', 0)");
                $row = $query->execute();
                header("Location: ./index.php");
                exit;
            }
        }
    }

    function sendWelcomeMail($to, $name, $token) {
      $domain = "keepcalm.cf";
      $link = "http://".$domain."/Ajax-Kahoot/login_singIn/acceptTOS.php?token=".$token;

      $subject = "Bienvenido a AJAX-Kahoot!";
      $txt = "<html><div style='max-width: 600px;'><h2>Bienvenido $name,</h2></br>".
            "<p>Gracias por registrarte en AJAX-Kahoot. Para poder hacer uso de nuestra web debes aceptar los términos de servicio del siguiente enlace:</p></br>".
            "<a href='$link'>$link</a></br>".
            "<h3>¡Que disfrutes creando muchos Kahoots!</h3></br>".
            "</p>El equipo AJAX-Kahoot</p></div></html>";

      // To send HTML mail, the Content-type header must be set
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';
      $headers[] = "From: AJAX-Kahoot <ajax-kahoot@playajaxkahoot.free>";

      mail($to, $subject, $txt, implode("\r\n", $headers));
    }
?>
