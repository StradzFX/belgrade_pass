<?php

class SchoolProgrammModule{
	
	public static function process_admin_data($item){
		global $broker;


		$item->location_name = $broker->get_data(new ts_location($item->ts_location));
		$item->location_name = $item->location_name->city.', '.$item->location_name->part_of_city;

		$item->list_days = SchoolProgrammDayModule::list_by_programm($item->id);

		$item->display_list_days = SchoolProgrammDayModule::list_by_programm($item->id);

		$item->days = array();
		for($i=0;$i<sizeof($item->list_days);$i++){
			$item->list_days[$i]->periods = array();
			$item->days[$item->list_days[$i]->day_of_week] = $item->list_days[$i];
		}

		$item->number_of_days = sizeof($item->list_days);

		return $item;
	}

	public static function insert($data){
		global $broker;

		$item = new ts_programm();
	    $item->training_school = $data['id'];
	    $item->ts_location = $data['ts_location'];

	    $item->name = $data['name'];
	    $item->age_from = $data['age_from'];
	    $item->age_to = $data['age_to'];

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

		$item = $broker->get_data(new ts_programm($id));
		$item->recordStatus = 'C';
		$broker->update($item);
	}

	public static function list_by_school($id){
		global $broker;

		$item_all = new ts_programm();
		$item_all->set_condition('checker','!=','');
		$item_all->add_condition('recordStatus','=','O');
		$item_all->add_condition('training_school','=',$id);
		$item_all->set_order_by('pozicija','DESC');
		$item_all = $broker->get_all_data_condition($item_all);

		for($i=0;$i<sizeof($item_all);$i++){
			$item_all[$i] = self::process_admin_data($item_all[$i]);
		}

		return $item_all;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new ts_programm($id))){
			  return null;
			}
			$item = $broker->get_data(new ts_programm($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new item();
		}

		return self::process_admin_data($item);
	}


	public static function save_days($data){
		global $broker;

		$id = $data['days_programm_id'];

		$broker->execute_query("DELETE FROM tspd_periods WHERE tsp_day_of_week IN (SELECT id FROM tsp_day_of_week WHERE ts_programm = $id)");

		$broker->execute_query("DELETE FROM tsp_day_of_week WHERE ts_programm = $id");

		$days = $data['days'];
		for($i=0;$i<sizeof($days);$i++){
			$day = $days[$i];

			$tsp_day_of_week = new tsp_day_of_week();
		    $tsp_day_of_week->ts_programm = $id;
		    $tsp_day_of_week->name = '';
		    $tsp_day_of_week->day_of_week = $day['id'];
		    $tsp_day_of_week->trainer = $day['coach'];
		    $tsp_day_of_week->maker = 'system';
		    $tsp_day_of_week->makerDate = date('c');
		    $tsp_day_of_week->checker = 'system';
		    $tsp_day_of_week->checkerDate = date('c');
		    $tsp_day_of_week->jezik = 'rs';
		    $tsp_day_of_week->recordStatus = 'O';
		    
		    $tsp_day_of_week = $broker->insert($tsp_day_of_week);
		    for($j=0;$j<sizeof($day['periods']);$j++){
		    	$period = $day['periods'][$j];
		    	$tspd_periods = new tspd_periods();
			    $tspd_periods->tsp_day_of_week = $tsp_day_of_week->id;
			    $tspd_periods->time_from = $period['from'];
			    $tspd_periods->time_from = explode(':', $tspd_periods->time_from);
			    $tspd_periods->time_from = $tspd_periods->time_from[0]*60+$tspd_periods->time_from[1];
			    $tspd_periods->time_to = $period['to'];
			    $tspd_periods->time_to = explode(':', $tspd_periods->time_to);
			    $tspd_periods->time_to = $tspd_periods->time_to[0]*60+$tspd_periods->time_to[1];
			    $tspd_periods->price = $period['price'];
			    $tspd_periods->ccy = $period['ccy'];
			    $tspd_periods->trainer = $period['period_coach'];
			    $tspd_periods->maker = 'system';
			    $tspd_periods->makerDate = date('c');
			    $tspd_periods->checker = 'system';
			    $tspd_periods->checkerDate = date('c');
			    $tspd_periods->jezik = 'rs';
			    $tspd_periods->recordStatus = 'O';
			    
			    $tspd_periods = $broker->insert($tspd_periods);
		    }
		}

		return $tsp_day_of_week;
	}

}