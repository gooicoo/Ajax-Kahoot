<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["oldPassword"]) and isset($_POST["password1"]) and isset($_POST["token"]) and isset($_POST["user_id"])) {
    $correct = checkPassword($_POST['oldPassword'], $_POST['user_id']);
    if ($correct) {
      updatePassword($_POST["password1"], $_POST["user_id"]);
      updateToken($_POST["token"]);
      $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Tu contraseña se ha cambiado correctamente!</strong> La próxima vez que inicies sesión deberás utilizar esta contraseña.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
      header("Refresh: 1; URL=.");
    } else {
      $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error al cambiar la contraseña:</strong> La última contraseña es incorrecta, vuelve a intentarlo.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  } else {
    if ($_SERVER["REQUEST_METHOD"] == "GET" and isset($_GET["token"])) {
      $token = $_GET["token"];
      $result = tokenExists($token);
      if (!$result) {
        header("Location: .");
      } else {
        $user_id = $result["user_id"];
      }
    } else {
      header("Location: .");
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Change password</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/changePassword.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        var form = document.getElementById("passwordForm");
        form.onsubmit = function() {
          var oldPassword = document.getElementById("oldPassword").value;
          if (oldPassword == "" || oldPassword == " ") {
            return false;
          }
          var pass1 = document.getElementById("password1");
          var pass2 = document.getElementById("password2");
          if (pass1.value == "" || pass2.value == "" || pass1.value == " " || pass2.value == " ") {
            alert("Invalid password!");
            return false;
          }
          if (pass1.value != pass2.value) {
            alert("Passwords don't match!");
            return false;
          }
          return true;
        };
      });
    </script>
  </head>
  <body>
    <?php
      if (isset($alert)) {
        echo $alert;
      }
     ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Change Password</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
          <p class="text-center">Use the form below to change your password. Your password shouldn't be the same as your username.</p>
          <form method="post" id="passwordForm">
            <input type="password" class="input-lg form-control" name="oldPassword" id="oldPassword" placeholder="Old password" autocomplete="off">
            <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
            <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
            <input type="text" name="token" value="<?=$token;?>" style="display: none;">
            <input type="text" name="user_id" value="<?=$user_id;?>" style="display: none;">
            <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Change Password">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
  function getConnection() {
    $hostname = "localhost";
    $dbname = "kahoot";
    $username = "admin_kahoot";
    $pw = "P@ssw0rd";
    return new PDO("mysql:host=$hostname;dbname=$dbname;", $username, $pw);
  }

  function tokenExists($token) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT user_id FROM token WHERE token = '$token' and type='PWD' and expired = 0");
    $success = $query->execute();
    if ($success) {
      $row = $query->fetch();
      return $row;
    }
    return $success;
  }

  function updatePassword($pwd, $user_id) {
    $pdo = getConnection();
    $query = $pdo->prepare("UPDATE users SET password = sha2(:password, 512) WHERE user_id = :user_id");
    $query->bindParam(':password', $pwd, PDO::PARAM_STR, 250);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
  }

  function updateToken($token) {
    $pdo = getConnection();
    $query = $pdo->prepare("UPDATE token SET expired = 1 WHERE token = '$token'");
    $query->execute();
  }

  function checkPassword($password, $user_id) {
    $pdo = getConnection();
    $query = $pdo->prepare("SELECT password FROM users WHERE password = sha2(?, 512) and user_id = ?");
    $query->bindParam(1, $password);
    $query->bindParam(2, $user_id);
    $success = $query->execute();
    $row = $query->fetch();
    if (!$row) {
      return false;
    }
    return true;
  }
 ?>
