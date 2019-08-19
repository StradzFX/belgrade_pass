<?php

class CompanyLocationModule{
	
	public static function process_admin_data($item){

		$item->short_location_display = $item->city.', '.$item->part_of_city;
		$item->full_location_display = $item->city.', '.$item->part_of_city.', '.$item->street;

		return $item;
	}

	public static function process_map_data($item){
		global $broker;
		$item->company = SchoolModule::get($item->training_school);
		$item->company->name .= ', '.$item->street;


		$working_times = new working_times();
		$working_times->add_condition('checker','!=','');
		$working_times->add_condition('recordStatus','=','O');
		$working_times->add_condition('ts_location','=',$item->id);
		$working_times = $broker->get_all_data_condition($working_times);

		$item->working_times = array();
		for ($i=0; $i < sizeof($working_times); $i++) { 
			$item->working_times[$working_times[$i]->day_of_week] = $working_times[$i];
		}

		return $item;
	}

	public static function insert($data){
		global $broker;

		if($data['location_id'] == ''){
			$item = new ts_location();
		    $item->training_school = $data['id'];

		    $item->city = $data['city'];
		    $item->part_of_city = $data['part_of_city'];
		    $item->street = $data['street'];

		    $item->email = $data['email'];
		    $item->username = $data['username'];
		    $item->password = md5($data['password']);

		    $item->latitude = $data['latitude'];
		    $item->longitude = $data['longitude'];

		    $item->maker = 'system';
		    $item->makerDate = date('c');
		    $item->checker = 'system';
		    $item->checkerDate = date('c');
		    $item->jezik = 'rs';
		    $item->recordStatus = 'O';
		    
		    $item = $broker->insert($item);
		}else{
			$item = $broker->get_data(new ts_location($data['location_id']));
			$item->training_school = $data['id'];

		    $item->city = $data['city'];
		    $item->part_of_city = $data['part_of_city'];
		    $item->street = $data['street'];

		    $item->email = $data['email'];
		    $item->username = $data['username'];
		    if($data['password'] != ''){
		    	$item->password = md5($data['password']);
		    }
		    
		    $item->latitude = $data['latitude'];
		    $item->longitude = $data['longitude'];

		    $item->checker = 'system';
		    $item->checkerDate = date('c');
		    
		    $broker->update($item);
		}

		$SQL = "DELETE FROM working_times WHERE ts_location = ".$item->id;
		$broker->execute_query($SQL);

		$working_days = $data['working_days'];

		for($i=0;$i<sizeof($working_days);$i++){
			$working_times = new working_times();
		    $working_times->training_school = $data['id'];
		    $working_times->ts_location = $item->id;

		    $working_times->day_of_week = $working_days[$i]['day_of_week'];
		    $working_times->not_working  = $working_days[$i]['not_working'] == 'true' ? '1' : '0';
		    $working_times->working_from_hours = $working_days[$i]['working_from_hours'];
		    $working_times->working_from_minutes = $working_days[$i]['working_from_minutes'];
		    $working_times->working_to_hours = $working_days[$i]['working_to_hours'];
		    $working_times->working_to_minutes = $working_days[$i]['working_to_minutes'];

		    $working_times->maker = 'system';
		    $working_times->makerDate = date('c');
		    $working_times->checker = 'system';
		    $working_times->checkerDate = date('c');
		    $working_times->jezik = 'rs';
		    $working_times->recordStatus = 'O';
		    
		    $working_times = $broker->insert($working_times);
		}

	    return $item;
	}

	public static function remove($id){
		global $broker;

		$item = $broker->get_data(new ts_location($id));
		$item->recordStatus = 'C';
		$broker->update($item);
	}

	public static function list_by_school($id){
		global $broker;

		$item_all = new ts_location();
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

	public static function list_map($filters){
		global $broker;

		$item_all = new ts_location();
		$item_all->set_condition('checker','!=','');
		$item_all->add_condition('recordStatus','=','O');
		$item_all->add_condition('training_school','IN',"(SELECT id FROM training_school WHERE recordStatus = 'O' AND checker != '')");

		if($filters['category'] != ''){
			$item_all->add_condition('training_school','IN',"(SELECT id FROM training_school WHERE recordStatus = 'O' AND checker != '' AND sport_category = ".$filters['category'].")");
		}

		if($filters['search_text'] != ''){
			$item_all->add_condition('training_school','IN',"(SELECT id FROM training_school WHERE recordStatus = 'O' AND checker != '' AND (name LIKE '%".$filters['search_text']."%'))");
		}

		if($filters['location'] != ''){
			$filter_location = explode(',', $filters['location']);
			if(sizeof($filter_location) == 1){
				$item_all->add_condition('','',"(city = '".$filter_location[0]."')");
			}

			if(sizeof($filter_location) == 2){
				$item_all->add_condition('','',"(city = '".$filter_location[0]."' AND part_of_city = '".$filter_location[1]."')");
			}
			
		}

		$item_all->set_order_by('pozicija','DESC');
		$item_all = $broker->get_all_data_condition($item_all);

		for($i=0;$i<sizeof($item_all);$i++){
			$item_all[$i] = self::process_map_data($item_all[$i]);
		}

		return $item_all;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new ts_location($id))){
			  return null;
			}
			$item = $broker->get_data(new ts_location($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new item();
		}

		return self::process_admin_data($item);
	}


	public static function list_cities(){
		global $broker;

		$SQL = "SELECT DISTINCT city FROM ts_location WHERE recordStatus = 'O' AND checker != ''";
		$list = $broker->execute_sql_get_array($SQL);
		return $list;
	}

	public static function list_part_of_cities($city){
		global $broker;

		$SQL = "SELECT DISTINCT part_of_city FROM ts_location WHERE recordStatus = 'O' AND checker != '' AND city = '$city'";
		$list = $broker->execute_sql_get_array($SQL);
		return $list;
	}

	public static function list_cities_select(){
		$list = array();

		$cities = self::list_cities();

		for ($i=0; $i < sizeof($cities); $i++) { 
			$city = array(
				'name' => $cities[$i]['city'],
				'parts' => self::list_part_of_cities($cities[$i]['city'])
			);

			$list[] = $city;
		}

		return $list;

	}

}