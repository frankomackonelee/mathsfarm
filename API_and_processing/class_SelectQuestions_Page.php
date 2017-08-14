<?php
	class SelectQuestions_Page extends Page {
		
		public function __construct($title) {
			parent::__construct("$title");
			$this->addJavascriptFile(siteLocation."javascript/topic_etc_and_question_selection.js");
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