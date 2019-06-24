<?php
require_once "base_domain_object.php";
class company_events implements base_domain_object
{
	public $id = 0;
	public $training_school = 0;
	public $event_date = "";
	public $event_time_from = 0;
	public $event_time_to = 0;
	public $event_type = "";
	public $event_name = "";
	public $event_horus_from = "";
	public $event_hours_to = "";
	public $event_minutes_from = "";
	public $event_minutes_to = "";
	public $ts_location = 0;
	public $company_birthday_data = 0;
	public $company_location_birthday_slots = 0;
	public $event_global_type = "";
	public $maker = "";
	public $makerDate = "";
	public $checker = "";
	public $checkerDate = "";
	public $jezik = "";
	public $pozicija = "";
	public $recordStatus = "";
	public $modNumber = "";
	public $multilang_id = 0;
	//Properties
	public $condition = "";
	public $customSQL = "";
	public $order_by  = "pozicija";
	public $limit  = 600;
	public $direction  = "DESC";

	private $varchar = array("event_date","event_type","event_name","event_horus_from","event_hours_to","event_minutes_from","event_minutes_to","event_global_type","maker","makerDate","checker","checkerDate","jezik","recordStatus");

	public $domain_fields_array = array("id","training_school","event_date","event_time_from","event_time_to","event_type","event_name","event_horus_from","event_hours_to","event_minutes_from","event_minutes_to","ts_location","company_birthday_data","company_location_birthday_slots","event_global_type");

	private $display_elements_formats = array();
	public $format_options = NULL; 
	
	//Constructor and Domain name
	public function __construct($id = 0, $training_school = 0, $event_date = "", $event_time_from = 0, $event_time_to = 0, $event_type = "", $event_name = "", $event_horus_from = "", $event_hours_to = "", $event_minutes_from = "", $event_minutes_to = "", $ts_location = 0, $company_birthday_data = 0, $company_location_birthday_slots = 0, $event_global_type = "", $maker = "",$makerDate = "",$checker = "",$checkerDate = "",$pozicija="",$jezik="",$recordStatus="",$modNumber="",$multilang_id = 0)
	{
		if(is_numeric($id)){ $this->id = $id;}else{$this->id = 0;}
		if(is_numeric($training_school)){ $this->training_school = $training_school;}else{$this->training_school = 0;}
		$this->event_date = $event_date;
		if(is_numeric($event_time_from)){ $this->event_time_from = $event_time_from;}else{$this->event_time_from = 0;}
		if(is_numeric($event_time_to)){ $this->event_time_to = $event_time_to;}else{$this->event_time_to = 0;}
		$this->event_type = $event_type;
		$this->event_name = $event_name;
		$this->event_horus_from = $event_horus_from;
		$this->event_hours_to = $event_hours_to;
		$this->event_minutes_from = $event_minutes_from;
		$this->event_minutes_to = $event_minutes_to;
		if(is_numeric($ts_location)){ $this->ts_location = $ts_location;}else{$this->ts_location = 0;}
		if(is_numeric($company_birthday_data)){ $this->company_birthday_data = $company_birthday_data;}else{$this->company_birthday_data = 0;}
		if(is_numeric($company_location_birthday_slots)){ $this->company_location_birthday_slots = $company_location_birthday_slots;}else{$this->company_location_birthday_slots = 0;}
		$this->event_global_type = $event_global_type;
		$this->maker = $maker;
		$this->makerDate = $makerDate;
		$this->checker = $checker;
		$this->checkerDate = $checkerDate;
		$this->pozicija = $pozicija;
		$this->jezik = $jezik;
		$this->recordStatus = $recordStatus;
		$this->modNumber = $modNumber;
		$this->multilang_id = $multilang_id;
		
		
		
		
		$this->display_elements_formats["maker"] = array("database_type"=>"VARCHAR","html_type"=>"INPUT");
		$this->display_elements_formats["makerDate"] = array("database_type"=>"DATETIME");
		$this->display_elements_formats["checker"] = array("database_type"=>"VARCHAR","html_type"=>"INPUT");
		$this->display_elements_formats["checkerDate"] = array("database_type"=>"DATETIME");
		$this->display_elements_formats["modNumber"] = array("database_type"=>"INT_DEFAULT");
		$this->display_elements_formats["recordStatus"] = array("database_type"=>"VARCHAR_DEFAULT");
		$this->display_elements_formats["jezik"] = array("database_type"=>"VARCHAR_DEFAULT");
		$this->display_elements_formats["multilang_id"] = array("database_type"=>"INT_DEFAULT");
		$this->display_elements_formats["pozicija"] = array("database_type"=>"INT_DEFAULT");
	}
	
	
	public function set_format_options($format_options){
		$this->format_options = $format_options;
	}
	
