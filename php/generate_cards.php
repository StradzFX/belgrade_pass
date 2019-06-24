<?php

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->set_order_by('pozicija','DESC');
$card_numbers_all->set_limit(1);
$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

if(sizeof($card_numbers_all) == 0){
	$start_number = 1;
}else{
	$card_numbers_all = $card_numbers_all[0];
	$start_number = $card_numbers_all->card_number+1;
}


for ($i=0; $i < 500; $i++) { 

	$card_number = $start_number;

	if($card_number < 100000){
		if($card_number < 10000){
			if($card_number < 1000){
				if($card_number < 100){
					if($card_number < 10){
						$card_number = '00000'.$card_number;
					}else{
						$card_number = '0000'.$card_number;
					}
				}else{
					$card_number = '000'.$card_number;
				}
			}else{
				$card_number = '00'.$card_number;
			}
		}else{
			$card_number = '0'.$card_number;
		}
	}

	$niz_slova = array(1,2,3,4,5,6,7,8,9);
	$c1 = $niz_slova[rand(0,sizeof($niz_slova)-1)];
	$c2 = $niz_slova[rand(0,sizeof($niz_slova)-1)];
	$c3 = $niz_slova[rand(0,sizeof($niz_slova)-1)];
	$c4 = $niz_slova[rand(0,sizeof($niz_slova)-1)];

	$card_password = $c1.$c2.$c3.$c4;

	$card_numbers = new card_numbers();
	$card_numbers->card_number = $card_number;
	$card_numbers->card_password = $card_password;
	$card_numbers->card_taken = 0;
	$card_numbers->user = 0;
	$card_numbers->maker = 'system';
	$card_numbers->makerDate = date('c');
	$card_numbers->checker = 'system';
	$card_numbers->checkerDate = date('c');
	$card_numbers->jezik = 'rs';
	$card_numbers->recordStatus = 'O';

	$card_numbers = $broker->insert($card_numbers);

	$start_number++;
}

?>

<meta http-equiv="refresh" content="2">