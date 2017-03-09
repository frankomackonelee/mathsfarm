/**
 * @author Francis
 */
function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

var questionObj;
var QuestionNumber = 0;

function postQuestionNumber (questionNumber) {
	document.getElementById("questionBox").innerText = questionObj.questions[questionNumber];
	document.getElementById("answerBox").innerText = questionObj.answers[questionNumber];
	document.getElementById("questionNumber").innerText = "Question " + (QuestionNumber + 1);
}

function makeAnswerInvisible (invisible){
	if(invisible){
		//make it invisible
		document.getElementById("answerBox").classList.add("invisibleText");
		document.getElementById("showAnswer").innerText = "Show Answer";}
	else{
		//make it visible	
		document.getElementById("answerBox").classList.remove("invisibleText");
		document.getElementById("showAnswer").innerText = "Hide Answer";}
}

//the idea is to make a refreshWithNewQuestions function in all the pages which have a question selection bar
function refreshWithNewQuestions () {
	questionObj = new QuestionObj();
	postQuestionNumber(QuestionNumber);
}

function dealWithBoundaryCases () {
		var position = (QuestionNumber==0 ? "first" : "last");
		document.getElementById("questionBox").innerText = "You were on the "+position+" question";
		document.getElementById("answerBox").innerText = "You were on the "+position+" answer";
		setTimeout(function(){postQuestionNumber(QuestionNumber);}, 3000);
}

function previousQuestion() {
	if (QuestionNumber==0){
		dealWithBoundaryCases ();
	}else {
		QuestionNumber--;
		postQuestionNumber(QuestionNumber);
	}  	
}

function nextQuestion () {
	if (QuestionNumber == Math.min(questionObj.questions.length, questionObj.answers.length) - 1) {
		dealWithBoundaryCases ();
	} else{
		QuestionNumber++;
		postQuestionNumber(QuestionNumber);
		makeAnswerInvisible(true);	
	};
}

function init()
{	
	questionObj = new QuestionObj();

	postQuestionNumber(QuestionNumber);
	
	document.getElementById("previousButton").onclick = previousQuestion;
	
	document.getElementById("nextButton").onclick = nextQuestion;
	
	document.getElementById("showAnswer").onclick = function(){
		if(this.innerText == "Hide Answer"){
			makeAnswerInvisible(true);}
		else{
			makeAnswerInvisible(false);
		}
	};	
}

document.addEventListener("DOMContentLoaded", init, false);