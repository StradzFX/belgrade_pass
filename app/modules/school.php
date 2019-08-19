<?php

class SchoolModule{

	public static function save($data){
		if($data['id'] == 0 || $data['id'] == ''){
			return self::insert($data);
		}else{
			return self::update($data);
		}
	}

	public static function insert($data){
		global $broker;
		$item = new training_school();
	    $item->name = $data['name'];
	    $item->sport_category = $data['sport_category'];
	    $item->short_description = $data['short_description'];
	    $item->main_description = $data['main_description'];
	    $item->discount_description = $data['discount_description'];
	    

	    $item->pass_customer_percentage = $data['pass_customer_percentage'];
	    $item->pass_company_percentage = $data['pass_company_percentage'];
	    
	    $item->maker = 'system';
	    $item->featured = 0;
	    $item->number_of_views = 0;
	    $item->makerDate = date('c');
	    $item->checker = 'system';
	    $item->checkerDate = date('c');
	    $item->jezik = 'rs';
	    $item->recordStatus = 'O';
	    
	    $item = $broker->insert($item);

	    return $item;
	}


	public static function update($data){
		global $broker;

		$item = $broker->get_data(new training_school($data['id']));

		$item->name = $data['name'];
		$item->sport_category = $data['sport_category'];
		$item->short_description = $data['short_description'];
		$item->main_description = $data['main_description'];
		$item->discount_description = $data['discount_description'];
		$item->pass_customer_percentage = $data['pass_customer_percentage'];
	    $item->pass_company_percentage = $data['pass_company_percentage'];

	    $broker->update($item);

	    return $item;
	}

	public static function delete($data){
		global $broker;

		$item = $broker->get_data(new training_school($data['id']));

		$item->recordStatus = 'C';

	    $broker->update($item);

	    return $item;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new training_school($id))){
			  return null;
			}
			$item = $broker->get_data(new training_school($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new training_school();
		}

		return self::process_admin_data($item);
	}

	public static function get($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new training_school($id))){
			  return null;
			}
			$item = $broker->get_data(new training_school($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new training_school();
		}

		return self::process_data($item);
	}

	public static function get_admin_list(){
		global $broker;

		$list = new training_school();
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_admin_data($list[$i]);
		}

		return $list;
	}

	public static function process_admin_data($item){

		$item->category_display = CategoryModule::get_admin_data($item->sport_category);
		$item->category_name = $item->category_display->name;

		$item->coaches = CoachModule::list_by_school($item->id);
		$item->gallery = SchoolPictureModule::list_by_school($item->id);
		$item->locations = CompanyLocationModule::list_by_school($item->id);
		$item->programms = SchoolProgrammModule::list_by_school($item->id);

		return $item;
	}

	public static function process_data($item){

		$item->category_display = CategoryModule::get($item->sport_category);
		$item->category_name = $item->category_display->name;

		$item->coaches = CoachModule::list_by_school_public($item->id);
		$item->gallery = SchoolPictureModule::list_by_school_public($item->id);
		$item->locations = CompanyLocationModule::list_by_school($item->id);
		$item->programms = SchoolProgrammModule::list_by_school($item->id);

		if(sizeof($item->gallery) > 0){
			$item->thumb = '';
			for($i=0;$i<sizeof($item->gallery);$i++){
				if($item->gallery[$i]->thumb == 1){
					$item->thumb = $item->gallery[$i];
					$item->thumb = 'pictures/ts_picture/picture/'.$item->thumb->picture;
					break;
				}
			}
			
		}else{
			$item->thumb = '';
		}

		$item->link = 'company/'.$item->id.'/';

		$item->short_location_display = 'N/A';
		if(sizeof($item->locations) > 0){
			if(sizeof($item->locations) > 1){
				$item->short_location_display = 'Several locations';
			}else{
				$item->short_location_display = $item->locations[0]->short_location_display;
			}
		}

		$max_short_length = 120;
		if(strlen($item->short_description) > $max_short_length){
			$item->short_description = mb_substr($item->short_description, 0,$max_short_length-3).'...';
		}
		

		return $item;
	}

	public static function promote($school_id){
		global $broker;

		$broker->execute_query("UPDATE training_school SET promoted = CASE WHEN promoted = 1 THEN 0 ELSE 1 END WHERE id = $school_id");
	}


	public static function get_home_featured(){
		global $broker;

		$list = new training_school();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('pass_options','=','1');
		$list->add_condition('promoted','=',1);
		$list->set_order_by('pozicija','DESC');
		$list->set_limit(3);
		$list = $broker->get_all_data_condition_limited($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function update_username($data){
		global $broker;

		$success = false;
		$message = 'Something went wrong';
		$school = self::get($data['id']);
		if($school->username == ''){
			if($data['username'] == ''){
				$message = 'Please fill username';
			}else{
				if($data['password'] == ''){
					$message = 'Please fill passwoord';
				}else{
					$school->username = $data['username'];
					$school->password = md5($data['password']);
					$SQL = "UPDATE training_school SET username = '".$school->username."', password = '".$school->password."' WHERE id = ".$school->id;
					$broker->execute_query($SQL);
					$success = true;
					$message = 'Username and password changed';
				}
			}
		}else{
			if($data['username'] == ''){
				$message = 'Please fill username';
			}else{
				if($data['password'] != ''){
					$school->username = $data['username'];
					$school->password = md5($data['password']);
					$SQL = "UPDATE training_school SET username = '".$school->username."', password = '".$school->password."' WHERE id = ".$school->id;
					$broker->execute_query($SQL);
					$success = true;
					$message = 'Username and password changed';
				}else{
					$school->username = $data['username'];
					$SQL = "UPDATE training_school SET username = '".$school->username."' WHERE id = ".$school->id;
					$broker->execute_query($SQL);
					$success = true;
					$message = 'Username changed';
				}
			}
		}

		return array($success,$message);
	}

	public static function get_home_trending(){
		global $broker;

		$list = new training_school();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('pass_options','=','1');
		$list->set_order_by('number_of_views','DESC');
		$list->set_limit(3);
		$list = $broker->get_all_data_condition_limited($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function get_search($filters){
		global $broker;

		$list = new training_school();
		$list->set_condition('checker','!=','');
		if($filters['category'] != ''){
			$list->add_condition('id','IN',"(SELECT DISTINCT company FROM company_category WHERE category = ".$filters['category']." AND recordStatus = 'O')");
		}

		if($filters['search_text'] != ''){
			$list->add_condition('','',"(name LIKE '%".$filters['search_text']."%')");
		}

		if($filters['location'] != ''){
			$list->add_condition('id','IN',"(SELECT training_school FROM ts_location WHERE city LIKE '%".$filters['location']."%' OR part_of_city LIKE '%".$filters['location']."%')");
			
		}

		
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('number_of_views','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function record_view($id){
		global $broker;

		$school = self::get($id);

		$SQL = "UPDATE training_school SET number_of_views = number_of_views + 1 WHERE id = $id";
		$broker->execute_query($SQL);

		CategoryModule::record_popularity($school->sport_category,1);
	}

}