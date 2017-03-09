function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

function postToGetJSON(what){
	ObjectForAPI = new JSObjectForAPI();
	switch (what){
			case 'topics':
				seeking = new Array("subtopics","titles");
				break;
			case 'subtopics': 
				seeking = new Array("titles");
				break;
			case 'levels': 
				seeking = new Array("titles");
				break;
			case 'titles': 
				seeking = new Array("questions");
				break;														
			default:
				seeking = new Array("unrecognisedIngetSelectorsNeedingUpdating");
				break;		
	}
	ObjectForAPI.addValues("seeking",seeking);
	var arrInformation = ["topic", "subtopic", "level", "title"];
		forEach(arrInformation, function(str){
			//if we've just changed topics we don't want to limit any of the inputs to the subtopics already selected
			if (what == "topics" && str=="subtopic") {
				ObjectForAPI.addValues(str + "s", "Any");
			} else{
				ObjectForAPI.addValues(str + "s", document.getElementById(str + "_select").value);	
			};
		});
	return JSON.stringify(ObjectForAPI.Values);
	
}

function getSelectorToUpdate(fromRequest){
	
	var possibleFromRequest = ["subtopics","titles","questions"];
	var selectors = ["subtopic_select","title_select","tablecontents"];
	var index = possibleFromRequest.indexOf(fromRequest);
	if(index == -1){
		alert("Selector title is wrong in httpResponse");}
	return selectors[possibleFromRequest.indexOf(fromRequest)];
	
};

function addOnChangeEvent(selector){
	
	selector.onchange = function(){
		var changedSelector = this.getAttribute('id');
		var changed = changedSelector.substring(0, changedSelector.length - 7);
		if (changed!="title") {
			document.cookie = changed + "=" + document.getElementById( changedSelector ).value;
		};
		var message = postToGetJSON(changed + "s");	
    	var myUrl = "/learning/mathsfarm/version2/API_and_processing/API_ChooseQuestions.php"; 
		myAJAXRequest = new AJAXrequest(myUrl, message);
		myAJAXRequest.makeRequest(gotData);
	};
}

function gotData(myAJAXrequest) {
	for (var l=0; l < myAJAXrequest.response.selectors.length; l++) {
		//changing from an array of objects to an array of strings
		var selectorInAJAXreturn = myAJAXrequest.response.selectors[l];
		switch(selectorInAJAXreturn){
			case "subtopics": 
				var arr = myAJAXrequest.response.subtopics; break;
			case "levels": 
				var arr = myAJAXrequest.response.levels; break;
			case "titles": 
				var arr = myAJAXrequest.response.titles; break;
			case "questions": 
				var arr = myAJAXrequest.response.questions; break;
		   }
	    
	    var id_to_update=getSelectorToUpdate( selectorInAJAXreturn );
	    if (id_to_update=="tablecontents"){
	    	//cookie will store all the relevant questions as well as whether they are wanted etc.  
	    	cookieJar = new CookieJar(); 
	    	for(i = 0; i < arr.length; i++) {
		        cookieJar.addQuestionAndAnswer(arr[i].question, arr[i].answer);
		    } 
		    sendRefreshThroughHere();
	    }else{
	    	if (arr.length==0){
	    		var text = "<option value='Any'>No Questions Match These Selections</option>";
	    	}else{
	    		var text = "<option value='Any'>Choose An Option</option>";
	    	}
		    for(i = 0; i < arr.length; i++) {
		        text += "<option value='" + arr[i].myList + "'>"+ arr[i].myList +"</option>";
		    }
		    document.getElementById(id_to_update).innerHTML = text;
		}
	};
	
	//Purpose: maintenance_choose_questions_AJAX_response is the only place you showData
	//Should output the JSON file returned from server.  Only runs showData when "jsonFromServer" is present
	(!document.getElementById("jsonFromServer") || showData(myAJAXrequest.response));
}

function sendRefreshThroughHere () {
/*
 * All pages using this code need to have a refreshWithNewQuestions() functions as 
 * when the page loads or questions are chosen this function will be called.  This should 
 */
	refreshWithNewQuestions();
}

function init (){
	
	sendRefreshThroughHere();
	var selectors = document.getElementsByClassName('selector');
	forEach(selectors, addOnChangeEvent);	
	
	var message = postToGetJSON("topics");	
	var myUrl = "/learning/mathsfarm/version2/API_and_processing/API_ChooseQuestions.php"; 
	myAJAXRequest = new AJAXrequest(myUrl, message);
	myAJAXRequest.makeRequest(gotData);
	
};

document.addEventListener("DOMContentLoaded", init, false);

