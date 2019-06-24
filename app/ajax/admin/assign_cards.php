<?php
$validate_data = $post_data['validate_data'];

global $broker;

$success = false;
$message = 'Function for save is not implemented.';

$validation_message = "";
if($validate_data["cards_from"] == ""){$validation_message = "Please insert numbers from";}
if($validate_data["cards_to"] == ""){$validation_message = "Please insert numbers to";}
if($validate_data["company"] == ""){$validation_message = "Please select partner";}
if($validate_data["company_location"] == ""){$validation_message = "Please select partner location";}

if(sizeof($validate_data["birthdays"]) == 0){$validation_message = "Please select at least one kid";}

if($validation_message == ""){

	if($data['cards_from'] > $data['cards_to']){
		$a = $data['cards_to'];
		$data['cards_to'] = $data['cards_from'];
		$data['cards_from'] = $a;
	}

	$card_numbers_all = new card_numbers();
	$card_numbers_all->set_condition('checker','!=','');
	$card_numbers_all->add_condition('recordStatus','=','O');
	$card_numbers_all->add_condition('card_taken','=','1');
	$card_numbers_all->add_condition('card_number_int','>=',$validate_data['cards_from']);
	$card_numbers_all->add_condition('card_number_int','<=',$validate_data['cards_to']);
	$card_numbers_all->add_condition('recordStatus','=','O');
	$card_numbers_all->set_order_by('pozicija','ASC');
	$card_numbers_all = $broker->get_all_data_condition($card_numbers_all);

	if(sizeof($card_numbers_all) == 0){
		$buffer = array();
		for ($i=$validate_data['cards_from']; $i <= $validate_data['cards_to']; $i++) { 
			$buffer[] = $i;

			if(sizeof($buffer) > 20){
				$SQL = "UPDATE card_numbers SET card_reserved = 1, company_card = ".$validate_data["company"].", company_location = ".$validate_data["company_location"]." WHERE card_number_int IN (".implode($buffer,',').")";
				$broker->execute_query($SQL);
				$buffer = array();
			}else{
				if($i == $validate_data['cards_to']){
					$SQL = "UPDATE card_numbers SET card_reserved = 1, company_card = ".$validate_data["company"].", company_location = ".$validate_data["company_location"]." WHERE card_number_int IN (".implode($buffer,',').")";
					$broker->execute_query($SQL);
				}
			}
		}

		$success = true;
		$message = 'Cards made';
	}else{
		$taken_numbers = array();
		foreach ($card_numbers_all as $key => $value) {
			$taken_numbers[] = $value->card_number_int;
		}

		$message = implode($taken_numbers, ',');
	}
}else{
	$message = $validation_message;
} 




echo json_encode(array("success"=>$success,"message"=>$message));