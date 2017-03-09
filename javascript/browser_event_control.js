
function normaliseEvent (thisEvent) {
	//copied from eloquent Javascript page 178
	//the purpose of this event is to normalise the properties for all browsers so that the properties involved are accessed from:
	//(.stopPropagation .preventDefault...?) .stop .target .relatedTarget .pageX and .pageY .character
	if (!thisEvent.stopPropagation){
		thisEvent.stopPropagation = function () { this.cancelBubble = true;};
		thisEvent.preventDefault = function () { this.returnValue = false;};
	}
	if (!thisEvent.stop){
		thisEvent.stop = function(){
			this.stopPropagation();
			this.preventDefault();
		};
	}
	if(thisEvent.srcElement && !thisEvent.target){
		thisEvent.target = thisEvent.srcElement;
	}
	if((thisEvent.toElement||thisEvent.fromElement) && !thisEvent.relatedTarget)
		thisEvent.relatedTarget = (thisEvent.toElement || thisEvent.fromElement);
	if(thisEvent.clientX != undefined && thisEvent.pageX == undefined){
		thisEvent.pageX = thisEvent.clientX + document.body.scrollLeft;
		thisEvent.pageY = thisEvent.clientY + document.body.scrollTop;
	}	
	if (thisEvent.type == "keypress")
		thisEvent.character = String.fromCharCode(thisEvent.charChode||thisEvent.keyCode);
	return thisEvent;
}

function registerEventHandler(node, thisEvent, handler) {
	if(typeof node.addEventListener == "function")
		node.addEventListener(thisEvent, handler, false);
	else
		node.attachEvent("on" + thisEvent, handler);
}

function unregisterEventHandler (node, thisEvent, handler) {
	if(typeof node.removeEventListener == "function")
		node.removeEventListener(thisEvent, handler, false);
	else
		node.detachEvent("on" + thisEvent, handler);
}

function addHandler (node, type, handler) {
	function wrapHandler (event) {
		handler(normaliseEvent(event || window.event));
	}
	registerEventHandler(node, type, wrapHandler);
	return {node: node, type: type, handler: wrapHandler};
}

function removeHandler(object){
	unregisterEventHandler(object.node, object.type, object.handler);
}
