<?php 

class PackageModule{
	public static function get_package_by_amount($amount){
		global $broker;

		$list = new card_package();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('price','=',$amount);
		$list = $broker->get_all_data_condition($list);

		return sizeof($list) > 0 ? $list[0] : null;

	}	
}