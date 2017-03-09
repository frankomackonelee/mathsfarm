


function clickResponse(){
	var firstName = document.getElementById("firstName").value;
	var lastName = document.getElementById("lastName").value;
	document.cookie = "firstName=" + firstName + "; path=/" ;
	document.cookie = "lastName="+ lastName + "; path=/" ;
	alert("Cookies Updated");
}

function init(){
	var button = document.getElementById("myButton");
	button.onclick = clickResponse;
}

document.addEventListener("DOMContentLoaded",init,false);
