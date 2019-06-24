<?php

class SchoolPictureModule{
	
	public static function process_admin_data($item){

		$item->display_picture = '../pictures/ts_picture/picture/'.$item->picture;

		return $item;
	}

	public static function process_data($item){

		$item->display_picture = 'pictures/ts_picture/picture/'.$item->picture;

		return $item;
	}

	public static function insert($data){
		global $broker;

		$image = $data['image'];
		list($type, $image) = explode(';', $image);
		list(, $image)      = explode(',', $image);
		$image = base64_decode($image);
		$image_name = $user_id.'_'.time().'.jpg';
		$user_file_location = 'pictures/ts_picture/picture/'.$image_name;
		file_put_contents($user_file_location, $image);

		$ts_picture = new ts_picture();
	    $ts_picture->training_school = $data['id'];
	    $ts_picture->picture = $image_name;
	    $ts_picture->thumb = self::has_thumb_picture($ts_picture->training_school) ? 0 : 1;
	    $ts_picture->maker = 'system';
	    $ts_picture->makerDate = date('c');
	    $ts_picture->checker = 'system';
	    $ts_picture->checkerDate = date('c');
	    $ts_picture->jezik = 'rs';
	    $ts_picture->recordStatus = 'O';
	    
	    $ts_picture = $broker->insert($ts_picture);

	    return $ts_picture;
	}


	public static function has_thumb_picture($id){
		global $broker;
		
		$ts_picture_all = new ts_picture();
		$ts_picture_all->set_condition('checker','!=','');
		$ts_picture_all->add_condition('training_school','=',$id);
		$ts_picture_all->add_condition('recordStatus','=','O');
		$ts_picture_all->add_condition('thumb','=','1');
		$ts_picture_all->set_order_by('pozicija','DESC');
		$ts_picture_count = $broker->get_count_condition($ts_picture_all);

		return $ts_picture_count > 0;
	}

	public static function set_thumb($school_id,$picture_id){
		global $broker;

		$broker->execute_query("UPDATE ts_picture SET thumb = 0 WHERE training_school = $school_id");

		$broker->execute_query("UPDATE ts_picture SET thumb = 1 WHERE id = $picture_id");

		return true;

	}

	public static function remove($id){
		global $broker;

		$item = $broker->get_data(new ts_picture($id));
		$item->recordStatus = 'C';
		$broker->update($item);
	}

	public static function list_by_school($id){
		global $broker;

		$ts_picture_all = new ts_picture();
		$ts_picture_all->set_condition('checker','!=','');
		$ts_picture_all->add_condition('training_school','=',$id);
		$ts_picture_all->add_condition('recordStatus','=','O');
		$ts_picture_all->set_order_by('pozicija','DESC');
		$ts_picture_all = $broker->get_all_data_condition($ts_picture_all);

		for($i=0;$i<sizeof($ts_picture_all);$i++){
			$ts_picture_all[$i] = self::process_admin_data($ts_picture_all[$i]);
		}

		return $ts_picture_all;
	}

	public static function list_by_school_public($id){
		global $broker;

		$ts_picture_all = new ts_picture();
		$ts_picture_all->set_condition('checker','!=','');
		$ts_picture_all->add_condition('training_school','=',$id);
		$ts_picture_all->add_condition('recordStatus','=','O');
		$ts_picture_all->set_order_by('pozicija','DESC');
		$ts_picture_all = $broker->get_all_data_condition($ts_picture_all);

		for($i=0;$i<sizeof($ts_picture_all);$i++){
			$ts_picture_all[$i] = self::process_data($ts_picture_all[$i]);
		}

		return $ts_picture_all;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new ts_picture($id))){
			  return null;
			}
			$item = $broker->get_data(new ts_picture($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new ts_picture();
		}

		return self::process_admin_data($item);
	}

}