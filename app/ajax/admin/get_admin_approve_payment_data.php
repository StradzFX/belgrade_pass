<?php
$data=$post_data['data'];
$success=false;
$message = "Morate popuniti oba polja";

$validation_message="";
if($data["name_surname"]==""){$validation_message="Morate upisati ime i prezime";}
if($data["date"]==""){$validation_message="Morate odabrati datum";}

if($validation_message==""){
	$success=true;
	$message="Uplata odobrena";
}else{
	$message=$validation_message;

}

echo json_encode(array("success"=>$success, "message"=>$message));
?>