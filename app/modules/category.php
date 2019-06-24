<?php

class CategoryModule{

	public static function save($data){
		if($data['id'] == 0 || $data['id'] == ''){
			return self::insert($data);
		}else{
			return self::update($data);
		}
	}

	public static function insert($data){
		global $broker;

		$item = new sport_category();
	    $item->name = $data['name'];
	    
	    $image = $data['new_logo'];
	    if($image != ''){
			$item->logo = $image;
	    }
		

		$image = $data['new_map_logo'];
		if($image != ''){
			list($type, $image) = explode(';', $image);
			list(, $image)      = explode(',', $image);
			$image = base64_decode($image);
			$image_name = $user_id.'_'.time().'.jpg';
			$user_file_location = 'pictures/sport_category/map_logo/'.$image_name;
			file_put_contents($user_file_location, $image);
			$map_logo = $image_name;
			$item->map_logo = $map_logo;
		}

		$item->popularity = 0;
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

		$item = $broker->get_data(new sport_category($data['id']));

		$item->name = $data['name'];
	    
	    $image = $data['new_logo'];
	    if($image != ''){
			$item->logo = $image;
	    }
		

		$image = $data['new_map_logo'];
		if($image != ''){
			list($type, $image) = explode(';', $image);
			list(, $image)      = explode(',', $image);
			$image = base64_decode($image);
			$image_name = $user_id.'_'.time().'.jpg';
			$user_file_location = 'pictures/sport_category/map_logo/'.$image_name;
			file_put_contents($user_file_location, $image);
			$map_logo = $image_name;
			$item->map_logo = $map_logo;
		}

	    $broker->update($item);

	    return $item;
	}

	public static function delete($data){
		global $broker;

		$SQL = "DELETE FROM sport_category WHERE id = ".$data['id'];
		$broker->execute_query($SQL);

		$item = $broker->get_data(new sport_category($data['id']));

		$item->recordStatus = 'C';

	    $broker->update($item);

	    return $item;
	}

	public static function get_admin_data($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new sport_category($id))){
			  return null;
			}
			$item = $broker->get_data(new sport_category($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new sport_category();
		}

		return self::process_admin_data($item);
	}

	public static function get($id){
		global $broker;

		if($id > 0){
			if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new sport_category($id))){
			  return null;
			}
			$item = $broker->get_data(new sport_category($id));

			if($item->recordStatus == 'C'){
				return null;
			}
		}else{
			$item = new sport_category();
		}

		return self::process_data($item);
	}

	public static function get_admin_list(){
		global $broker;

		$list = new sport_category();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_admin_data($list[$i]);
		}

		return $list;
	}

	public static function list_all(){
		global $broker;

		$list = new sport_category();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('name','ASC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function list_all_popular(){
		global $broker;

		$list = new sport_category();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->set_order_by('popularity','DESC');
		$list = $broker->get_all_data_condition($list);

		for($i=0;$i<sizeof($list);$i++){
			$list[$i] = self::process_data($list[$i]);
		}

		return $list;
	}

	public static function process_admin_data($item){

		$item->logo_display = $item->logo != '' ? '../pictures/sport_category/logo/'.$item->logo : '../public/images/_general/default_logo.png';

		$item->logo_display = $item->logo != '' ? '../pictures/sport_category/logo/'.$item->logo : '../public/images/_general/default_logo.png';

		$item->map_logo_display = $item->map_logo != '' ? '../pictures/sport_category/map_logo/'.$item->map_logo : '../public/images/_general/default_logo.png';

		return $item;
	}

	public static function process_data($item){

		$item->logo_display = $item->logo != '' ? 'pictures/sport_category/logo/'.$item->logo : 'public/images/_general/default_logo.png';

		$item->map_logo_display = $item->map_logo != '' ? 'pictures/sport_category/map_logo/'.$item->map_logo : 'public/images/_general/default_logo.png';

		$item->link = 'category/'.$item->id.'/';

		return $item;
	}


	public static function record_popularity($id,$points){
		global $broker;

		$SQL = "UPDATE sport_category SET popularity = popularity + $points WHERE id = $id";
		$broker->execute_query($SQL);
	}

}