<?php

for ($i=500; $i <= 10000; $i+=500) { 
	$card_package = new card_package();
    $card_package->name = 'Paket '.$i;
    $card_package->picture = '';
    $card_package->price = $i;
    $card_package->to_company = 0;
    $card_package->to_us = 0;
    $card_package->duration_days = 365;
    $card_package->number_of_passes = $i;
    $card_package->best_value = 0;
    $card_package->maker = 'system';
    $card_package->makerDate = date('c');
    $card_package->checker = 'system';
    $card_package->checkerDate = date('c');
    $card_package->jezik = 'rs';
    $card_package->recordStatus = 'O';
    
    $card_package = $broker->insert($card_package);
}