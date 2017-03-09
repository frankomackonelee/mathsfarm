//TODO: put the two classes at the bottom into separate classes

//sole purpose is to randomise an array
//array that is passed gets edited because the reference is edited
function forEach (array, func) {
	for(i = 0; i<array.length; i++)
		func(array[i]);
}

function shuffle (array) {
	  var i = 0, j = 0, temp = null;
	
	  for (i = array.length - 1; i > 0; i -= 1) {
	    j = Math.floor(Math.random() * (i + 1));
	    temp = array[i];
	    array[i] = array[j];
	    array[j] = temp;
	  }
}

function makeRandomIntegerArray (lessThan) {
		var randomIntegerArray = [];
		for (var i=0; i < lessThan; i++) {
			randomIntegerArray[i] = i;
		};
		shuffle(randomIntegerArray);
		return randomIntegerArray;
}

function setCookie(name, value){
	document.cookie = name + "=" + value  + "; path=/" ;
}

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

//used to add an element of the dom
function dom(name, textContent, child) {
	var node = document.createElement(name);
	if (textContent){
		var text = document.createTextNode(textContent);
		node.appendChild(text);
	}
	for (var i=2; i < arguments.length; i++) {
		node.appendChild(arguments[i]);
	};
	return node;
}

//creates questions and answers or a dummy if there aren't any
function QuestionObj(count) {
	this.loadQuestionsAndAnswers(count);
}
	QuestionObj.prototype.loadQuestionsAndAnswers = function(count){
		//if count is not passed it will run through all questions available, otherwise as per specified
		this.questions = [];
		this.answers = [];
		this.letters = [];
		this.chosenQuestionCount = 0;
		var questionsStored = (readCookie("questionCount") == null ? -1 : parseInt(readCookie("questionCount")));
		questionsStored++;
		
		//this logic is a bit of a rats nest.  count is the number of questions requested and questionsStored is the number available
		//where more questions are requested than are available use dummy questions
		//where no number of questions are requested and their aren't any available then use dummies
		if (count===undefined && questionsStored != 0) {
			useCookies = true;
			limit = questionsStored;
		}else{
			useCookies = (questionsStored>=count);
			limit = (count==undefined ? 18 : count);
		}
		
		if(useCookies){
			//TODO this needs to be a while loop.  While the number of questions loaded<limit
			var questionsLoaded = 0;
			var i = 0;
			while(questionsLoaded<limit && i<18){
				if(readCookie("wanted" + i)=="true"){
					this.questions.push(readCookie("question" + i));
					this.answers.push(readCookie("answer" + i));
					questionsLoaded++;
				}
				i++;
			}
			this.chosenQuestionCount = questionsLoaded;
		}else{
			for (var i=0; i < limit; i++) {
				this.questions.push("Which answer goes with Question " + i + " ?");
				this.answers.push("Answers " + i);
			};
			this.chosenQuestionCount = limit;
		}
	};
	QuestionObj.prototype.getLetterIndex = function(letter){
		for (var i=0; i < this.letters.length; i++) {
			if(this.letters[i] === letter)
				return i;
		};
	};

function CookieJar() {
	function delete_cookie(name) {
		document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}

	var keyValuePairs = document.cookie.split(';');
	for(var i = 0; i < keyValuePairs.length; i++) {
	    var name = keyValuePairs[i].substring(0, keyValuePairs[i].indexOf('='));
	    delete_cookie(name);
	};
	this.addQuestionAndAnswer = function(question, answer) {
		var nextQuestionNumber;
		nextQuestionNumber = (readCookie("questionCount") == null ? 0 : (parseInt(readCookie("questionCount")) + 1));
		setCookie( "question" + nextQuestionNumber, question );
		setCookie( "answer" + nextQuestionNumber, answer );
		setCookie( "wanted" + nextQuestionNumber, true );
		setCookie( "questionCount", nextQuestionNumber );
	};
	//TODO: develop this.  Purpose is to enable users to scroll through links data
	this.addExternalLinkDetails = function(question, answer) {
		var nextQuestionNumber;
		nextQuestionNumber = (readCookie("questionCount") == null ? 0 : (parseInt(readCookie("questionCount")) + 1));
		setCookie( "question" + nextQuestionNumber, question );
		setCookie( "answer" + nextQuestionNumber, answer );
		setCookie( "wanted" + nextQuestionNumber, true );
		setCookie( "questionCount", nextQuestionNumber );
	};
}

