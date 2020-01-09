function addQuestions(questions) {
  for (var i = 0; i < questions.length; i++) {
    var question = questions[i];
    createNewQuestion(question.question_name, ["question_id="+question.question_id]);
  }
}

function createQuestionForm(answersCount) {
  var container = document.getElementById("answers");
  var type = getQuestionType();
  for (var i = 0; i < answersCount; i++) {
    if (type == "TRUE/FALSE") {
      var li = createElementDOM("li", "", container, []);
      var value = (i == 0) ? "Verdadero" : "Falso";
      createElementDOM("input", "", li, ["type=text", "id=inputAnswer"+(i+1), "value="+value, "readonly=", "style=pointer-events: none;"]);
      var round = createElementDOM("div", "", li, ["class=round"]);
      var input = createElementDOM("input", "", round, ["type=radio", "id=radio"+(i+1), "name=gender"]);
      if (i == 0) {
        input.checked = true;
      }
      var label = createElementDOM("label", "", round, ["for=radio"+(i+1)]);
    }
    else if (type == "MULTIPLE_CHOICE") {
      var li = createElementDOM("li", "", container, []);
      createElementDOM("input", "", li, ["type=text", "id=inputAnswer"+(i+1), "placeholder=Respuesta "+(i+1)]);
      var round = createElementDOM("div", "", li, ["class=round"]);
      var input = createElementDOM("input", "", round, ["class=checkbox", "type=checkbox", "id=checkbox"+(i+1)]);
      var label = createElementDOM("label", "", round, ["for=checkbox"+(i+1)]);
    }
    else if (type == "FILL_GAPS") {
      var li = createElementDOM("li", "", container, []);
      createElementDOM("input", "", li, ["type=text", "id=inputAnswer"+(i+1), "placeholder=Espacio por rellenar "+(i+1)]);
    }
    // ... los demás tipos de pregunta
  }

  var main = document.getElementsByTagName("main")[0];
  var questionContainer = document.getElementById("questionContainer");
  questionContainer.setAttribute("qtype", type);
  var containerImg = createElementDOM("div", "", questionContainer, ["id=containerImg"]);
  var preview = createElementDOM("img", "", containerImg, ["src=https://cdn4.iconfinder.com/data/icons/flatified/128/photos.png","id=preview"]);
  var loadImage = createElementDOM("button", "Cargar imagen", containerImg, ["type=button"]);
  loadImage.addEventListener('click', function() {
    var browse = document.getElementsByName("uploadedImage")[0];
    browse.click();
  });

  var form = createElementDOM("form", "", main, ["method=post", "id=sendQuestion", "enctype=multipart/form-data"]);
  createElementDOM("input", "", form, ["type=text", "name=questionName"]);
  for (var i = 0; i < answersCount; i++) {
    createElementDOM("input", "", form, ["type=text", "name=answer"+(i+1)]);
  }
  createElementDOM("input", "", form, ["type=text", "name=questionTime"]);
  createElementDOM("input", "", form, ["type=text", "name=questionOrder"]);
  createElementDOM("input", "", form, ["type=text", "name=questionPoints"]);
  createElementDOM("input", "", form, ["type=text", "name=validOptions"]);
  createElementDOM("input", "", form, ["type=text", "name=questionType"]);
  createElementDOM("input", "", form, ["type=text", "name=numberAnswers"]);

  var uploadedImage = createElementDOM("input", "", form, ["type=file", "name=uploadedImage"]);
  uploadedImage.addEventListener("change", function() {
    uploadImage(this);
  });
  createElementDOM("input", "", form, ["type=submit"]);

  var right = document.getElementsByClassName("right")[0];
  createElementDOM("button", "AÑADIR", right, ["id=buttonAddQuestion", "onclick=validateNewQuestion()"]);

  // Fix visual
  document.getElementsByTagName("html")[0].setAttribute("style", "height: inherit;");
  document.getElementsByTagName("body")[0].setAttribute("style", "height: inherit;");

  var questionForm = document.getElementById("questionContainer");
  questionForm.setAttribute("style", "display: block;");
}

function createNewQuestion(name, attributes) {
  var container = document.getElementById("questions");
  var li = createElementDOM("li", "", container, []);
  var p = createElementDOM("p", name, li, attributes);
}


function removeAllElements(a){
  a.remove();
}

