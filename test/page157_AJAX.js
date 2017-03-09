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

function showData(response){
	var printArray = function(arr, element){
		for(var key in arr){
			if (typeof(arr[key]) == "object"){
				if (element.nodeName != "UL"){
					var babyCarrier = element.parentNode.appendChild(dom("ul", null, dom("LI",key)));
				}else{
					var babyCarrier = element;
					babyCarrier.appendChild(dom("LI",key));
				}
				var babies = babyCarrier.appendChild(dom("ul", null));
				printArray(arr[key], babies);
			}else {
				element.appendChild(dom("LI",key + " : " + arr[key]));
			}
		}
	};
	
	var panel = document.getElementById("panel");
	panel.innerHTML = "";
	printArray(response, panel.appendChild(dom("UL",null)));	
}
	
function fireOffGet(){
		// Could be useful to get the element id: $(this).attr('id');
    	//var message = this.value;
    	var myUrl = "page157API.php"; 
    	var name = document.getElementById("name").value;
    	var email = document.getElementById("email").value; 
    	var sex = document.getElementById("sex").value; 
    	
    	
    	var message = '[ {"name":"' + name + '","email":"' + email + '","sex":"' + sex + '"} ]';
    	
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
				    	showData(JSON.parse(httpRequest.responseText));
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
		httpRequest.open("POST", myUrl, true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		//alert(message);
		httpRequest.send(message);
	}


function init()
{	
	document.getElementById("sendGET").onclick = fireOffGet;
}

document.addEventListener("DOMContentLoaded", init, false);