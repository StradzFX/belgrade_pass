<?php
$data = $post_data['data'];
$success = false;
$message = 'Nothing happened :(';

global $broker;

$validation_message = "";
if($data["name"] == ""){$validation_message = "Upisite ime";}
if($data["surname"] == ""){$validation_message = "Upisite prezime";}
if($data["email"] == ""){$validation_message = "Upisite email";}


$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->add_condition('user','=',$data["id"]);
$user_card_all->set_order_by('pozicija','DESC');
$user_card_all = $broker->get_all_data_condition($user_card_all);

$user_card = $user_card_all[0];


if($validation_message == ""){
	

	$SQL = "UPDATE user SET first_name = '".$data["name"]."', last_name = '".$data["surname"]."', email = '".$data["email"]."' WHERE id = ".$data["id"];
	$broker->execute_query($SQL);


	$SQL = "UPDATE user_card SET parent_first_name = '".$data["name"]."', parent_last_name = '".$data["surname"]."', email = '".$data["email"]."' WHERE id = ".$user_card->id;
	$broker->execute_query($SQL);

	$success = true;
	$message = "Podaci uspešno ažurirani";

	if($data["password_one"] != ''){
		if($data["password_one"] != $data["password_two"]){$validation_message = "Lozinke moraju da budu identične";}

		if($validation_message == ""){
			$SQL = "UPDATE user SET password = '".md5($data["password_one"])."' WHERE id = ".$data["id"];
			$broker->execute_query($SQL);
		}else{
			$success = false;
			$message = $validation_message;
		}
	}
	
	
}else{
	$message = $validation_message;
} 

echo json_encode(array("success"=>$success,"message"=>$message));