<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "config.php";
require_once "pdf/html_table.php";
include_once "php/functions.php";
$t_picture = $broker->get_data(new t_picture($_GET["id"]));

require_once "../classes/domain/trainer.class.php";
$trainer = $broker->get_data(new trainer($t_picture->trainer));
$t_picture->trainer = $trainer->first_name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $t_picture->id;
$header_param_list["checker"] = $t_picture->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($t_picture->checkerDate));
$header_param_list["maker"] = $t_picture->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($t_picture->makerDate));
$header_param_list["number_of_modifications"] = $t_picture->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($t_picture->trainer != "" || $t_picture->trainer != NULL){ $html .= '<b>Trainer: </b> <BR>'.$t_picture->trainer.'<BR><BR>';}
if($t_picture->picture != "" || $t_picture->picture != NULL){ 
$html .= '<b>Picture: </b> 
<BR> <img src="../pictures/t_picture/picture/'.$t_picture->picture.'" height="50"/><BR><BR><BR><BR><BR>';}	
$file="xenon-document-".time().".pdf";
$html = str_replace("Ä†", "C", $html); //C
$html = str_replace("Ä‡", "c", $html); //c
$html = str_replace("Ä•", "c", $html); //c
$html = str_replace("Å¾", "ž", $html); //ž
$html = utf8_decode($html);
$pdfd->WriteHTML($html);
$pdfd->Output("pdf/".$file,"F");
header("Cache-Control: public");
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=".$file);
ob_clean();
readfile("pdf/".$file);
unlink("pdf/".$file);
die();
?>
