function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

var rows = 9;
var cols = 2;

function updateBackground (backgroundNumber) {
	var backgrounds = ["images/1CaughtRedHanded.png","images/2keepitunderyourhat.jpg","images/3catch22.gif"];
	backgroundNumber = backgroundNumber % (backgrounds.length);
	document.getElementById("table1").style.backgroundImage = "url('" + backgrounds[backgroundNumber] + "')";
}

function updateDimensions () 
{
	var dimensionchoice = $("#dimensions").val();
	var dimensions = dimensionchoice.split(",");

	rows = parseInt(dimensions[0],10);
	cols = parseInt(dimensions[1],10);

	randomiseAnswerOrder(rows*cols/2);	
	updateData();
}

//called from the ChooseQuesions file
function refreshWithNewQuestions () {
	questionObj = new QuestionObj(rows*cols/2);
	
	function getQuestionOrAnswer(id){
		if (id.search("answer")==-1){
			questionNumber = parseInt(id.substring(8));
			question = ((questionNumber == rows*cols/2-1 && $("#bonus").attr('checked')) ? "??????" : questionObj.questions[questionNumber]);
			return question;
		}else{
			return questionObj.answers[parseInt(id.substring(6))];
		}
	}

	var css3buttons = document.getElementsByClassName("css3button");
	forEach(css3buttons, function(css3button){
		css3button.innerText = getQuestionOrAnswer(css3button.id);
	});
}

function setUpPage () 
{
	//rows and cols is as per set by the user in the dropdown
	var strTable = "<tbody>";
	var count = 0;
	var index;
	var randAns = makeRandomIntegerArray(rows*cols/2);
	
	for (var i = 1; i<rows+1; i++)
	{
		strTable += "<tr>" ;
		for (var j = 1; j<cols+1; j++)
		{
			index = Math.floor(count/2);
			number = (count % 2 === 0 ? index : randAns[index]);
			boxId = (count % 2 === 0 ? "question" + number : "answer" + number ) ;
			strTable += "<td>" + 
							"<button type='button' class='css3button' id='" + boxId + "'></button>" + 
						"</td>";
			count ++;
		}
		strTable += "</tr>" ;
	} 
	strTable += "</tbody>";
	$('#table1').html(strTable);
}

function setClickOnQuestionsResponse(){
	//Variables relating to the disappearing buttons
	function matchingIDs(id1, id2){
		if (id1.search("answer")==0 && id2.search("question")==0){
			return ( parseInt(id1.substring(6))==parseInt(id2.substring(8)) );
		}else if(id1.search("question")==0 && id2.search("answer")==0){
			return ( parseInt(id1.substring(8))==parseInt(id2.substring(6)) );
		}
		return false;
	}
	
	var pickedTD = null;
	function clickOnQuestionResponse(e) {
				clickedTD=e.currentTarget;
				if (pickedTD===null){
					pickedTD = clickedTD;
					$('#instructions').text(pickedTD.innerText);
				}else{
					if (matchingIDs(pickedTD.id, clickedTD.id)){
						clickedTD.className = "answered";
						removeHandler(clickedTD._handle_for_handler);
						pickedTD.className = "answered";
						removeHandler(pickedTD._handle_for_handler);
					}	
					$('#instructions').text("Choose a matching pair");
					pickedTD = null;
				}
		}
	
	var tds = document.getElementsByClassName("css3button");
	forEach(tds, function(td){
		//TODO: a bit of ugliness here.  In order to remove the handler later I've needed to access the addHander, so I've made it a property of the element
		td._handle_for_handler = addHandler( td, "click", clickOnQuestionResponse );
	});
}

$(document).ready(function(){	
	
	var background = 0;
	registerEventHandler( document.getElementById("updatebackground"), "click", function(){	background++;
																							updateBackground(background);}
						);

	setUpPage();
	
	refreshWithNewQuestions ();
	
	updateBackground(0);
	
	setClickOnQuestionsResponse();
	
	registerEventHandler( document.getElementById("bonus"), "click", refreshWithNewQuestions);
	//TODO: make this
	//registerEventHandler( document.getElementById("updatedimensions"), "click", updateDimensions);
});
