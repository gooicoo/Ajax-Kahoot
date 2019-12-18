document.addEventListener("DOMContentLoaded",eventsInputs);

function eventsInputs(){
	var pruebaLista = document.getElementsByClassName('botones_kahoot');


	for (var i = 0; i < pruebaLista.length; i++) {
		pruebaLista[i].addEventListener("mouseover",mouseoverText);
		pruebaLista[i].addEventListener("mouseout",mouseoutText);
	}
}

function mouseoverText(e){
	e.target.value = e.target.id;
	e.target.style.fontFamily = 'Bungee';

	e.target.style.fontSize = 'x-large';
}

function mouseoutText(e){
	e.target.value = "";
}
