document.addEventListener("DOMContentLoaded", updateTime);

function updateTime() {
	var totalTime = document.getElementById('tiempo').innerHTML;
	if(totalTime==0){
		location.href="../juegoGamer/opcionSelec.php?tiempo=no";
	}else{
		totalTime-=1;
		document.getElementById('tiempo').innerHTML = totalTime;
		setTimeout("updateTime()",1000);
	}
}