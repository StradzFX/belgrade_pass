<?php

class CoachPictureModule{
	
	public static function process_admin_data($item){

		$item->display_picture = '../pictures/t_picture/picture/'.$item->picture;

		return $item;
	}

	public static function process_data($item){

		$item->display_picture = 'pictures/t_picture/picture/'.$item->picture;

		return $item;
	}

	public static function insert($data){
		global $broker;

		$image = $data['image'];
		list($type, $image) = explode(';', $image);
		list(, $image)      = explode(',', $image);
		$image = base64_decode($image);
		$image_name = $user_id.'_'.time().'.jpg';
		$user_file_location = 'pictures/t_picture/picture/'.$image_name;
		file_put_contents($user_file_location, $image);

		$t_picture = new t_picture();
	    $t_picture->trainer = $data['id'];
	    $t_picture->picture = $image_name;
	    $t_picture->maker = 'system';
	    $t_picture->makerDate = date('c');
	    $t_picture->checker = 'system';
	    $t_picture->checkerDate = date('c');
	    $t_picture->jezik = 'rs';
	    $t_picture->recordStatus = 'O';
	    
	    $t_picture = $broker->insert($t_picture);

	    return $t_picture;
	}

	public static function remove($id){
		global $broker;

		$item = $broker->get_data(new t_picture($id));
		$item->recordStatus = 'C';
		$broker->update($item);
	}

	public static function list_by_coach($id){
		global $broker;

		$t_picture_all = new t_picture();
		$t_picture_all->set_condition('checker','!=','');
		$t_picture_all->add_condition('trainer','=',$id);
		$t_picture_all->add_condition('recordStatus','=','O');
		$t_picture_all->set_order_by('pozicija','DESC');
		$t_picture_all = $broker->get_all_data_condition($t_picture_all);

		for($i=0;$i<sizeof($t_picture_all);$i++){
			$t_picture_all[$i] = self::process_admin_data($t_picture_all[$i]);
		}

		return $t_picture_all;
	}

	public static function list_by_coach_public($id){
		global $broker;

		$t_picture_all = new t_picture();
		$t_picture_all->set_condition('checker','!=','');
		$t_picture_all->add_condition('trainer','=',$id);
		$t_picture_all->add_condition('recordStatus','=','O');
		$t_picture_all->set_order_by('pozicija','DESC');
		$t_picture_all = $broker->get_all_data_condition($t_picture_all);

		for($i=0;$i<sizeof($t_picture_all);$i++){
			$t_picture_all[$i] = self::process_data($t_picture_all[$i]);
		}

		return $t_picture_all;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new t_picture($id))){
			  return null;
			}
			$item = $broker->get_data(new t_picture($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new t_picture();
		}

		return self::process_admin_data($item);
	}

}