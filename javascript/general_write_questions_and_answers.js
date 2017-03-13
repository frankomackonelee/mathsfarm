//I need thes two global variables to persist so I can go through 
var linkNumber = 0;//this will be which link we are on
var myAJAXRequest;

function gotData(thisAJAXRequest) {
	/*
	 * thisAJAXRequest.response.queryResult[0]
		Object {question_number: "1", question: "write question here", answer: "write answer here"}
		thisAJAXRequest.response.queryResult[0].question_number
		"1"
		thisAJAXRequest.response.queryResult[0].question
		"write question here"
	 */ 
	 	questionsAndAnswers = thisAJAXRequest.response.queryResult;
		$text = "<tr><th>Question</th><th>Answer</th><th>Space for a button</th></tr>";
		for (var i=0; i < questionsAndAnswers.length; i++) {
			number = questionsAndAnswers[i].question_number;
			question = questionsAndAnswers[i].question;
			answer = questionsAndAnswers[i].question;
			$text += "<tr><td><input id='question"+number+"' class='question' type='text' value='"+question+"' readonly></td>";
			$text += "<td><input id='answer"+number+"' class='answer' type='text' value='"+answer+"' readonly></td></tr>";
		};
		$text += "<tr><td><input id='questionLoad' type='text' value='write question here'></td>";
		$text += "<td><input id='answerLoad' type='text' value='write answer here'></td>";
		$text += "<td><button id='uploadQuestionsAndAnswers'>Click To Upload</button></td></tr>";
		document.getElementById("loadedQuestionsAndAnswers").innerHTML = $text;	
		document.getElementById("uploadQuestionsAndAnswers").onclick = sendMessageToAPI;
}

function sendMessageToAPI () {
	var myUrl = "/learning/mathsfarm/version2/API_and_processing/API_addQuestionsAndAnswers.php"; 
	var myMessage = '{"title":"' + document.getElementById("title").innerText +  '" ,';
	myMessage += '"question":"' + document.getElementById("questionLoad").value + '", ';
	myMessage += '"answer":"' + document.getElementById("answerLoad").value + '"}';
	myAJAXRequest = new AJAXrequest(myUrl, myMessage);
	myAJAXRequest.makeRequest(gotData);
}

function init()
{	
	document.getElementById("uploadQuestionsAndAnswers").onclick = sendMessageToAPI;
}

document.addEventListener("DOMContentLoaded", init, false);