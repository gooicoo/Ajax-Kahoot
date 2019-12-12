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
    }
    // ... los demás tipos de pregunta

    var round = createElementDOM("div", "", li, ["class=round"]);
    var input = createElementDOM("input", "", round, ["type=radio", "id=radio"+(i+1), "name=gender"]);
    if (i == 0) {
      input.checked = true;
    }
    var label = createElementDOM("label", "", round, ["for=radio"+(i+1)]);
  }

  var main = document.getElementsByTagName("main")[0];
  var questionContainer = document.getElementById("questionContainer");
  var containerImg = createElementDOM("div", "", questionContainer, ["id=containerImg"]);
  var preview = createElementDOM("img", "", containerImg, ["src=https://cdn4.iconfinder.com/data/icons/flatified/128/photos.png","id=preview"]);
  var loadImage = createElementDOM("button", "Cargar imagen", containerImg, ["type=button"]);
  loadImage.addEventListener('click', function() {
    var browse = document.getElementsByName("uploadedImage")[0];
    browse.click();
  });

  var form = createElementDOM("form", "", main, ["action=creator.php", "method=post", "id=sendQuestion", "enctype=multipart/form-data"]);
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

  var questionForm = document.getElementById("questionContainer");
  questionForm.setAttribute("style", "display: block;");
}

function createNewQuestion(name, attributes) {
  var container = document.getElementById("questions");
  var li = createElementDOM("li", "", container, ["class=clearfix"]);
  var p = createElementDOM("p", name, li, attributes);
  createElementDOM("button", "X", li, []);
}

function changeQuestionForm() {
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
    } else {
      createNewQuestion("Nueva pregunta", ["class=newQuestion", "style=border-color: red; word-wrap: break-word;"]);
    }
    if (confirmed) {
      if (type == "TRUE/FALSE") {
        createQuestionForm(2);
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
  var sliderTime = document.getElementById("sliderTime");
  sliderTime.value = 20;
  var sliderPoints = document.getElementById("sliderPoints");
  sliderPoints.value = 1000;
  var timeValue = document.getElementById("timeValue");
  timeValue.innerText = "20";
  var pointsValue = document.getElementById("pointsValue");
  pointsValue.innerText = "1000";
  var lastNewQuestion = document.getElementsByClassName("newQuestion")[0];
  lastNewQuestion.innerText = "Nueva pregunta";
}

function getQuestionType() {
  var select = document.getElementById("types");
  var value = select.options[select.selectedIndex].value;
  return value;
}

function validateNewQuestion() {
  var answersCount = document.getElementById("answers").getElementsByTagName("li").length;
  var questionOrder = document.getElementById("questions").getElementsByTagName("li").length;
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

    var radioButtons = document.getElementsByName("gender");
    var selected = "";
    for (var i = 0; i < radioButtons.length; i++) {
      if (radioButtons[i].checked) {
        selected += (i+1)+",";
      }
    }
    if (selected.length > 0) {
      selected = selected.substr(0, selected.length-1);
    }
    data.push(selected);

    var type = getQuestionType();
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

function createKahoot() {
  // Cambiar de página
  var url = window.location.href;
  window.location.href = url.split("/")[0]+"/Ajax-Kahoot/login_singIn/loginCorrect.php";
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
