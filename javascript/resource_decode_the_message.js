/**
 * @author Francis
 */
function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

//takes letters needed for the answer, makes list unique and adds in popular alternatives
//not a pure function.  Letters is array and as an object it means that the reference is edited
function makeLetterList(letters, count){
	var alphabetInOrder = ["E", "T", "A", "O", "I", "N", "S", "H", "R", "D", "L", "C", "U", "M", "W", "F", "G", "Y", "P", "B", "V", "K", "J", "X", "Q", "Z"];
	for (var i = 0; i<letters.length;) {
		if (alphabetInOrder.indexOf(letters[i])==-1 || letters.indexOf(letters[i])<i) {
			letters.splice(i,1);
		}else{
			i++;
		}
	};
	for (var j=letters.length+1; j < count+1; j++) {
		k = 0;
		while(letters.indexOf(alphabetInOrder[k])!=-1){
			k++;
		}
		letters.push(alphabetInOrder[k]);
	};
}

function clickOnABox(box, i){
			box.onclick = function(){
				var classesContained = box.classList;
				for(questionNumber = 0; questionNumber<18; questionNumber++){
					if (classesContained.contains("question" + questionNumber)){
						var relevantClasses = document.getElementsByClassName("question" + questionNumber);
						for(j = 0; j<relevantClasses.length; j++){
							relevantClasses[j].classList.remove("concealed");
						}
					}
				}
			};
}

function refreshWithNewQuestions () {
	loadResources();
}

function loadResources(){
		var inputText = document.getElementById("HiddenMessage").value;
		inputText = inputText.toUpperCase();
		var letters = inputText.split("");
		var questionObj = new QuestionObj(18);
		
		var numberOfAvailableQuestions = questionObj.chosenQuestionCount;
		
		makeLetterList(letters,numberOfAvailableQuestions);
		questionObj.letters = letters;
		
		var randomList = makeRandomIntegerArray(numberOfAvailableQuestions);
		
		var panel = document.getElementById("panel");
		panel.innerHTML = "";
		var codedWords = inputText.split("");
		var answerLables = "<span class='boxed label'>Question</span>";
		var answerBoxes = "<span class='boxed label'>Letter</span>";
		for (var i in codedWords) {
			if(codedWords[i] != " "){
				var questionNumber = questionObj.getLetterIndex(codedWords[i]);
				answerLables += "<span class='boxed'>" + (questionNumber+1) + "</span>";
				answerBoxes += "<span class='boxed question" + questionNumber + " concealed'>" + codedWords[i] + "</span>";
			}else{
				answerLables += "<span class='boxed invisible'>_</span>";
				answerBoxes += "<span class='boxed invisible'>_</span>";
			}
		};
		
		panel.innerHTML += answerLables + "<br>" + answerBoxes + "<br>";
		var htmlText = "";
		var i_rand;
		for (var i=0; i < questionObj.questions.length; i++) {
		  	htmlText += "<tr><td>" + (i+1) + "</td>";
		  	htmlText += "<td class='questionColumn'>" + questionObj.questions[i] + "</td>"; 
		  	htmlText += "<td class='question" + i + " concealed'>" + questionObj.answers[i] + "</td>";
		  	htmlText += "<td class='question" + i + " concealed'>" + letters[i] + "</td>";
		  	htmlText += "<td></td>";
		  	i_rand = randomList[i];
		  	htmlText += "<td>" + questionObj.answers[i_rand] + "</td>";
			htmlText += "<td>" + letters[i_rand] + "</td></tr>";
		};
		panel.innerHTML += "<table><tr><th></th><th>Question</th><th></th><th></th><th id='spacerCell'></th><th>Possible Answers</th><th>Letter</th></tr>" + htmlText + "</table>";
		
		var codedMessageBoxes = document.getElementsByClassName("boxed");
		forEach(codedMessageBoxes, clickOnABox);
}

function init()
{	
	document.getElementById("MakeResource").onclick = function(){
		loadResources();
		document.getElementById("HiddenMessage").style.display = "none";
	};
	loadResources();
}

document.addEventListener("DOMContentLoaded", init, false);