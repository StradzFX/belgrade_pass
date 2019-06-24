<?php 

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->add_condition('internal_reservation','=','1');
$card_numbers_all->add_condition('card_taken','=','0');
$card_numbers_all->set_order_by('id','ASC');
$card_numbers_all = $broker->get_all_data_condition($card_numbers_all);

for($i=0;$i<sizeof($card_numbers_all);$i++){
}
