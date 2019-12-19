<?php
  session_start();
  include("php/Creator.php");
  try {
    $hostname = "localhost";
    $dbname = "kahoot";
    $username = "admin_kahoot";
    $pw = "P@ssw0rd";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to POST DB handle: " . $e->POSTMessage() . "\n";
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
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <title>Añadir pregunta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        var response = <?php echo json_encode(['questions_list' => $questions]); ?>;
        var questions = response.questions_list;
        addQuestions(questions);
        createCustomSelect();
        document.addEventListener("click", closeAllSelect);
        addOnTextAreaChange();
        addOnUpdateSliderValue("sliderTime", "timeValue");
        addOnUpdateSliderValue("sliderPoints", "pointsValue");
        addOnUpdateSliderValue("sliderTime2", "timeValue2");
        addOnUpdateSliderValue("sliderPoints2", "pointsValue2");
      });
    </script>
  </head>
  <body class="clearfix">
    <div id="barra-menu">
      <div class="kahoot">
        <?php echo $_SESSION["titulo-kahoot"];?>
      </div>
      <div class="button-container">
        <button type="button" onclick="createKahoot()">INICIO</button>
      </div>
    </div>
    <aside>
      <div>
        <div>
          <button type="button" onclick="changeQuestionForm()">NUEVA PREGUNTA</button>
          <div class="custom-select">
            <select id="types">
              <option value="0">Selecciona un tipo de pregunta:</option>
              <option value="TRUE/FALSE">Verdadero o falso</option>
              <option value="MULTIPLE_CHOICE">Selección multiple</option>
            </select>
          </div>
        </div>
        <ul id="questions" class="clearfix" style="display: none;"></ul>
        <form method="POST" style="display: block;">
          <?php
            $queryQuestion = $pdo -> prepare(" SELECT * FROM question where kahoot_id=".$_SESSION['kahoot_id']."; ");
            $queryQuestion -> execute();
            $rowQuestion = $queryQuestion -> fetch();
            while ($rowQuestion) {
              echo "<button class='buttonEditar' name='question' value='".$rowQuestion['question_id']."'>".$rowQuestion['question_name']."</button> <button name='eliminarQuestion' value='".$rowQuestion['question_id']."' type='sumbit' class='X'>X</button> <br>";
             
              $rowQuestion = $queryQuestion->fetch();
            }
          ?>
        

        </form>
      </div>
    </aside>
    <main>
      <?php  
        if (isset($_POST['question'])) {
          $queryQuestionEdit = $pdo -> prepare("SELECT * FROM question where question_id=".$_POST['question']."; ");
          $queryQuestionEdit -> execute();
          $rowQuestionEdit = $queryQuestionEdit -> fetch();
          echo '<div id="questionContainer2" class="clearfix" style="display: block;">';
          echo '<form method="POST" style="display: block;">';
          echo "<p id=nombreP>Nombre pregunta</p>";
          echo '<input type="text" id="question_name" value="'.$rowQuestionEdit['question_name'].'" name="questionName" rows="8" cols="80"></input>';
          echo '<input type="hidden" name="questionId" value="'.$rowQuestionEdit['question_id'].'"/>';
          echo '<ul id="answers" style="width: 100%;">';
          $queryAnswerEdit = $pdo -> prepare("SELECT * FROM answer where question_id=".$_POST['question']."; ");
          $queryAnswerEdit -> execute();
          $rowAnswerEdit = $queryAnswerEdit -> fetch();
          $contador = 1;
          echo "<p id=nombreP>Respuestas</p>";
          while ($rowAnswerEdit) {
            echo '<input id="prodId" name="answerId" type="hidden" value='.$rowAnswerEdit["answer_id"].'>';
            if ($rowAnswerEdit['correct']==1) {
              echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="checked'.$contador.'" class="checkbox" id="checkbox'.$contador.'" type="checkbox" checked><label for="checkbox'.$contador.'"></label></div></li>';
            }else{
              echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="checked'.$contador.'" class="checkbox" id="checkbox'.$contador.'" type="checkbox" ><label for="checkbox'.$contador.'"></label></div></li>';
            }
            
            $contador++;
            $rowAnswerEdit = $queryAnswerEdit -> fetch();
          }
          echo '<div class="sliders" style="margin-top:40px;">
                    <div class="slidecontainer">
                      <p class="description">Tiempo (s)</p>
                      <p id="timeValue2" class="values"></p>
                      <input min="1" max="60" value="'.$rowQuestionEdit['time'].'" class="slider" id="sliderTime2" name="time" type="range">
                    </div>
                    <div class="slidecontainer" ;>
                      <p class="description">Puntuación</p>
                      <p id="pointsValue2" class="values">1000</p>
                      <input min="0" max="2000" value='.$rowQuestionEdit['question_points'].' class="slider" id="sliderPoints2" name="points" type="range">
                      </div>
                  </div>';
          echo "<button class='btnO' name='editOn' value='on' type='sumbit' style='color: white;'>MODIFICAR</button>";
          echo "<button class='btnOff' name='editOff' value='off' style='color: white;'>CANCELAR</button>";
          echo '</form>';
          echo "</div>";
        }
      ?>
      <div id="questionContainer" class="clearfix">
        <textarea id="question_name" placeholder="Nombre de la pregunta" name="name" rows="8" cols="80"></textarea>
        <ul id="answers"></ul>
        <div class="right">
          <div class="sliders">
            <div class="slidecontainer">
              <p class="description">Tiempo (s)</p>
              <p id="timeValue" class="values"></p>
              <input type="range" min="1" max="60" value="20" class="slider" id="sliderTime">
            </div>
            <div class="slidecontainer">
              <p class="description">Puntuación</p>
              <p id="pointsValue" class="values"></p>
              <input type="range" min="0" max="2000" value="1000" class="slider" id="sliderPoints">
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>