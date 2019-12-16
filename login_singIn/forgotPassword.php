<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["email"])) {
    $result = userExists($_POST["email"]);
    if (!$result) {
      header("Location: .");
    } else {
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      addToken($token, $result["user_id"]);
      sendRecoveryPassMail($_POST["email"], $result["user_name"], $token);
      header("Location: .");
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forgot Password?</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./CSS/forgotPassword.css">
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        var form = document.getElementById("register-form");
        form.onsubmit = function() {
          var email = document.getElementById("email");
          var validated = validateEmail(email.value);
          if (!validated) {
            alert("You have entered an invalid email address! Try again.");
            return false;
          }
          return true;
        };

        function validateEmail(email) {
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }
      });
    </script>
  </head>
  <body>
    <div class="form-gap"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="text-center">
                <h3><i class="fa fa-lock fa-4x"></i></h3>
                <h2 class="text-center">Forgot Password?</h2>
                <p>You can reset your password here.</p>
                <div class="panel-body">
                  <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                        <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                      </div>
                    </div>
                    <div class="form-group">
                      <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                    </div>
                    <input type="hidden" class="hide" name="token" id="token" value="">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
  function sendRecoveryPassMail($to, $name, $token) {
    $domain = "keepcalm.cf";
    $link = "http://".$domain."/Ajax-Kahoot/login_singIn/changePassword.php?token=".$token;

    $subject = "Cambiar contraseña";
    $txt = "<html><h2>Hola $name,</h2></br>".
          "<p>Para poder cambiar tu contraseña, debes acceder al siguiente enlace:</p></br>".
          "<a href='$link'>$link</a></br>".
          "<p>Te recomendamos que utilices una contraseña con al menos un número, una mayúscula y un carácter especial.</p></br>".
          "</p>El equipo AJAX-Kahoot</p></html>";

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = "From: AJAX-Kahoot <ajax-kahoot@playajaxkahoot.free>";

    mail($to, $subject, $txt, implode("\r\n", $headers));
  }

  function getConnection() {
    $hostname = "localhost";
    $dbname = "kahoot";
    $username = "admin_kahoot";
    $pw = "P@ssw0rd";
    return new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8;", $username, $pw);
  }

  function userExists($email) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT user_id, user_name FROM users WHERE email = '$email'");
    $success = $query->execute();
    if ($success) {
      $row = $query->fetch();
      return $row;
    }
    return $success;
  }

  function addToken($token, $user_id) {
    $pdo = getConnection();
    $query = $pdo->prepare("INSERT INTO token (token, user_id, type, expired) VALUES ('$token', $user_id, 'PWD', 0)");
    $row = $query->execute();
  }

 ?>
