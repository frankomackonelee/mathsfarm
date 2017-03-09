function errorhandler(msg, url, ln)
{
	alert("Error: " + msg + "\nIn File: " + url + "\nAt Line: " + ln);
	return true;
}
onerror = errorhandler;

var httpRequest;

$(document).ready(function(){
	
	$('#topic_select').on('change', function (e) {
		// Could be useful to get the element id: $(this).attr('id');
    	var valueSelected = this.value;
    	
    	var myUrl = "/learning/mathsfarm/version2/test/get_sendSubtopics.php";
    	myUrl += "/" + valueSelected + "/dummy";
    	
		// Deals with different browsers requiring different objects
		if (window.XMLHttpRequest) { // Mozilla, Safari, IE7+ ...
		    httpRequest = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // IE 6 and older
		    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}
		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === XMLHttpRequest.DONE) {
			    // everything is good, the response is received
			    if (httpRequest.status === 200) {
			    	gotData(JSON.parse(httpRequest.responseText));
		    		// perfect!
				} else {
				    // there was a problem with the request,
				    // for example the response may contain a 404 (Not Found)
				    // or 500 (Internal Server Error) response code
				}
			} else {
			    // still not ready
			}
		};
		//third option is set to true to make the request Asyncronous as in AJAX
		httpRequest.open("GET", myUrl, true);
		var message = null;
		httpRequest.send(message);
	});	
	
});

function gotData(response) {
	//alert("Got the data "  + response.topic);
    var text = "";
    var i;
    var arr = response.subtopics;
    for(i = 0; i < arr.length; i++) {
        text += "<option value='" + arr[i].subtopic + "'>"+ arr[i].subtopic +"</option>";
    }
	
    $('#subtopic_select').html(text);
}

