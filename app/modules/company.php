<?php

class CompanyModule{
	public static function total(){
		global $broker;

		$list = new training_school();
		$list->add_condition('recordStatus','=','O');
		return $broker->get_count_condition($list);
	}
}