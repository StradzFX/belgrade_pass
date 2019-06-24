<?php
global $broker;
$data = $post_data['data'];

$success = false;
$message = 'Post was made';
$error_message = null;
if($data['ts_location'] == ''){$error_message = 'Please select location';}
if($data['max_kids'] == ''){$error_message = 'Please insert maximum number of kids';}
if($data['max_adults'] == ''){$error_message = 'Please insert maximum number of adults';}

$company_birthday_data_all = new company_birthday_data();
$company_birthday_data_all->set_condition('checker','!=','');
$company_birthday_data_all->add_condition('recordStatus','=','O');
if($data['id'] != 0){
	$company_birthday_data_all->add_condition('id','!=',$data['id']);
}
/*$company_birthday_data_all->add_condition('ts_location','=',$data['ts_location']);
$company_birthday_data_all->set_order_by('pozicija','DESC');
$company_birthday_data_count = $broker->get_count_condition($company_birthday_data_all);
if($company_birthday_data_count > 0){
	$error_message = 'Sorry, for this location data already exists.';
}*/


if(!$error_message){
	if($data['id'] == 0){
		$company_birthday_data = new company_birthday_data();
		$company_birthday_data->maker = 'system';
	    $company_birthday_data->makerDate = date('c');
	    $company_birthday_data->checker = 'system';
	    $company_birthday_data->checkerDate = date('c');
	    $company_birthday_data->jezik = 'rs';
	    $company_birthday_data->recordStatus = 'O';
	}else{
		$company_birthday_data = $broker->get_data(new company_birthday_data($data['id']));
	}

	$company_birthday_data->training_school = $data['training_school'];
    $company_birthday_data->ts_location = $data['ts_location'];
    $company_birthday_data->garden = $data['garden'];
    $company_birthday_data->smoking = $data['smoking'];
    $company_birthday_data->max_kids = $data['max_kids'];
    $company_birthday_data->max_adults = $data['max_adults'];
    $company_birthday_data->catering = $data['catering'];
    $company_birthday_data->animators = $data['animators'];
    $company_birthday_data->name = $data['name'];
    $company_birthday_data->watching_kids = $data['watching_kids'];
    
    if($data['id'] == 0){
		$company_birthday_data = $broker->insert($company_birthday_data);
		$message = 'Inserted data';
	}else{
		$broker->update($company_birthday_data);
		$message = 'Updated data';
	}

	$SQL = "DELETE FROM company_location_birthday_slots WHERE company_birthday_data = ".$company_birthday_data->id;
	$broker->execute_query($SQL);

	$birthday_slots = $data['birthday_slots'];
	for($i=0;$i<sizeof($birthday_slots);$i++){
		$slots = $birthday_slots[$i]['slots'];
		for($j=0;$j<sizeof($slots);$j++){
			$slot = $slots[$j];
			$clbs = new company_location_birthday_slots();
		    $clbs->day_of_week = $birthday_slots[$i]['day_of_week'];
		    $clbs->hours_from = $slot['hours_from'];
		    $clbs->minutes_from = $slot['minutes_from'];
		    $clbs->hours_to = $slot['hours_to'];
		    $clbs->minutes_to = $slot['minutes_to'];
		    $clbs->price = $slot['price'];
		    $clbs->company_birthday_data = $company_birthday_data->id;
		    $clbs->maker = 'system';
		    $clbs->makerDate = date('c');
		    $clbs->checker = 'system';
		    $clbs->checkerDate = date('c');
		    $clbs->jezik = 'rs';
		    $clbs->recordStatus = 'O';
		    
		    $clbs = $broker->insert($clbs);
		}
	}
	

	$success = true;
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));