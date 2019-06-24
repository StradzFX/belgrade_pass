<?php

class CoachModule{

	public static function save($data){
		if($data['id'] == 0 || $data['id'] == ''){
			return self::insert($data);
		}else{
			return self::update($data);
		}
	}

	public static function insert($data){
		global $broker;
		$item = new trainer();
	    $item->first_name = $data['first_name'];
	    $item->last_name = $data['last_name'];
	    $item->short_description = $data['short_description'];
	    $item->sport_category = $data['sport_category'];

	    $image = $data['new_photo'];
	    if($image != ''){
	    	list($type, $image) = explode(';', $image);
			list(, $image)      = explode(',', $image);
			$image = base64_decode($image);
			$image_name = $user_id.'_'.time().'.jpg';
			$user_file_location = 'pictures/trainer/photo/'.$image_name;
			file_put_contents($user_file_location, $image);
			$photo = $image_name;
			$item->photo = $photo;
	    }

	    $item->maker = 'system';
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

		$item = $broker->get_data(new trainer($data['id']));

		$item->first_name = $data['first_name'];
	    $item->last_name = $data['last_name'];
	    $item->short_description = $data['short_description'];
	    $item->sport_category = $data['sport_category'];

	    $image = $data['new_photo'];
	    if($image != ''){
	    	list($type, $image) = explode(';', $image);
			list(, $image)      = explode(',', $image);
			$image = base64_decode($image);
			$image_name = $user_id.'_'.time().'.jpg';
			$user_file_location = 'pictures/trainer/photo/'.$image_name;
			file_put_contents($user_file_location, $image);
			$photo = $image_name;
			$item->photo = $photo;
	    }

	    $broker->update($item);

	    return $item;
	}

	public static function delete($data){
		global $broker;

		$item = $broker->get_data(new trainer($data['id']));

		$item->recordStatus = 'C';

	    $broker->update($item);

	    return $item;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new trainer($id))){
			  return null;
			}
			$item = $broker->get_data(new trainer($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new trainer();
		}

		return self::process_admin_data($item);
	}

	public static function get($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new trainer($id))){
			  return null;
			}
			$item = $broker->get_data(new trainer($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new trainer();
		}

		return self::process_data($item);
	}

	public static function get_admin_list($category_id=null){
		global $broker;

		$list = new trainer();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		if($category_id){
			$list->add_condition('sport_category','=',$category_id);
		}
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_admin_data($list[$i]);
		}

		return $list;
	}

	public static function get_search($filters){
		global $broker;

		$list = new trainer();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');

		if($filters['category'] != ''){
			$list->add_condition('sport_category','=',$filters['category']);
		}

		if($filters['search_text'] != ''){
			$list->add_condition('','',"(CONCAT(first_name,' ',last_name) LIKE '%".$filters['search_text']."%' OR CONCAT(last_name,' ',first_name) LIKE '%".$filters['search_text']."%')");
		}

		$list->set_order_by('first_name','ASC');
		$list->set_order_by('last_name','ASC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}


	

	public static function process_admin_data($item){

		$item->full_name = $item->first_name.' '.$item->last_name;
		$item->photo_display = '../pictures/trainer/photo/'.$item->photo;

		$item->gallery = CoachPictureModule::list_by_coach($item->id);

		$item->category_display = CategoryModule::get_admin_data($item->sport_category);

		return $item;
	}

	public static function process_data($item){

		$item->full_name = $item->first_name.' '.$item->last_name;
		$item->photo_display = 'pictures/trainer/photo/'.$item->photo;

		$item->category_display = CategoryModule::get($item->sport_category);
		$item->gallery = CoachPictureModule::list_by_coach_public($item->id);

		$item->link = 'coach/'.$item->id.'/';

		return $item;
	}


	public static function list_by_school($id){
		global $broker;
		
		$list = new trainer();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('id','IN',"(SELECT trainer FROM ts_trainers WHERE training_school = $id AND recordStatus = 'O' AND checker != '')");
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_admin_data($list[$i]);
		}

		return $list;
	}

	public static function list_by_school_public($id){
		global $broker;
		
		$list = new trainer();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('id','IN',"(SELECT trainer FROM ts_trainers WHERE training_school = $id AND recordStatus = 'O' AND checker != '')");
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function has_school_coach($school_id,$trainer_id){
		global $broker;
		
		$list = new ts_trainers();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('training_school','=',$school_id);
		$list->add_condition('trainer','=',$trainer_id);
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		return sizeof($list) > 0;
	}

	public static function remove_school_coach($school_id,$trainer_id){
		global $broker;

		$list = new ts_trainers();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('training_school','=',$school_id);
		$list->add_condition('trainer','=',$trainer_id);
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		if(sizeof($list) > 0){
			$item = $list[0];
			$item->recordStatus = 'C';
			$broker->delete($item);
		}
		
	}

	public static function insert_school_coach($data){
		global $broker;

		$item = new ts_trainers();
	    $item->training_school = $data['id'];
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


	public static function get_home_latest(){
		global $broker;
		
		$list = new trainer();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('pozicija','DESC');
		$list->set_limit(3);
		$list = $broker->get_all_data_condition_limited($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

}