	public function get_domain_name()
	{
		return strtolower(__CLASS__);
	}
	
	//Atributes
	public function get_attribute_list()
	{	
		return "`id`,`training_school`,`event_date`,`event_time_from`,`event_time_to`,`event_type`,`event_name`,`event_horus_from`,`event_hours_to`,`event_minutes_from`,`event_minutes_to`,`ts_location`,`company_birthday_data`,`company_location_birthday_slots`,`event_global_type`,`maker`,`makerDate`,`checker`,`checkerDate`,`pozicija`,`jezik`,`recordStatus`,`modNumber`,`multilang_id`";
	}

	public function get_attribute_values()
	{
		return "NULL,{$this->training_school},'{$this->event_date}',{$this->event_time_from},{$this->event_time_to},'{$this->event_type}','{$this->event_name}','{$this->event_horus_from}','{$this->event_hours_to}','{$this->event_minutes_from}','{$this->event_minutes_to}',{$this->ts_location},{$this->company_birthday_data},{$this->company_location_birthday_slots},'{$this->event_global_type}','{$this->maker}','{$this->makerDate}','{$this->checker}','{$this->checkerDate}',{$this->pozicija},'{$this->jezik}','{$this->recordStatus}','{$this->modNumber}','{$this->multilang_id}'";
	}
	
	public function get_object($row)
	{
		$new_object = new company_events($row['id'],$row['training_school'],$row['event_date'],$row['event_time_from'],$row['event_time_to'],$row['event_type'],$row['event_name'],$row['event_horus_from'],$row['event_hours_to'],$row['event_minutes_from'],$row['event_minutes_to'],$row['ts_location'],$row['company_birthday_data'],$row['company_location_birthday_slots'],$row['event_global_type'],$row["maker"],$row["makerDate"],$row["checker"],$row["checkerDate"],$row["pozicija"],$row["jezik"],$row["recordStatus"],$row["modNumber"],$row["multilang_id"]);
	
		if($this->format_options){
				$class_vars = get_class_vars(get_class($new_object));
				$class_vars = array_keys($class_vars);
				$new_object->display = new stdClass;
				for($i=0;$i<sizeof($class_vars);$i++){
					if($this->display_elements_formats[$class_vars[$i]] != NULL){
						$new_object->display->$class_vars[$i] = $this->get_formated_value($this->display_elements_formats[$class_vars[$i]],$new_object->$class_vars[$i],get_class($new_object),$class_vars[$i]);
						if($this->display_elements_formats[$class_vars[$i]]["html_type"] == "JCROP"){
							$fullsize = "FULLSIZE_".$class_vars[$i];
							$new_object->display->$fullsize = $this->get_formated_value($this->display_elements_formats[$class_vars[$i]],"FULLSIZE_".$new_object->$class_vars[$i],get_class($new_object),$class_vars[$i]);
						}
					}
				}
			}
			return $new_object;
	}
	
