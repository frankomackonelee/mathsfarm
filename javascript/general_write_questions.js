/**
 * @author Francis
 */
function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

function updateClickedBoxes (argument) {
  
}
function getCookieObject(cookieName){
	var cookieString = readCookie(cookieName);
	
	if(cookieString==null){
		var cookieObj = {};
	}else{
		var cookieObj = JSON.parse(cookieString);
	};
	return cookieObj;
}

function gotData(myAJAXrequest) {
	var panel = document.getElementById("subtopic_section");
	var arr = myAJAXrequest.response.subtopics;
	
	var cookieObj = getCookieObject("selectedItems");
	
	var text = "<ul class='checkbox-grid'>";
	forEach(arr, function(arrElement){
		var checkedStatus = "";
		if (cookieObj.subtopic_list!=undefined && cookieObj.subtopic_list.indexOf(arrElement.myList)!=-1 ) {
			checkedStatus = " checked='checked'";
		};
		text += "<li><input type='checkbox' class='subtopic_list' name='subtopic_list[]' value='" + arrElement.myList + "'" + checkedStatus + ">" + arrElement.myList + "</li>"; 		
	});
	text +=  "</ul>";
	panel.innerHTML = text;
	prepClickBoxes("subtopic_list");
}

function updateClickedCookieList () {

	var cookieName = "selectedItems";
	//selectedItems={	"level_list":["4","2"],
	//					"topic_list":[],
	//					"subtopic_list":["Collecting data","Coordinates"]}
	//var cookieObj = getCookieObject(cookieName);
	var cookieObj = {};
	var selectorTypes = ["level_list", "topic_list", "subtopic_list"];
	
	for (var i=0; i < selectorTypes.length; i++) {
		var listOfClicks = getArrayOfClickedItemsInClass(selectorTypes[i]);
		cookieObj[selectorTypes[i]] = listOfClicks;
	}
	
	cookieString = JSON.stringify(cookieObj);
	setCookie(cookieName, cookieString);
}

function getArrayOfClickedItemsInClass(theClassName){
	checkedItems = [];
	allBoxes = document.getElementsByClassName(theClassName);
	forEach(allBoxes, function (box) {
		if (box.checked) {
			checkedItems.push(box.value);
		};
	});
	return checkedItems;
}

//{"seeking":["subtopics","titles"],"topics":"Number","subtopics":"Any","levels":"Any","titles":"Other"}"
function writeMessageAndSendToAPI (seeking,passedInfoType,infoArray) {
	ObjectForAPI = new JSObjectForAPI();
	ObjectForAPI.addValues("seeking",seeking);
	var requiredInfoTypes = ['topics', 'subtopics','levels','titles'];
	forEach(requiredInfoTypes, function(currentInfoType){
		if(passedInfoType == currentInfoType){
			ObjectForAPI.addValues(currentInfoType,infoArray);
		}else{
			ObjectForAPI.addValues(currentInfoType,"Any");
		}
	});
	var message = JSON.stringify(ObjectForAPI.Values);
	var myUrl = "/learning/mathsfarm/version2/API_and_processing/API_ChooseQuestions.php"; 
	myAJAXRequest = new AJAXrequest(myUrl, message);
	myAJAXRequest.makeRequest(gotData);
}

function prepClickBoxes(classList) {
	topicClickers = document.getElementsByClassName(classList);
	forEach(topicClickers, function(clicker){
		clicker.addEventListener('click',function(){
			
			updateClickedCookieList ();
			
			if (classList=="topic_list") {
				writeMessageAndSendToAPI(["subtopics"],"topics",getArrayOfClickedItemsInClass(classList));
			};
			
		});
	});
}

function init(){
	//this is to empty out the cookie selectedItems
	cookieObj = {};	
	cookieString = JSON.stringify(cookieObj);
	setCookie("selectedItems", cookieString);
	prepClickBoxes("topic_list");
	prepClickBoxes("level_list");
}

document.addEventListener("DOMContentLoaded", init, false);