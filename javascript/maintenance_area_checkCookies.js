

function init(){
	document.getElementById("deleteCookies").onclick = function(){
		cJ = new CookieJar();
		cJ.removeQuestionsAndAnswers();
	};
	cookieJar = document.getElementById("cookieJar");
	cookieJar.innerHTML += "Will put cookies here <br>";
	cookieJar.innerHTML += "Here's what they say: <br>";
	cookieJar.innerHTML += "topic: " + readCookie("topic") + "<br>";
	cookieJar.innerHTML += "subtopic: " + readCookie("subtopic") + "<br>";
	cookieJar.innerHTML += "level: " + readCookie("level") + "<br>";
	cookieJar.innerHTML += "quesitonCount: " + readCookie("questionCount") + "<br>";
	var arrCookies = document.cookie.split(";");
	cookieJar.innerHTML += "the contents of cookies: <br>";
	for (var i=0; i < arrCookies.length; i++) {
	  cookieJar.innerHTML += arrCookies[i] + "<br>";
	};
}

document.addEventListener("DOMContentLoaded",init,false);
