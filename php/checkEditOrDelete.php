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
if (isset($_POST['eliminarQuestion'])) {
  $queryEliminarAnswer = $pdo -> prepare("DELETE FROM answer WHERE question_id=".$_POST['eliminarQuestion'].";");
  $queryEliminarAnswer -> execute();

  $queryEliminarQuestion = $pdo -> prepare("DELETE FROM question WHERE question_id=".$_POST['eliminarQuestion'].";");
  $queryEliminarQuestion -> execute();
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
?>