<?php
  session_start();
  include("php/Creator.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
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
      });
    </script>
  </head>
  <body class="clearfix">
    <div id="barra-menu">
			<div class="kahoot">
				<?php echo $_SESSION["titulo-kahoot"];?>
			</div>
      <div class="button-container">
        <button type="button" onclick="createKahoot()">CREAR</button>
      </div>
		</div>
    <aside>
      <div>
        <div>
          <button type="button" onclick="changeQuestionForm()">NUEVO</button>
          <div class="custom-select">
            <select id="types">
              <option value="0">Selecciona un tipo de pregunta:</option>
              <option value="TRUE/FALSE">Verdadero o falso</option>
              <option value="MULTIPLE_CHOICE">Selección multiple</option>
            </select>
          </div>
        </div>
        <ul id="questions" class="clearfix"></ul>
      </div>
    </aside>
    <main>
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
