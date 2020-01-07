<?php
  session_start();
  include("php/Creator.php");
  include("php/checkEditOrDelete.php");
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
        addOnUpdateSliderValue("sliderTimeEdit", "timeValueEdit");
        addOnUpdateSliderValue("sliderPointsEdit", "pointsValueEdit");
      });
    </script>
  </head>
  <body class="clearfix">
    <div id="barra-menu">
      <div class="kahoot">
        <?php echo $_SESSION["titulo-kahoot"];?>
      </div>
      <div class="button-container">
        <button type="button" onclick="createKahoot()">MENÚ</button>
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
    <?php require 'php/creatorEditKahoot.php' ?>
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