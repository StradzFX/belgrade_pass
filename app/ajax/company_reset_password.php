<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$data = $post_data['data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
if($data["new_password_again"] != $data["new_password"]){$validation_message = "Lozinke moraju da budu identične";}
if($data["new_password_again"] == ""){$validation_message = "Molimo Vas da ponovite lozinku";}
if(strlen($data["new_password"]) < 6){$validation_message = "Lozinka ne može da sadrži manje od 6 karaktera";}
if($data["new_password"] == ""){$validation_message = "Molimo Vas da unesete lozinku";}

if($validation_message == ""){

	$new_password = md5($data["new_password"]);
	$SQL = "UPDATE training_school SET password = '$new_password' WHERE id = ".$company->id;
	$broker->execute_query($SQL);
	$success = true;
	$message = 'Promenili ste lozinku';
}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();