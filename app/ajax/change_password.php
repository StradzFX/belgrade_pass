<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$data = $post_data['data'];

$user = null;

$user_id = $data['user_id'];

$user = new user();
$user->set_condition('','',"MD5(id) = '".$user_id."'");
$user = $broker->get_all_data_condition($user);

if(sizeof($user) > 0){
	$user = $user[0];

	$validation_message = null;
	
	if($data["new_password_again"] != $data["new_password"]){$validation_message = "Lozinke moraju da se podudaraju.";}
	if($data["new_password_again"] == ""){$validation_message = "Molimo Vas da ponovite lozinku.";}
	if($data["new_password"] == ""){$validation_message = "Molimo Vas da unesete lozinku.";}

	if(!$validation_message){
		$user->password = md5($data["new_password"]);
		$broker->update($user);
		$broker->set_session('user',$user);

		$success = true;
		$message = 'Uspešno ste zamenili lozinku.';
	}else{
		$message = $validation_message;
	}
}else{
	$message = 'Korisnik token nije u redu.';
}



echo json_encode(array("success"=>$success,"message"=>$message,"user"=>$user));