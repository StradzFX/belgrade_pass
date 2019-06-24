<?php
$company = SchoolModule::get($url_params[0]);
$card_list = CardModule::list_company_cards_admin($url_params[0]);