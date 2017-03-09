function JSObjectForAPI () {
	this.Values = {};
	this.possibleValueNames = ['seeking', 'topics', 'subtopics','levels','titles'];
}
JSObjectForAPI.prototype.addValues = function(valueName, theValues){
	if(this.possibleValueNames.indexOf(valueName) == -1){
		alert("in JSObjectForAPI" + valueName + "is not a possible valueName");
	}else{
		switch(valueName){
			case "seeking": 
			this.Values.seeking=theValues;
			break;
			
			case "topics": 
			this.Values.topics=theValues;
			break;
			
			case "subtopics":
			this.Values.subtopics=theValues;
			break;
			
			case "levels":
			this.Values.levels=theValues;
			break;
			
			case "titles":
			this.Values.titles=theValues;
			break;			
		};
		
	}
};
