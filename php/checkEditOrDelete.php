<?php
try {
 $hostname = "localhost";
 $dbname = "kahoot";
 $username = "admin_kahoot";
 $pw = "P@ssw0rd";
 $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname;charset=utf8;","$username","$pw");
 } catch (PDOException $e) {
   echo "Failed to get DB handle: " . $e->getMessage() . "\n";
   exit;
}
if (isset($_POST['eliminarQuestion'])) {
  $queryGetKahoot = $pdo -> prepare("SELECT * FROM question WHERE question_id=".$_POST['eliminarQuestion'].";");
  $queryGetKahoot -> execute();
  $rowKahoot = $queryGetKahoot -> fetch();

  $queryEliminarAnswer = $pdo -> prepare("DELETE FROM answer WHERE question_id=".$_POST['eliminarQuestion'].";");
  $queryEliminarAnswer -> execute();

  $queryEliminarQuestion = $pdo -> prepare("DELETE FROM question WHERE question_id=".$_POST['eliminarQuestion'].";");
  $queryEliminarQuestion -> execute();

  $queryGetQuestions = $pdo -> prepare("SELECT * FROM question WHERE kahoot_id=".$rowKahoot['kahoot_id'].";"); 
  $contador = 1;
  $queryGetQuestions -> execute();
  $rowQuestion = $queryGetQuestions -> fetch();
  while ($rowQuestion) {
    $queryAnswersUpdate = $pdo -> prepare("UPDATE question SET orden=".$contador." WHERE question_id=".$rowQuestion['question_id'].";");
    $queryAnswersUpdate -> execute();
    $contador++;
    $rowQuestion = $queryGetQuestions -> fetch();
  }
  header("Location: editarKahoot.php");
}elseif(isset($_POST['editOn']) and isset($_POST['questionId'])) {
  $questionId = $_POST['questionId'];
  $contador = 1;
  $queryAnswers = $pdo -> prepare(" SELECT * FROM answer where question_id=".$questionId."; ");
  $queryAnswers -> execute();
  $rowAnswers = $queryAnswers -> fetch();

  while ($rowAnswers) {
    if (isset($_POST['checked'.$contador])) {

      $queryAnswersUpdate = $pdo -> prepare("UPDATE answer SET answer_name='".$_POST['answerName'.$contador]."',correct=1 WHERE orden=".$contador." and question_id=".$questionId.";");
      $queryAnswersUpdate -> execute();
    }else{
      $queryAnswersUpdate = $pdo -> prepare("UPDATE answer SET answer_name='".$_POST['answerName'.$contador]."',correct=0 WHERE orden=".$contador." and question_id=".$questionId.";");
      $queryAnswersUpdate -> execute();
    }
    $contador++;
    $rowAnswers = $queryAnswers -> fetch();
  }
  $queryQuestionUpdate = $pdo -> prepare(" UPDATE question SET question_name='".$_POST['questionName']."', time=".$_POST['time'].",question_points=".$_POST['points']." where question_id=".$questionId."; ");
  $queryQuestionUpdate -> execute();
  }

  if (isset($_POST['gender'])) {
    if ($_POST['gender']==1) {
      $queryAnswersGender = $pdo -> prepare("UPDATE answer SET correct=1 WHERE orden=1 and question_id=".$questionId.";");
       $queryAnswersGender -> execute();
      $queryAnswersUpdate1 = $pdo -> prepare("UPDATE answer SET correct=0 WHERE orden=2 and question_id=".$questionId.";");
      $queryAnswersUpdate1 -> execute();
    }elseif ($_POST['gender']==2) {
      $queryAnswersGender = $pdo -> prepare("UPDATE answer SET correct=0 WHERE orden=1 and question_id=".$questionId.";");
       $queryAnswersGender -> execute();
      $queryAnswersUpdate1 = $pdo -> prepare("UPDATE answer SET correct=1 WHERE orden=2 and question_id=".$questionId.";");
      $queryAnswersUpdate1 -> execute();
    }
  }
?>