	public function get_formated_value($format_style,$value,$domain_class_name,$domain_class_attribute){
		switch($format_style["database_type"]){
			case "TEXT": 
			case "VARCHAR":{
				switch($format_style["html_type"]){
					case "PASSWORD":{
						return "***";	
					};break;
					
					case "WLEDITOR":
					case "INPUT":
					case "INPUTREADONLY":
					case "HIDDEN":
					case "INPUT":{
						return stripslashes(str_replace('../','',strip_tags($value,$this->format_options["text"])));	
					};break;
					
					case "FILE":
					case "FILEPROGRESS":{
						return "files/".$domain_class_name."/".$domain_class_attribute."/".$value;	
					};break;
					
					case "JCROP":
					case "IMAGE":
					case "IMAGEW":
					case "IMAGEH":
					case "IMAGEWH":
					case "IMAGEC":{
						return "pictures/".$domain_class_name."/".$domain_class_attribute."/".$value;	
					};break;
					
					case "YOUTUBE":{
						return '<iframe width="'.$format_style["width"].'" height="'.$format_style["height"].'" src="http://www.youtube.com/embed/'.$value.'" frameborder="0" allowfullscreen></iframe>';	
					};break;
					
					case "VIMEO":{
						return '<iframe src="http://player.vimeo.com/video/'.$value.'?color=ffffff" width="'.$format_style["width"].'" height="'.$format_style["height"].'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';	
					};break;
					
					
					default: {
						return $value;	
					};break;	
				}
			};break;
			
			case "INT": {
				switch($format_style["html_type"]){
					case "PRICE":{
						if($this->format_options["int_decimal_bool"]){
							return number_format($value,2,$this->format_options["int_decimal"],$this->format_options["int_thousand"])." ".$format_style["price_format"];	
						}else{
							return number_format($value,0,$this->format_options["int_decimal"],$this->format_options["int_thousand"])." ".$format_style["price_format"];		
						}
					};break;
					
					default: {
						if($this->format_options["int_decimal_bool"]){
							return number_format($value,2,$this->format_options["int_decimal"],$this->format_options["int_thousand"]);	
						}else{
							return number_format($value,0,$this->format_options["int_decimal"],$this->format_options["int_thousand"]);	
						}
					}; break;
				}
			}; break;
			
			case "DECIMAL": {
				switch($format_style["html_type"]){
					case "PRICE":{
						return number_format($value,2,$this->format_options["decimal_decimal"],$this->format_options["decimal_thousand"])." ".$format_style["price_format"];
					};break;
					
					default: {
						return number_format($value,2,$this->format_options["decimal_decimal"],$this->format_options["decimal_thousand"])." ".$format_style["price_format"];
					}; break;
				}
			}; break;
			
			case "DATE":{
				return date($this->format_options["date"],strtotime($value));
			};break;
			
			case "DATETIME":{
				return date($this->format_options["datetime"],strtotime($value));
			};break;
			
			default: return $value; break;
		}
	}

	public function get_id()
	{
		return $this->id;
	}
	
	public function set_id($id)
	{
		$this->id = $id;
	}
	
	public function get_order_by()
	{
		if($this->order_by == "")	return $this->order_by." ".$this->direction;
		else						return $this->order_by;
	}

	public function set_order_by($order_by,$direction="")
	{
		$this->order_by = $order_by." ".$direction;
	}
	
	public function add_order_by($order_by,$direction = "")
	{
		if($this->order_by == "")	$this->order_by = $order_by." ".$direction;
		else						$this->order_by .= ",".$order_by." ".$direction;
	}
	
	public function delete_order_by()
	{
		$this->order_by = "";
	}

	public function get_limit()
	{
		return $this->limit;
	}
	
	public function set_limit($limit,$from = 0)
	{
		$this->limit = $from.",".$limit;
	}
	
	public function get_condition()
	{
		if($this->condition != "")	return $this->condition;
		else						return "id = ".$this->id;
	}
	
