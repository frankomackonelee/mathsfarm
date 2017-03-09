function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function randomisedIntegers(last){
	var rand = new Array();
	for (var i=0; i < last + 1; i++) {
		rand[i] = i;
	};
	var newPosition;
	var tempStore;
	for (var i=0; i < last + 1; i++) {
		newPosition = Math.floor(Math.random() * last);
		tempStore = rand[i];
		rand[i] = rand[newPosition];
		rand[newPosition] = tempStore;
	};
	return rand;
}

function randomLetter(){
	var rand = Math.random()*26;
	var rv = Math.floor(rand);
	rv += 65;
	return String.fromCharCode(rv);
}

function makeSpaceForWord(phrase){
	
}

function clickResponse(){
	var phrase = document.getElementById("key_phrase").value;
	phraseNoSpace = phrase.replace(/\s+/g, '');
	var charArray = phraseNoSpace.split("");
	var letter;
	var limit = parseInt(readCookie("questionCount"));
	var randomised = randomisedIntegers(limit);
	var text = "<tr><th>Questions</th><th>Letter</th><th>Answers</th></tr>";
	for(i = 0; i < limit + 1; i++) {
		if (typeof charArray[randomised[i]] !== 'undefined') {
			letter = charArray[randomised[i]];
		}else{
			letter = randomLetter();
		};
        text += "<tr><td>" + readCookie("question" + i) + "'</td><td>" + letter + "</td><td>" + readCookie("answer" + randomised[i]) + "'</td></tr>";
    }
    document.getElementById("tablecontents").innerHTML = text;
}

function init(){
	var button = document.getElementById("myButton");
	button.onclick = clickResponse;
}

document.addEventListener("DOMContentLoaded",init,false);
