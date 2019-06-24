<?php
class seo_generator
{
	//=========================================== BASIC TAGS =======================================
	private $page_title = "";
	private $page_keywords = "";
	private $page_description = "";
	//=========================================== OPEH GRAPH PROTOCOL ==============================
	private $show_og_code = false;
	private $og_title = "";
	private $og_url = "";
	private $og_desctiption = "";
	private $og_image = "";
	private $og_type = "";
	//=========================================== SEO TITLE VALIDATION ============================
	private $urlForbidenCharacters = array('%',': ','?','š','Š','ž','Ž','ć','Ć','č','Č','đ','Đ','. ','.',', ',' - ','/',' ',"'",'’','`','!','+','(',')','"','®','!','?','\\','*','\'','^','&','#','<','>','; ',';','{','}','(',')','|','~','[',']');
	private $urlValidCharacters = array('','-','','s','S','z','Z','c','C','c','C','dj','Dj','','','-','-','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	
	public function set_basic_tags($page_title = "",$page_keywords = "",$page_description = "")
	{
		 $this->page_title = $page_title;
		 $this->page_keywords = $page_keywords;
		 $this->page_description = $page_description;
	}

	public function set_open_graph_protocol_parameters($og_title,$og_url,$og_desctiption,$og_image,$og_type){
		$this->show_og_code = true;
		$this->og_title 		= $og_title;
		$this->og_url 			= $og_url;
		$this->og_desctiption 	= $og_desctiption;
		$this->og_image 		= $og_image;
		$this->og_type 			= $og_type;
	}
	//===================================== ECHO PAGE AND SEO TAGS ===============================
	public function echo_seo_tags()
	{
		?>
<title><?php echo $this->page_title; ?></title>
<meta name="keywords" content="<?php echo $this->page_keywords; ?>" />
<meta name="description" content="<?php echo $this->page_description; ?>" />
<?php if($this->show_og_code){ ?>
<meta property="og:title" content="<?php echo strip_tags($this->strip_string_word($this->og_title,150)); ?>" />
<meta property="og:type" content="<?php echo strip_tags($this->strip_string_word($this->og_type,150)); ?>" />
<meta property="og:url" content="<?php echo strip_tags($this->og_url); ?>" />
<meta property="og:image" content="<?php echo strip_tags($this->og_image); ?>" />
<meta property="og:description" content="<?php echo strip_tags($this->strip_string_word($this->og_desctiption,250)); ?>" /><?php } 
}
	//=============== ADDITIONAL FUNCTIONS ===============================================
	
	//========= CREATE SEO TITLE
	public function create_seo_title($element)
	{
		$element = ltrim($element);
		$element = rtrim($element);
		return str_replace($this->urlForbidenCharacters,$this->urlValidCharacters,$element);
	}
	//========= GOOGLE ANALYTICS
	public function echo_google_analytics_code($ga_code)
	{
		if($ga_code != "")
		{
		?>
        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', '<?php echo $ga_code; ?>', 'auto');
		  ga('send', 'pageview');
		
		</script>
		<?php	
		}
	}
	
	//================== PRIVATE FUNCTIONS ==================================================
	private function strip_string_word($string,$length=40)
	{
		if(strlen($string) > $length)
		{
			$string = wordwrap($string, $length);
			$j = strpos($string, "\n");
			if($j) 
				$string = substr($string, 0, $j);
		}else{
			$string = stripslashes($string);
		}
		$string = strip_tags($string);
		return $string;
	}
}