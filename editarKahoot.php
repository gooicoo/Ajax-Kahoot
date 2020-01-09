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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Añadir pregunta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        createCustomSelect();
        document.addEventListener("click", closeAllSelect);
        addOnTextAreaChange();
        addOnUpdateSliderValue("sliderTime", "timeValue");
        addOnUpdateSliderValue("sliderPoints", "pointsValue");
      });
    </script>
  </head>
  <body>
    <div class="main-container d-flex flex-column">
      <div class="nav-container">
        <div id="barra-menu">
          <div class="kahoot">
            <?php echo $_SESSION["titulo-kahoot"];?>
          </div>
          <div class="button-container">
            <button type="button" onclick="createKahoot()">MENÚ</button>
          </div>
        </div>
      </div>
      <div class="block-60"></div>
      <?php require("php/Alerts.php");?>
      <div class="d-flex flex-row">
        <aside>
          <div>
            <div>
              <div class="custom-select">
                <select id="types">
                  <option value="0">Selecciona un tipo de pregunta:</option>
                  <option value="TRUE/FALSE">Verdadero o falso</option>
                  <option value="MULTIPLE_CHOICE">Selección multiple</option>
                  <option value="FILL_GAPS">Rellenar huecos</option>
                </select>
              </div>
              <button type="button" onclick="changeQuestionForm()">NUEVA PREGUNTA</button>
            </div>
            <form method="POST" style="display: block;">
              <?php
              $queryQuestion = $pdo -> prepare(" SELECT * FROM question where kahoot_id=".$_SESSION['kahoot_id']."; ");
              $queryQuestion -> execute();
              $rowQuestion = $queryQuestion -> fetch();
              while ($rowQuestion) {
                echo "<div class='questionRow'><button class='buttonEditar' name='question' value='".$rowQuestion['question_id']."'>".$rowQuestion['question_name']."</button> <button name='eliminarQuestion' value='".$rowQuestion['question_id']."' type='sumbit' class='X'>X</button></div>";

                $rowQuestion = $queryQuestion->fetch();
              }
              ?>
            </form>
            <ul id="questions"></ul>
          </div>
        </aside>
        <main>
          <?php require 'php/creatorEditKahoot.php' ?>
          <div id="questionContainer">
            <textarea id="question_name" placeholder="Nombre de la pregunta" name="name" rows="8" cols="80"></textarea>
            <div class="d-flex flex-row">
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
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
