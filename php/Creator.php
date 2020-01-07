<?php
include("model/Question.php");
include("model/Answer.php");
include("model/Kahoot.php");

// POST

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["titulo-kahoot"])) {
  // Comprueba si el usuario no es PREMIUM
  $type = getAccountType($_SESSION["userId"]);
  if ($type != "PREMIUM") {
    // Obtener el número de kahoots creados por el usuario
    $numKahoots = getNumberOfKahoots($_SESSION["userId"]);
    if ($numKahoots >= 3) {
      $_SESSION["alertMsg"] = "No puedes crear más de 3 kahoots. (Tu cuenta es gratuita)";
      $_SESSION["alertType"] = "danger";
      header("Location: ./login_singIn/loginCorrect.php");
      exit;
    }
  }

  $_SESSION["titulo-kahoot"] = $_POST["titulo-kahoot"];
  $pin = generatePin();
  $active = 0; //true
  $limit_users = 8; //número máximo de jugadores
  $start_game = 0;
  $next = 0;
  $kahoot = new Kahoot(-1, $_SESSION["userId"], $_SESSION["titulo-kahoot"], $pin, $active, $limit_users, $start_game, $next);
  $transactionInfo = addKahoot($kahoot);
  if ($transactionInfo[0]) {
    $_SESSION["kahoot_id"] = $transactionInfo[1];
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["questionName"]) and isset($_POST["questionTime"]) and isset($_POST["questionOrder"]) and isset($_POST["questionPoints"]) and isset($_POST["validOptions"]) and isset($_POST["questionType"]) and isset($_POST["numberAnswers"])) {
  // Comprueba si el usuario no es PREMIUM
  $createQuestion = false;
  $type = getAccountType($_SESSION["kahoot_id"]);
  if ($type != "PREMIUM") {
    // Obtener el número de preguntas creadas en un kahoot
    $numQuestions = getNumberOfQuestions($_SESSION["kahoot_id"]);
    if ($numQuestions >= 5) {
      $_SESSION["alertMsg"] = "No puedes crear más de 5 preguntas en un kahoot. (Tu cuenta es gratuita)";
      $_SESSION["alertType"] = "danger";
    } else {
      $createQuestion = true;
    }
  } else {
    $createQuestion = true;
  }

  if ($createQuestion) {
    $question = new Question(-1, $_POST["questionName"], $_SESSION["kahoot_id"], $_POST["questionTime"], $_POST["questionOrder"], $_POST["questionPoints"], NULL, 0);
    $transactionInfo = addQuestion($question);
    if ($transactionInfo[0]) {
      $validOptions = explode(",", $_POST["validOptions"]);
      for ($i=0; $i < $_POST["numberAnswers"]; $i++) {
        $correct = 0; // 0 = FALSE, 1 = TRUE
        // Comprueba si la respuesta es correcta
        if (count($validOptions) > 0) {
          for ($j=0; $j < count($validOptions); $j++) {
            if (($i+1) == $validOptions[$j]) {
              $correct = 1;
              array_splice($validOptions, $j, 1);
              break;
            }
          }
        }
        $answer = new Answer(-1, $_POST["answer".($i+1)], $transactionInfo[1], $i+1, $correct);
        addAnswer($answer);
      }

      // Imagen
      if (isset($_FILES["uploadedImage"]) and $_FILES["uploadedImage"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["uploadedImage"]["name"];
        $filetype = $_FILES["uploadedImage"]["type"];
        $filesize = $_FILES["uploadedImage"]["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowed)) {
          if (!file_exists("imatges_kahoot/".$filename)) {
            $path = "imatges_kahoot/".$filename;
            move_uploaded_file($_FILES["uploadedImage"]["tmp_name"], $path);
          } else {
            $filename = date("YmdHis".$_SESSION['userId']);
            $extension = array_search($filetype, $allowed);
            $path = "imatges_kahoot/".$filename.".".$extension;
            move_uploaded_file($_FILES["uploadedImage"]["tmp_name"], $path);
          }
          updateTextFieldFromTable("question", "image_path", $path, "question_id", $transactionInfo[1]);
        }
      }
      $_SESSION["alertMsg"] = "Pregunta añadida correctamente!";
      $_SESSION["alertType"] = "success";
    } else {
      $_SESSION["alertMsg"] = "Ha habido un error al añadir la pregunta.";
      $_SESSION["alertType"] = "danger";
    }
  }
}

// Array con las preguntas
$questions = getQuestions($_SESSION["kahoot_id"]);


// FUNCIONES

function getConnection() {
  $hostname = "localhost";
  $dbname = "kahoot";
  $username = "admin_kahoot";
  $pw = "P@ssw0rd";
  return new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8;", $username, $pw);
}

function generatePin() {
  $pins = array();
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT pin FROM kahoot");
  $query -> execute();
  while ($row = $query -> fetch()) {
    $pin = $row["pin"];
    array_push($pins, $pin);
  }
  $random_pin = rand(10000, 99999);
  if (in_array($random_pin, $pins)) {
    while (in_array($random_pin, $pins)) {
      $random_pin = rand(10000, 99999);
    }
  }
  return $random_pin;
}

function addKahoot($kahoot) {
  $pdo = getConnection();
  $query = $pdo->prepare("INSERT INTO kahoot (user_id, kahoot_name, pin, active, limit_users,start_game) VALUES (?, ?, ?, ?, ?, ?)");
  $query->bindParam(1, $kahoot->user_id);
  $query->bindParam(2, $kahoot->kahoot_name);
  $query->bindParam(3, $kahoot->pin);
  $query->bindParam(4, $kahoot->active);
  $query->bindParam(5, $kahoot->limit_users);
  $query->bindParam(6, $kahoot->start_game);
  $success = $query->execute();
  if ($success) {
    $return = array();
    array_push($return, $success);
    array_push($return, $pdo->lastInsertId());
    return $return;
  }
  return $success;
}

function getQuestions($kahoot_id) {
  $questions = array();
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT * FROM question WHERE kahoot_id=$kahoot_id");
  $query -> execute();
  while ($row = $query -> fetch()) {
    $question_id = $row["question_id"];
    $question_name = $row["question_name"];
    $kahoot_id = $row["kahoot_id"];
    $time = $row["time"];
    $orden = $row["orden"];
    $question_points = $row["question_points"];
    $image_path = $row["image_path"];
    $next = $row['next'];
    $question = new Question($question_id, $question_name, $kahoot_id, $time, $orden, $question_points, $image_path, $next);
    array_push($questions, $question);
  }
  return $questions;
}

function getAnswers($question_id) {
  $answers = array();
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT * FROM answer WHERE question_id=$question_id");
  $query -> execute();
  while ($row = $query -> fetch()) {
    $answer_id = $row["answer_id"];
    $answer_name = $row["answer_name"];
    $question_id = $row["question_id"];
    $orden = $row["orden"];
    $correct = $row["correct"];

    $answer = new Answer($answer_id, $answer_name, $question_id, $orden, $correct);
    array_push($answers, $answer);
  }
  return $answers;
}

function addQuestion($question) {
  try {
    $pdo = getConnection();
    $query = $pdo->prepare("INSERT INTO question (question_name, kahoot_id, time, orden, question_points, image_path, next) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $query->bindParam(1, $question->question_name);
    $query->bindParam(2, $question->kahoot_id);
    $query->bindParam(3, $question->time);
    $query->bindParam(4, $question->orden);
    $query->bindParam(5, $question->question_points);
    $query->bindParam(6, $question->image_path);
    $query->bindParam(7, $question->next);
    $success = $query->execute();
    if ($success) {
      $return = array();
      array_push($return, $success);
      array_push($return, $pdo->lastInsertId());
      // Devuelve un array con true o false (dependiendo de si se ha insertado o no) y el ID de la pregunta insertada
      return $return;
    }
  } catch (Exception $e){
    echo "Error: ".$e;
  }
  return $success;
}

function addAnswer($answer) {
  $pdo = getConnection();
  $query = $pdo->prepare("INSERT INTO answer (answer_name, question_id, orden, correct) VALUES (?, ?, ?, ?)");
  $query->bindParam(1, $answer->answer_name);
  $query->bindParam(2, $answer->question_id);
  $query->bindParam(3, $answer->orden);
  $query->bindParam(4, $answer->correct);
  $query->execute();
}

function updateTextFieldFromTable($table, $field, $newValue, $fieldID, $id) {
  $pdo = getConnection();
  $query = $pdo->prepare("UPDATE $table SET $field = '$newValue' WHERE $fieldID = $id");
  $query->execute();
}

function getAccountType($user_id) {
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT user_type FROM users WHERE user_id = $user_id");
  $query->execute();
  $row = $query->fetch();
  return $row['user_type'];
}

function getNumberOfKahoots($user_id) {
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT count(*) FROM kahoot WHERE user_id = $user_id");
  $query->execute();
  $row = $query->fetch();
  return $row["count(*)"];
}

function getNumberOfQuestions($kahoot_id) {
  $pdo = getConnection();
  $query = $pdo->prepare("SELECT count(*) FROM question WHERE kahoot_id = $kahoot_id");
  $query->execute();
  $row = $query->fetch();
  return $row["count(*)"];
}
 ?>
