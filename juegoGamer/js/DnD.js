var dragSrcEl = null;
var rows = null;
var text = "";

function handleDragStart(e) {
  // Target (this) element is the source node.
  //this.style.opacity = '0.4';

  dragSrcEl = this;
  text = this.innerText;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
  this.classList.add('over');
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same rowumn we're dragging.
  if (dragSrcEl != this) {
    // Set the source rowumn's HTML to the HTML of the rowumnwe dropped on.
    dragSrcEl.innerHTML = this.innerHTML;
    dragSrcEl.nextElementSibling.value = dragSrcEl.innerHTML;
    if (e.dataTransfer !== null) {
      this.innerHTML = e.dataTransfer.getData('text/html');
    } else {
      this.innerHTML = text;
    }
    this.nextElementSibling.value = this.innerHTML;
  }

  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.

  [].forEach.call(rows, function (row) {
    row.classList.remove('over');
  });
}


document.addEventListener("DOMContentLoaded", function(event) {
  rows = document.querySelectorAll('form > div.respuestas > .form-p');
  [].forEach.call(rows, function(row) {
    row.addEventListener('dragstart', handleDragStart, false);
    row.addEventListener('dragenter', handleDragEnter, false)
    row.addEventListener('dragover', handleDragOver, false);
    row.addEventListener('dragleave', handleDragLeave, false);
    row.addEventListener('drop', handleDrop, false);
    row.addEventListener('dragend', handleDragEnd, false);
  });
});