function changeQuestionForm() {
  if (document.getElementById('questionContainer2')!= null) {
    removeAllElements(document.getElementById('questionContainer2'));
  }
  var type = getQuestionType();
  if (type == 0) {
    alert("Selecciona un tipo de pregunta!!");
  } else {
    var answers = document.getElementById("answers").getElementsByTagName("li");
    var confirmed = true;
    if (answers.length > 0) {
      confirmed = confirm("Si creas una nueva pregunta, eliminarás la actual. \nSeguro que quieres continuar?");
      if (confirmed) {
        cleanQuestionForm();
      }
      // Fix visual
      document.getElementsByTagName("html")[0].setAttribute("style", "height: 100%;");
      document.getElementsByTagName("body")[0].setAttribute("style", "height: 100%;");
    }
    if (confirmed) {
      if (type == "TRUE/FALSE") {
        createQuestionForm(2);
        createNewQuestion("Nueva pregunta", ["class=newQuestion", "style=border-color: red; word-wrap: break-word;"]);
      }
      else if (type == "MULTIPLE_CHOICE") {
        var numberAnswers = prompt("Cuantas posibles respuestas tendrá esta pregunta?");
        if (numberAnswers != null && numberAnswers != "") {
          if (!isNaN(numberAnswers)) {
            var integerValue = parseInt(numberAnswers);
            if (integerValue > 0) {
              createQuestionForm(integerValue);
              createNewQuestion("Nueva pregunta", ["class=newQuestion", "style=border-color: red; word-wrap: break-word;"]);
            } else {
              alert("Introduce un número de respuestas válido!");
            }
          } else {
            alert("Introduce un número de respuestas válido!");
          }
        } else {
          alert("Introduce un número de respuestas para poder crear la pregunta!");
        }
      }
      else if (type == "FILL_GAPS") {
        var sentence = prompt("Escribe una frase con espacios por rellenar.\nEj: Hoy es _ _ de _, hace un día _");
        if (sentence.includes("_")) {
          var numberAnswers = sentence.split('_').length - 1;
          createQuestionForm(numberAnswers);
          createNewQuestion("Nueva pregunta", ["class=newQuestion", "style=border-color: red; word-wrap: break-word;"]);
          var textarea = document.getElementById("question_name");
          textarea.removeAttribute("placeholder");
          textarea.setAttribute("readonly", "");
          textarea.value = sentence;
        } else {
          alert("Esta frase no tiene espacios para rellenar. Escribe una frase con el formato correcto.");
        }
      }
      // ... los demás tipos de pregunta
    }
  }
}

function cleanQuestionForm() {
  var answers = document.getElementById("answers").getElementsByTagName("li");
  var answersLength = answers.length;
  for (var i = 0; i < answersLength; i++) {
    removeElementDOM(answers[0]);
  }
  var form = document.getElementById("sendQuestion");
  removeElementDOM(form);
  var addButton = document.getElementById("buttonAddQuestion");
  removeElementDOM(addButton);
  var containerImg = document.getElementById("containerImg");
  removeElementDOM(containerImg);
  var textArea = document.getElementById("question_name");
  textArea.value = "";
  textArea.removeAttribute("readonly");
  textArea.setAttribute("placeholder", "Nombre de la pregunta");
  var sliderTime = document.getElementById("sliderTime");
  sliderTime.value = 20;
  var sliderPoints = document.getElementById("sliderPoints");
  sliderPoints.value = 1000;
  var timeValue = document.getElementById("timeValue");
  timeValue.innerText = "20";
  var pointsValue = document.getElementById("pointsValue");
  pointsValue.innerText = "1000";
  var lastNewQuestion = document.getElementsByClassName("newQuestion")[0];
  removeElementDOM(lastNewQuestion.parentNode);
  var questionContainer = document.getElementById("questionContainer");
  questionContainer.setAttribute("style", "display: none;");
}

function getQuestionType() {
  var select = document.getElementById("types");
  var value = select.options[select.selectedIndex].value;
  return value;
}

function validateNewQuestion() {
  var answersCount = document.getElementById("answers").getElementsByTagName("li").length;
  var questionOrder = document.getElementById("questions").getElementsByTagName("li").length;

  var altOrder = document.getElementsByClassName("questionRow").length;
  if (altOrder > 0) {
    questionOrder = altOrder+1;
  }

  var textArea = document.getElementById("question_name");

  var answersFilled = true;
  for (var i = 0; i < answersCount; i++) {
    var answer = document.getElementById("inputAnswer"+(i+1));
    if (answer.value == "") {
      answersFilled = false;
      break;
    }
  }

  if (textArea.value != "" && answersFilled) {
    var data = [];
    var form = document.getElementById("sendQuestion");

    var question_name = document.getElementById("question_name").value;
    data.push(question_name);
    for (var i = 0; i < answersCount; i++) {
      var answer = document.getElementById("inputAnswer"+(i+1)).value;
      data.push(answer);
    }

    var time = document.getElementById("sliderTime").value;
    data.push(time);

    data.push(questionOrder);

    var points = document.getElementById("sliderPoints").value;
    data.push(points);

    var type = document.getElementById("questionContainer").getAttribute("qtype");
    if (type == "MULTIPLE_CHOICE") {
      var checkboxes = document.getElementsByClassName("checkbox");
      var checked = getCheckedAnswers(checkboxes);
      data.push(checked);
    } else {
      var radioButtons = document.getElementsByName("gender");
      var checked = getCheckedAnswers(radioButtons);
      data.push(checked);
    }

    data.push(type);
    data.push(answersCount);

    var inputs = form.getElementsByTagName("input");
    for (var i = 0; i < data.length; i++) {
      inputs[i].value = data[i];
    }

    form.submit();
  } else {
    alert("Faltan campos por rellenar!");
  }
}

