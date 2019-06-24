<?php

class KryptonAdminModule{
	public static function get_user($username){
		global $broker;

		$item = new xenon_user();
		$item->add_condition('username','=',$username);
		$item->set_order_by('id','DESC');
		$item = $broker->get_all_data_condition($item);

		return sizeof($item) > 0 ? $item[0] : null;
	}
}