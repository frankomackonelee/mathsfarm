<?php
/*
 * My vision of this is for it to lay out the structure for all pages
 * 
 */
class Page {
	protected $title="Default title in the parent";
	protected $cssFiles = array();
	protected $javascriptFiles = array();
	protected $banner;
	protected $toplinkbar = "";
	protected $core = "";
	protected $bottomlinkbar = "";
	protected $copyrightbottom = "Copyright Melon Education 2017";	
	private $elementIDs = array("title","banner","toplinkbar","core","bottomlinkbar","copyrightbottom");
	
	public function __construct($title) {
		$this->title = $title;
		
		$this->cssFiles[] = siteLocation."css/normalise.css";
		$this->cssFiles[] = siteLocation."css/page.css";
		$this->javascriptFiles[] = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.1.min.js";
		$this->set_toplinkstoresources();
		$this->set_bottomlinkbar();
	}
	
	public function addCssFile($url){
		$this->cssFiles[] = $url;
	}
	
	public function addJavascriptFile($url){
		$this->javascriptFiles[] = $url;
	}	
	
	public function getTopicSubtopicLevelSelectors(){
		$this->addJavascriptFile(siteLocation."javascript/topic_etc_and_question_selection.js");
		$this->addCssFile(siteLocation."css/topic_etc_and_question_selection.css");
		//Prints the selectors needed when writing or finding questions
		$text = "<select id='topic_select'  class='selector'>\n";
		$text .= "<option value='Any'>Make a selection</option>\n";
		$topics = array("Algebra","Number","Shape","Data","Other topic");
		foreach ($topics as $topic) {
			$text .= "<option value='$topic'>$topic</option>\n";
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

	protected function print_banner()
	{
		print "<img id='banner' src='".siteLocation."images/banner.jpg' alt='Mathematics on a whiteboard'/>\n";
	}
	
	protected function print_element($divID){
		print "<div id='$divID'>".$this->$divID."</div>\n";
	}
	
	//this is called to make the toplinksbar to be the resources bar
	private function set_toplinkstoresources(){
		//array comprises the name of the resource file and the name on the link	
		$class = 'toplink';
		$links = array (	
						array("resource_decode_the_message.php","Decode the Message"),
					   	array("resource_catchphrase.php","Catch Phrase"),
					  	array("resource_questions_and_answers.php","Questions and Answers"),
						array("resource_bingo.php","Bingo")
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
							array("index.php","Home"), 
							array("general_about.php","About Us"), 
							array("general_write_title.php","Write Questions"),
							array("choose_questions.php","Choose Questions"),
							array("general_links.php","Other things you'll like"),
							array("maintenance_area.php","Maintenance"),
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