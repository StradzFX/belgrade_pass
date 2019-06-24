<?php

$post_office_list = PaymentModule::list_payments_admin('post_office',null,15);
$payment_card_list = PaymentModule::list_payments_admin('credit_card',null,15);
$company_payment_list = PaymentModule::list_payments_admin('company',null,15);

$total_users = UserModule::total();
$total_companies = CompanyModule::total();
$total_cards = CardModule::total();
$total_payments = PaymentModule::total();