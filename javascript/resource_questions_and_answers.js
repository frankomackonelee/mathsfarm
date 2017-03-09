/**
 * @author Francis
 */
function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

function refreshWithNewQuestions(){
	updateQuestionsAndAnswers();
}

function updateQuestionsAndAnswers(){
		var questionObj = new QuestionObj();
		var text = "<table><tr><th>Questions</th><th>Answers</th></tr>";	   
    	for(i = 0; i < questionObj.questions.length; i++) {
	        text += "<tr><td class='questionColumn'>" + questionObj.questions[i] + "</td><td class='hiddenAnswer concealed'>" + questionObj.answers[i] + "</td></tr>";
	    } 
	    text += "</table>";
	    document.getElementById("panel").innerHTML = text;
}

function clickOnAnAnswer(box, i){
			box.onclick = function(){
				box.classList.remove("concealed");
			};
}

function init()
{	
	updateQuestionsAndAnswers();
	
	var hiddenAnswers = document.getElementsByClassName("hiddenAnswer");
	forEach(hiddenAnswers, clickOnAnAnswer);
}

document.addEventListener("DOMContentLoaded", init, false);