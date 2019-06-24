<?php 

include_once 'vendor/phpqrcode/qrlib.php';





$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->add_condition('','',"(picture IS NULL OR picture = '')");
$card_numbers_all->set_order_by('id','ASC');
$card_numbers_all->set_limit(50);
$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

for($i=0;$i<sizeof($card_numbers_all);$i++){
	$card_number = $card_numbers_all[$i]->card_number;
	$approval_code = $card_numbers_all[$i]->card_password;

	QRcode::png("https://www.belgradepass.com/company_approval/?card=$card_number&approval_code=$approval_code", "files/qr_codes/$card_number.png",QR_ECLEVEL_L,80,1); // creates file 

	$card_numbers_all[$i]->picture = "$card_number.png";
	$broker->update($card_numbers_all[$i]);

}

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->add_condition('','',"(picture IS NULL OR picture = '')");
$card_numbers_left = $broker->get_count_condition($card_numbers_all);
$card_numbers_left = number_format($card_numbers_left,0,',','.');

?>
<meta http-equiv="refresh" content="2">

<?php echo $card_numbers_left; ?>