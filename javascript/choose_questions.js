function refreshWithNewQuestions () {
	questionObj = new QuestionObj(18);
    var text = "";
    var i;
	text += "<tr><th>Questions</th><th>Answers</th></tr>";	
	//this loop has to take as info data from the cookies - unlike other code on the resources page which use QuestionObj
	//cookies to store all quesions, QuestionObj to store ones in use in the correct order
	var limit = (readCookie("questionCount")==null ? 0 : parseInt(readCookie("questionCount"))+1);
	for(i = 0; i < limit; i++) {
        text += "<tr><td class='questionColumn'>" + readCookie("question" + i) + "'</td><td>" + readCookie("answer" + i) + "'</td>";
        var checkedInfo = (readCookie("wanted" + i)=="true" ?  "checked='checked'" : "");
        text += "<td><input type='checkbox' id='wanted"+ i +"' class='wantedIndicators'"+ checkedInfo +"></input></td></tr>";
    } 
    document.getElementById("tablecontents").innerHTML = text;	
    
    var wantedIndicators = document.getElementsByClassName("wantedIndicators");
    forEach(wantedIndicators, function  (wantedIndicator) {
    	wantedIndicator.onclick = function(){
    		setCookie( "wanted" + wantedIndicator.id.substr(6), wantedIndicator.checked);
    	};
    });
    
}