	public function set_condition($item,$sign,$value)
	{
		if(in_array($item,$this->varchar))	$this->condition = $item." ".$sign." '".$value."'";
		else								$this->condition = $item." ".$sign.' '.$value."";
	}
	
	public function add_condition($item,$sign,$value,$main_condition = "AND")
	{
		if(in_array($item,$this->varchar))
			if($this->condition == "")	$this->condition = $item." ".$sign." '".$value."'";
			else						$this->condition .= " ".$main_condition." ".$item." ".$sign." '".$value."'";
		else
			if($this->condition == "")	$this->condition = $item." ".$sign." ".$value;
			else						$this->condition .= " ".$main_condition." ".$item." ".$sign." ".$value;
	}
	
	public function add_group_condition($condition_array,$main_condition = "AND")
	{
		$condition = " ".$main_condition." (";
		for($i=0;$i < sizeof($condition_array);$i++){
			if($i == 0)
				if(in_array($condition_array[$i][0],$this->varchar))
					$condition .= $condition_array[$i][0]." ".$condition_array[$i][1]." '".$condition_array[$i][2]."'";
				else 
					$condition .= $condition_array[$i][0]." ".$condition_array[$i][1]." ".$condition_array[$i][2]; 
			else
				if(in_array($condition_array[$i][0],$this->varchar))
					$condition .= " ".$condition_array[$i][3]." ".$condition_array[$i][0]." ".$condition_array[$i][1]." '".$condition_array[$i][2]."'";
				else
					$condition .= " ".$condition_array[$i][3]." ".$condition_array[$i][0]." ".$condition_array[$i][1]." ".$condition_array[$i][2];
		}
		$condition .= ")";
		$this->condition .= $condition;
	}
	
	public function delete_condition()
	{
		$this->condition = "";
	}
	
	public function set_custom_sql($sql)
	{
		$this->customSQL = $sql;
	}
	
	public function get_custom_sql()
	{
		return $this->customSQL;
	}
	
	public function delete_custom_sql($sql)
	{
		$this->customSQL = "";
	}
	
	public function get_update_values()
	{
		return "`training_school` = {$this->training_school},`event_date` = '{$this->event_date}',`event_time_from` = {$this->event_time_from},`event_time_to` = {$this->event_time_to},`event_type` = '{$this->event_type}',`event_name` = '{$this->event_name}',`event_horus_from` = '{$this->event_horus_from}',`event_hours_to` = '{$this->event_hours_to}',`event_minutes_from` = '{$this->event_minutes_from}',`event_minutes_to` = '{$this->event_minutes_to}',`ts_location` = {$this->ts_location},`company_birthday_data` = {$this->company_birthday_data},`company_location_birthday_slots` = {$this->company_location_birthday_slots},`event_global_type` = '{$this->event_global_type}',`maker` = '{$this->maker}',`makerDate` = '{$this->makerDate}',`checker` = '{$this->checker}',`checkerDate` = '{$this->checkerDate}',`pozicija` = '{$this->pozicija}',`jezik` = '{$this->jezik}',`recordStatus` = '{$this->recordStatus}',`modNumber` = '{$this->modNumber}',`multilang_id` = '{$this->multilang_id}'";
	}

	public function get_fields_array(){ 
		$object_fields_array = Array();
		$object_fields_array["id"] = $this->id;
		for($i=0;$i<sizeof($this->domain_fields_array);$i++){
			$var_name = $this->domain_fields_array[$i];
			if(is_object($this->$var_name)){
				$object_fields_array[$var_name] = $this->$var_name->get_fields_array();
			}else{
				$object_fields_array[$var_name] = $this->$var_name;
			}
		}
		$object_fields_array["maker"] = $this->maker;
		$object_fields_array["makerDate"] = $this->makerDate;
		$object_fields_array["checker"] = $this->checker;
		$object_fields_array["checkerDate"] = $this->checkerDate;
		return $object_fields_array;
	}
}
?>