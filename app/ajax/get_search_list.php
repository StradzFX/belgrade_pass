<?php

$post_data = $_POST;
$filters = $post_data['filters'];


$list = CompanyLocationModule::list_map($filters);

for ($i=0; $i < sizeof($list); $i++) { 
	$sport_category_all = new sport_category();
	$sport_category_all->set_condition('checker','!=','');
	$sport_category_all->add_condition('recordStatus','=','O');
	$sport_category_all->add_condition('id','IN',"(SELECT DISTINCT category FROM company_category WHERE company = ".$list[$i]->company->id." AND recordStatus = 'O')");
	$sport_category_all->set_order_by('pozicija','DESC');
	$list[$i]->company->categories =  $broker->get_all_data_condition($sport_category_all);

}

?>
<?php for ($i=0;$i<sizeof($list);$i++) {
	$display_location = $list[$i];
	$company = $list[$i]->company; ?>
	<?php include 'app/pages/views/elements/presentation/company/_thumbnail.php'; ?>
<?php } ?>