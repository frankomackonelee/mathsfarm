<?php
/*
 * My vision of this is for it to lay out the structure for all pages
 * 
 */
class maintenancePage {
	protected $title="Default title in the parent";
	protected $cssFiles = array();
	protected $javascriptFiles = array();
	protected $toplinkbar = "";
	protected $core = "";
	protected $bottomlinkbar = "";
	protected $copyrightbottom = "Copyright Melon Education 2017";	
	private $elementIDs = array("title","banner","toplinkbar","core","bottomlinkbar","copyrightbottom");
	
	public function __construct($title) {
		$this->title = $title;
		//returns linked files tagged with the page name or 'All'
		$text = "<br>";
		
		$query = new Query_Select();
		$what = array('page', 'fileType', 'linkNumber', 'local_or_external', 'location');
		
		//TODO: make loop round array of arrays
		$conditions = array('condition1' => "'All'", 'condition2' => "'$title'");
		foreach ($conditions as $condition) {
			$where = array('page' => $condition);
			$arrayResult = $query->runQuery("maintenance_headerlinks", $what, $where);
			$this->loadHeaderLinks($arrayResult);	
		}

		$this->set_toplinkstoresources();
		$this->set_bottomlinkbar();
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
		$this->print_element("toplinkbar");
		$this->print_element("core");
		$this->print_element("bottomlinkbar");
		$this->print_element("copyrightbottom");
		print "</body>\n";
	}
	
	private function loadHeaderLinks($arrayResult)
	{
		foreach ($arrayResult as $rowCount => $row) {
			$url = ($row['local_or_external']=="local" ? siteLocation.$row['location'] : $row['location']);
			if ($row['fileType']=="javascript"){
				$this->addJavascriptFile($url);
			}else{
				$this->addCssFile($url);
			};	
		}
	}
	
	public function addCssFile($url){
		$this->cssFiles[] = $url;
	}
	
	public function addJavascriptFile($url){
		$this->javascriptFiles[] = $url;
	}	
	
	public function getTopicSubtopicLevelSelectors(){
		//Prints the selectors needed when writing or finding questions
		$text = "<select id='topic_select'  class='selector'>\n";
		$topics = array("Make a selection","Algebra","Number","Shape","Data","Other topic");
		foreach ($topics as $topic) {
			$value = ($topic=="Make a selection" ? "Any" : $topic);
			$text .= "<option value='$value'>$topic</option>\n";
		}
		$text .= "</select>";
		$text .= "<select id='subtopic_select' class='selector'><option value='Any'>Choose a topic first</option></select>";
		$text .= "<select id='level_select' class='selector'>";
		$text .= "<option value='Any'>Choose An Option</option>";
		for ($i=1; $i <11 ; $i++) { 
			$text .= "<option value='$i'>$i</option>";
		}
		$text .= "</select><br>";
		$text .= "<select id='title_select' class='selector'><option value='Other'>Choose topic and subtopic</option></select><br>";
		return $text;
	}
	
	public function setContent($elementID, $content)
	{
		if (in_array($elementID, $this->elementIDs)){
			$this->$elementID .= $content;
		}else{
			$_SESSION["error"][] = "An attempt to setContent for #{$elementID} was not successful";
		}
		
	}
	
	protected function printHead(){
		print "<head>\n";
		print "<meta charset='UTF-8' />\n";
		$this->printCssFiles();
		$this->printJavaScriptFiles();	
		print "<title>$this->title</title>\n";
		print "</head>\n";
	}
	
	protected function printCssFiles()
	{
		foreach ($this->cssFiles as $cssFile) {
			print "<link rel='stylesheet' href='$cssFile' />\n";
		}
	}
	
	protected function printJavaScriptFiles(){
		foreach ($this->javascriptFiles as $javaScriptFile) {
			print "<script type='text/javascript' src='$javaScriptFile'></script>\n";
		}
	}
	
	protected function print_element($divID){
		print "<div id='$divID'>".$this->$divID."</div>\n";
	}
	
	//this is called to make the toplinksbar to be the resources bar
	private function set_toplinkstoresources(){
		//array comprises the name of the resource file and the name on the link	
		$class = 'toplink';
		$links = array (	
						array("maintenance_area.php","Maintenance Area"),
					   	array("maintenance_area_checkCookies.php","Check Cookies"),
					  	array("maintenance_area_choose_questions_AJAX_response.php","AJAX Response"),
					  	array("maintenance_area_editLinks.php","Edit Links"),
						);
		foreach ($links as $key => $link) {
			$currentPage = ($link[1]==$this->title) ? " currentpage" : "";
			if($key==0){
				$this->toplinkbar = "<a class='".$class.$currentPage."' href='".siteLocation.$link[0]."'>".$link[1]."</a>";
			}else {
				$this->toplinkbar .= "<a class='".$class.$currentPage."' href='".siteLocation.$link[0]."'>".$link[1]."</a>";}
		}
	}

	private function set_bottomlinkbar()
	{
		$class = 'bottomlink';
		$links = array ( 	
							array("general_home.php","Home"), 
							array("maintenance_area.php","Maintenance Area"),
						   	array("maintenance_area_checkCookies.php","Check Cookies"),
						  	array("maintenance_area_choose_questions_AJAX_response.php","AJAX Response"),
						  	array("maintenance_area_editLinks.php","Edit Links"),
						);
		$this->bottomlinkbar = "<br>";
		foreach ($links as $key => $link) {
			{
				$this->bottomlinkbar .= "<a class='$class' href='".siteLocation.$link[0]."'>".$link[1]."</a>";
			}
			
		}
		
	}
	
	
}

?>