<?php  
  if (isset($_POST['question'])) {
    $queryQuestionEdit = $pdo -> prepare("SELECT * FROM question where question_id=".$_POST['question']."; ");
    $queryQuestionEdit -> execute();
    $rowQuestionEdit = $queryQuestionEdit -> fetch();
    $question_type = $rowQuestionEdit["question_type"];
    echo '<div id="questionContainer2" style="display: block;">';
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
      if ($question_type == "TRUE/FALSE") {
        if ($rowAnswerEdit['correct']==1) {
          echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="gender" id="checkbox'.$contador.'" type="radio" checked><label for="checkbox'.$contador.'"></label></div></li>';
        }else{
          echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="gender" id="checkbox'.$contador.'" type="radio"><label for="checkbox'.$contador.'"></label></div></li>';
        }
      }
      else if ($question_type == "MULTIPLE_CHOICE") {
        if ($rowAnswerEdit['correct']==1) {
          echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="checked'.$contador.'" class="checkbox" id="checkbox'.$contador.'" type="checkbox" checked><label for="checkbox'.$contador.'"></label></div></li>';
        }else{
          echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"><div class="round"><input name="checked'.$contador.'" class="checkbox" id="checkbox'.$contador.'" type="checkbox" ><label for="checkbox'.$contador.'"></label></div></li>';
        }
      }
      else if ($question_type == "FILL_GAPS") {
        echo '<li><input id="inputAnswer'.$contador.'" value="'.$rowAnswerEdit["answer_name"].'" type="text" name="answerName'.$contador.'"></li>';
      }

      $contador++;
      $rowAnswerEdit = $queryAnswerEdit -> fetch();
    }
    echo '<div class="sliders" style="margin-top:40px;">
              <div class="slidecontainer">
                <p class="description">Tiempo (s)</p>
                <p id="timeValueEdit" class="values"></p>
                <input min="1" max="60" value="'.$rowQuestionEdit['time'].'" class="slider" id="sliderTimeEdit" name="time" type="range">
              </div>
              <div class="slidecontainer" ;>
                <p class="description">Puntuación</p>
                <p id="pointsValueEdit" class="values">1000</p>
                <input min="0" max="2000" value='.$rowQuestionEdit['question_points'].' class="slider" id="sliderPointsEdit" name="points" type="range">
                </div>
            </div>';
    echo "<button class='btnO' name='editOn' value='on' type='sumbit' style='color: white;'>MODIFICAR</button>";
    echo "<button class='btnOff' name='editOff' value='off' style='color: white;'>CANCELAR</button>";
    echo '</form>';
    echo "</div>";
    echo "<script>onCreateEditQuestionForm();</script>";
  }
?>