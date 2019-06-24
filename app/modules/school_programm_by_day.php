<?php

class SchoolProgrammDayModule{
	
	public static function process_admin_data($item){
		global $broker;

		$item->periods = self::list_periods($item->id);

		return $item;
	}

	public static function process_period_admin_data($item){
		global $broker;

		$time_from_hours = floor($item->time_from/60);
		$time_from_minutes = $item->time_from - $time_from_hours*60;
		$time_from_hours = $time_from_hours < 10 ? '0'.$time_from_hours : $time_from_hours;
		$time_from_minutes = $time_from_minutes < 10 ? '0'.$time_from_minutes : $time_from_minutes;
		$item->display_time_from = $time_from_hours.':'.$time_from_minutes;


		$time_to_hours = floor($item->time_to/60);
		$time_to_minutes = $item->time_to - $time_to_hours*60;
		$time_to_hours = $time_to_hours < 10 ? '0'.$time_to_hours : $time_to_hours;
		$time_to_minutes = $time_to_minutes < 10 ? '0'.$time_to_minutes : $time_to_minutes;
		$item->display_time_to = $time_to_hours.':'.$time_to_minutes;

		return $item;
	}

	public static function insert($data){
		global $broker;

		$item = new tsp_day_of_week();
	    $item->training_school = $data['id'];
	    $item->ts_programm = $data['ts_programm'];

	    $item->name = $data['name'];
	    $item->day_of_week = $data['day_of_week'];

	    $item->trainer = $data['trainer'];

	    $item->maker = 'system';
	    $item->makerDate = date('c');
	    $item->checker = 'system';
	    $item->checkerDate = date('c');
	    $item->jezik = 'rs';
	    $item->recordStatus = 'O';
	    
	    $item = $broker->insert($item);

	    return $item;
	}

	public static function remove($id){
		global $broker;

		$item = $broker->get_data(new tsp_day_of_week($id));
		$item->recordStatus = 'C';
		$broker->update($item);
	}

	public static function list_by_programm($id){
		global $broker;

		$item_all = new tsp_day_of_week();
		$item_all->set_condition('checker','!=','');
		$item_all->add_condition('recordStatus','=','O');
		$item_all->add_condition('ts_programm','=',$id);
		$item_all->set_order_by('pozicija','ASC');
		$item_all = $broker->get_all_data_condition($item_all);

		for($i=0;$i<sizeof($item_all);$i++){
			$item_all[$i] = self::process_admin_data($item_all[$i]);
		}

		return $item_all;
	}

	public static function get_by_program_and_day($id,$day_of_week){
		global $broker;

		$item_all = new tsp_day_of_week();
		$item_all->set_condition('checker','!=','');
		$item_all->add_condition('recordStatus','=','O');
		$item_all->add_condition('ts_programm','=',$id);
		$item_all->add_condition('day_of_week','=',$day_of_week);
		$item_all->set_order_by('pozicija','DESC');
		$item_all = $broker->get_all_data_condition($item_all);

		return sizeof($item_all) > 0 ? self::process_admin_data($item_all[0]) : null;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new tsp_day_of_week($id))){
			  return null;
			}
			$item = $broker->get_data(new tsp_day_of_week($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new item();
		}

		return self::process_admin_data($item);
	}

	public static function list_periods($id){
		global $broker;

		$item_all = new tspd_periods();
		$item_all->set_condition('checker','!=','');
		$item_all->add_condition('recordStatus','=','O');
		$item_all->add_condition('tsp_day_of_week','=',$id);
		$item_all->set_order_by('pozicija','DESC');
		$item_all = $broker->get_all_data_condition($item_all);

		for ($i=0; $i < sizeof($item_all); $i++) { 
			$item_all[$i] = self::process_period_admin_data($item_all[$i]);
		}

		return $item_all;
	}

}