function AJAXrequest(myURL, myMessage){
	//properties
	this.url = myURL;
	this.message = myMessage;
	this.requestType = "POST";
	this.responseType = "json";
	this.response = null;
}
//methods
AJAXrequest.prototype.makeRequest = function (myFunction) {
	if (window.XMLHttpRequest) { // Mozilla, Safari, IE7+ ...
	    httpRequest = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE 6 and older
	    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//TODO: This doesn't feel pretty! so I can pass the instance of the AJAXrequest oject to the 
	//response handler
	handle = this;
	httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
		    // everything is good, the response is received
		    if (httpRequest.status === 200) {
		    	if(handle.responseType == "json"){
		    		//next two lines are a total fudge I can't understand why but a hyphen is popping upn in the AJAX return message from API
		    		var jsonText = httpRequest.responseText;
		    		var jsonText = (jsonText.substr(0, 1)=="-" ? jsonText.substr(1, jsonText.length) : jsonText);
		    		handle.response = JSON.parse(jsonText);
		    	}else{
		    		handle.response = "Need to update teh AJAXresquest object to deal with non json responses";
		    	}
		    	myFunction(handle);
			} else {
			    // there was a problem with the request, for example the response may contain a 404 (Not Found) or 500 (Internal Server Error) response code
			}
		} else {
		    // still not ready
		}
	};
	//third option is set to true to make the request Asyncronous as in AJAX
	httpRequest.open(this.requestType, this.url, true);
	httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	httpRequest.send(this.message);
};