function refreshWithNewQuestions (){
	//this is a dummy piece of code
	var text = "dummy";
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
	
	var panel = document.getElementById("jsonFromServer");
	panel.innerHTML = "";
	printArray(response, panel.appendChild(dom("UL",null)));	
}