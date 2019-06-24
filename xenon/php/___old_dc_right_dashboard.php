<?php
if(!isset($_SESSION[XMLSERVICENEWS]) || !isset($_SESSION[XMLSERVICEPROMOTIONS]))
{
	$client = new SoapClient("https://www.weblab.co.rs/services/xenon/server.php?wsdl");
	
	$service_news = $client->return_list_of_news();
	$service_news = simplexml_load_string($service_news);
	$service_news = $service_news->single_news;
	
	$service_news_array = array();
	for($i=0;$i<sizeof($service_news);$i++){ 
		$service_news_array[] = array('title' => (string)$service_news[$i]->title,'link' => (string)$service_news[$i]->link,'text' => (string)$service_news[$i]->text);
	}
	$_SESSION[XMLSERVICENEWS] = $service_news_array;
	
	$service_promotions = $client->return_list_of_promotions();
	$service_promotions = simplexml_load_string($service_promotions);
	$service_promotions = $service_promotions->promotion;
	
	$service_promotions_array = array();
	for($i=0;$i<sizeof($service_promotions);$i++){ 
		$service_promotions_array[] = array('image' => (string)$service_promotions[$i]->image,'link' => (string)$service_promotions[$i]->link,'link_text' => (string)$service_promotions[$i]->link_text,'text' => (string)$service_promotions[$i]->text);
	}
	$_SESSION[XMLSERVICEPROMOTIONS] = $service_promotions_array;
}
else{
	$service_news_array = $_SESSION[XMLSERVICENEWS];
	$service_promotions_array = $_SESSION[XMLSERVICEPROMOTIONS];
}
?>
<div id="right_dashboard">
	<?php for($i=0;$i<sizeof($service_promotions_array);$i++){ ?>
	<div class="box" align="center">
		<img src="<?php echo $service_promotions_array[$i]['image']; ?>" border="0" />
		<p><?php echo $service_promotions_array[$i]['text']; ?><br />
        <strong>
        <a href="<?php echo $service_promotions_array[$i]['link']; ?>" target="_blank"><?php echo $service_promotions_array[$i]['link_text']; ?></a>
        </strong>
		</p>
	</div><!--class box-->
	<?php } ?>
	<div id="web_lab_news">
	<p class="title">WEB LAB news</p>
		<ul>
		<?php for($i=0;$i<sizeof($service_news_array);$i++){ ?>
			<li><p><a href="<?php echo $service_news_array[$i]['link']; ?>" target="_blank"><?php echo $service_news_array[$i]['title']; ?></a></p>	<p><?php echo $service_news_array[$i]['text']; ?></p></li>
		<?php } ?>
		</ul>
	</div><!--web_lab_news-->
</div><!--right_dashboard-->