<?php
/**
 * 
 */
class Resource_Page extends Page {
	
	public function __construct($title) {
		parent::__construct("$title");
		$this->addCssFile(siteLocation."css/resource.css");	
		$this->addJavascriptFile(siteLocation."javascript/common_functions.js");
		$this->addJavascriptFile(siteLocation."javascript/class_AJAXrequest.js");
		$this->addJavascriptFile(siteLocation."javascript/class_JSObjectForAPI.js");
		$this->addJavascriptFile(siteLocation."javascript/browser_event_control.js");
		$this->setContent("core", $this->getTopicSubtopicLevelSelectors());
	}
	
	public function printPage(){
		print "<!DOCTYPE html>\n";
		print "<html>\n";
		$this->printHead();
		$this->printBody();
		print "</html>\n";
	}
	
	private function printBody(){
		print "<body>\n";
		$this->print_banner();
		$this->print_element("toplinkbar");
		$this->print_element("core");
		$this->print_element("bottomlinkbar");
		$this->print_element("copyrightbottom");		
		print "</body>\n";
	}
	
}

?>