<?php

interface base_domain_object
{
	public function get_domain_name();
	public function get_attribute_list();
	public function get_attribute_values();
	
	public function get_condition();
	public function set_condition($item,$sign,$value);
	public function add_condition($item,$sign,$value,$addOn="AND");
	public function add_group_condition($nizUslova,$mainUslov="AND");
	public function delete_condition();
	
	public function get_order_by();
	public function set_order_by($order_by,$direction="");
	public function add_order_by($order_by,$direction="");
	public function delete_order_by();
	
	public function get_id();
	public function set_id($id);
	public function get_update_values();
	
	public function get_object($row);
	public function get_limit();
	public function set_limit($limit,$from=0);
}
?>