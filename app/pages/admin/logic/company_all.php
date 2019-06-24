<?php


$list = SchoolModule::get_admin_list();


for ($i=0; $i < sizeof($list); $i++) {
	$list[$i]->card_usage_total = CardModule::get_card_usage_total($list[$i]->id);
}