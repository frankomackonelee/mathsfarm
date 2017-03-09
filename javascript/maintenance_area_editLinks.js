//I need thes two global variables to persist so I can go through 
var linkNumber = 0;//this will be which link we are on
var myAJAXRequest;

function gotData(thisAJAXRequest) {
	/*this is called from within the AJAX object
	//but also needed to deal with a call within the code below
	//myAjaxRequest.response is jsonParsed version of:
	//{		
	//		"rowsReturned":"9", 
	//		"data":[	{ "url":"https://www.mrbartonmaths.com/", "icon":"MrBarton.jpg", "alt":"Mr Barton Maths", "accompanyingText":"Mr Barton Maths", "linkNumber":"1"} , 
	//					{...}...] }
	*/
	if(thisAJAXRequest!=null){
		var myData = thisAJAXRequest.response.data[linkNumber];
	}else{
		var myData = myAJAXRequest.response.data[linkNumber];
	}
	document.getElementById('linkNumber').value = myData.linkNumber;
	document.getElementById('url').value = myData.url;
	document.getElementById('icon').value = myData.icon;
	document.getElementById('alt').value = myData.alt;
	document.getElementById('accompanyingText').value = myData.accompanyingText;
}

function getLinksFormHTML(action){
	var text = "<form id='functionality_form' method='POST' action='" + action + "'>";
	text +=	"<fieldset id='formInputs'>";
	inputNames = ['linkNumber', 'url','icon','alt','accompanyingText'];
	forEach(inputNames, function(name){
		text +=	'<div class="form-field"' + (name=='linkNumber' ? ' id="notDisplayed"' : '') + '>';
		text +=	'<label>' + name + "</label>";
		text +=	"<input name='" + name + "' id='" + name + "' type='text'/></div><br>";
	});
	text +=	"</fieldset>";
	text +=	"</form>";
	return text;	
}

function getFormField(inputType, inputValue){
	var element = dom('input'); 
	element.type = inputType;
	element.value = inputValue;
	if(inputValue=="Previous Link"||inputValue=="Next Link"){
		element.setAttribute("id", inputValue);
		var direction = inputValue.substr(0,inputValue.indexOf(' ')); 
		//TODO: 
		element.onclick = onclickChangeLink(direction);
	}
	var div = dom('div',null,element);
	div.classList.add('form-field');
	return div;	
}

//outputs onclick events for next and previous
function onclickChangeLink (direction){
	return function() {
		var movement = (direction == "Next" ?  1 : -1);
		var temp = linkNumber + movement;
		if (temp<0 || temp>=myAJAXRequest.response.rowsReturned){
			//Todo: make this more elegant
			var alertText = (temp<0 ? "This is the first link" : "This is the last link");
			alert(alertText);
		}else{
			linkNumber = temp;
			gotData();
		}	  
	};
};

function showEditLinksForm(submitLocation, buttonText, booScrollers){
	var text = getLinksFormHTML(submitLocation);
	document.getElementById("Functionality").innerHTML = text;
	var formInputs = document.getElementById('formInputs');
	if (booScrollers) {
		childNode = getFormField('button', 'Previous Link');
		if(formInputs.firstChild){
			formInputs.insertBefore(childNode,formInputs.firstChild);}
	    else {
	    	formInputs.appendChild(childNode);}
		formInputs.appendChild(getFormField('button', 'Next Link'));
	};
	formInputs.appendChild(getFormField('submit', buttonText));
}

//outputs a function to be linked to the onclick events of the top level buttons
function makeEditForm (processingFile, text, booScrollers){
	return function(){
		showEditLinksForm('API_and_processing/' + processingFile, text, booScrollers);
		if (booScrollers) {
			getAllExternalLinksDetails();	
		};
	};
}

function getAllExternalLinksDetails () {
	var myUrl = "/learning/mathsfarm/version2/API_and_processing/API_EditLinks.php"; 
	var myMessage = '{"seeking":"linksDetails"}';
	myAJAXRequest = new AJAXrequest(myUrl, myMessage);
	myAJAXRequest.makeRequest(gotData);
}

function init()
{	
	document.getElementById("Add_Links").onclick = makeEditForm('maintenance_area_addLinks-process.php','Add this link',false);
	document.getElementById("Delete_Links").onclick = makeEditForm('maintenance_area_deleteLinks-process.php','Delete this link',true);
	document.getElementById("Update_Links").onclick = makeEditForm('maintenance_area_updateLinks-process.php','Edit this link',true);
}

document.addEventListener("DOMContentLoaded", init, false);