function getCheckedAnswers(elements) {
  var checked = "";
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].checked) {
      checked += (i+1)+",";
    }
  }
  if (checked.length > 0) {
    checked = checked.substr(0, checked.length-1);
  }
  return checked;
}

function createKahoot() {
  // Cambiar de página
  var url = window.location.href;
  url.split("creator.php");
  var host = url.split("/")[0];
  window.location.href = host+"login_singIn/loginCorrect.php";
}

function uploadImage(input) {
  var reader;

  if (input.files && input.files[0]) {
    reader = new FileReader();

    reader.onload = function(e) {
      var img = document.getElementById("preview");
      img.setAttribute('src', e.target.result);
      img.setAttribute('style', 'width: 100%;')
    }

    reader.readAsDataURL(input.files[0]);
  }
}

function createElementDOM(tagElement, text, parent, attributes) {
  var element = document.createElement(tagElement);
  if (text.length > 0) {
    var textElement = document.createTextNode(text);
    element.appendChild(textElement);
  }
  if (attributes.length > 0) {
    for (var i = 0; i < attributes.length; i++) {
      var attr = attributes[i].split("=")[0];
      var value = attributes[i].split("=")[1];
      element.setAttribute(attr, value);
    }
  }
  var appendedElement = parent.appendChild(element);
  return appendedElement;
}

function removeElementDOM(element){
  element.parentNode.removeChild(element);
}

function addOnTextAreaChange() {
  var area = document.getElementById("question_name");
  if (area.addEventListener) {
    area.addEventListener('input', function() {
      // event handling code for sane browsers
      var countNewQuestions = document.getElementsByClassName("newQuestion").length;
      var lastNewQuestion = document.getElementsByClassName("newQuestion")[countNewQuestions-1];
      if (area.value == "") {
        lastNewQuestion.innerText = "Nueva pregunta";
      } else {
        lastNewQuestion.innerText = area.value;
      }
    }, false);
  } else if (area.attachEvent) {
    area.attachEvent('onpropertychange', function() {
      // IE-specific event handling code
      var countNewQuestions = document.getElementsByClassName("newQuestion").length;
      var lastNewQuestion = document.getElementsByClassName("newQuestion")[countNewQuestions-1];
      if (area.value == "") {
        lastNewQuestion.innerText = "Nueva pregunta";
      } else {
        lastNewQuestion.innerText = area.value;
      }
    });
  }
}

function addOnUpdateSliderValue(sliderID, outputID) {
  var slider = document.getElementById(sliderID);
  var output = document.getElementById(outputID);
  output.innerHTML = slider.value; // Display the default slider value

  // Update the current slider value (each time you drag the slider handle)
  slider.oninput = function() {
    output.innerHTML = this.value;
  }
}

function createCustomSelect() {
  var x, i, j, selElmnt, a, b, c;
  /* Look for any elements with the class "custom-select": */
  x = document.getElementsByClassName("custom-select");
  for (i = 0; i < x.length; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    /* For each element, create a new DIV that will act as the selected item: */
    a = document.createElement("div");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /* For each element, create a new DIV that will contain the option list: */
    b = document.createElement("div");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < selElmnt.length; j++) {
      /* For each option in the original select element,
      create a new DIV that will act as an option item: */
      c = document.createElement("div");
      c.innerHTML = selElmnt.options[j].innerHTML;
      c.addEventListener("click", function(e) {
          /* When an item is clicked, update the original select box,
          and the selected item: */
          var y, i, k, s, h;
          s = this.parentNode.parentNode.getElementsByTagName("select")[0];
          h = this.parentNode.previousSibling;
          for (i = 0; i < s.length; i++) {
            if (s.options[i].innerHTML == this.innerHTML) {
              s.selectedIndex = i;
              h.innerHTML = this.innerHTML;
              y = this.parentNode.getElementsByClassName("same-as-selected");
              for (k = 0; k < y.length; k++) {
                y[k].removeAttribute("class");
              }
              this.setAttribute("class", "same-as-selected");
              break;
            }
          }
          h.click();
      });
      b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
      /* When the select box is clicked, close any other select boxes,
      and open/close the current select box: */
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
  }
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

function onCreateEditQuestionForm() {
  addOnUpdateSliderValue('sliderTimeEdit', 'timeValueEdit');
  addOnUpdateSliderValue('sliderPointsEdit', 'pointsValueEdit');
  document.getElementsByTagName('main')[0].setAttribute('style', 'width: 70%;');
}
