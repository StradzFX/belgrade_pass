<?php
require_once "base_domain_object.php";
class purchase implements base_domain_object
{
	public $id = 0;
	public $user = 0;
	public $price = 0;
	public $to_company = "";
	public $to_us = "";
	public $duration_days = "";
	public $number_of_passes = 0;
	public $start_date = "";
	public $end_date = "";
	public $purchase_type = "";
	public $company_flag = "";
	public $po_name = "";
	public $po_address = "";
	public $po_city = "";
	public $po_postal = "";
	public $card_package = 0;
	public $user_card = 0;
	public $card_active_token = "";
	public $returnUrl = "";
	public $merchantPaymentId = "";
	public $apiMerchantId = "";
	public $paymentSystem = "";
	public $paymentSystemType = "";
	public $paymentSystemEftCode = "";
	public $pgTranDate = "";
	public $pgTranId = "";
	public $pgTranRefId = "";
	public $pgOrderId = "";
	public $customerId = "";
	public $amount = "";
	public $installment = "";
	public $sessionToken = "";
	public $random_string = "";
	public $SD_SHA512 = "";
	public $sdSha512 = "";
	public $pgTranErrorText = "";
	public $pgTranErrorCode = "";
	public $errorCode = "";
	public $responseCode = "";
	public $responseMsg = "";
	public $company_location = 0;
	public $po_payment_date = "";
	public $po_payment_name = "";
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

	private $varchar = array("to_company","to_us","duration_days","start_date","end_date","purchase_type","company_flag","po_name","po_address","po_city","po_postal","card_active_token","returnUrl","merchantPaymentId","apiMerchantId","paymentSystem","paymentSystemType","paymentSystemEftCode","pgTranDate","pgTranId","pgTranRefId","pgOrderId","customerId","amount","installment","sessionToken","random_string","SD_SHA512","sdSha512","pgTranErrorText","pgTranErrorCode","errorCode","responseCode","responseMsg","po_payment_date","po_payment_name","maker","makerDate","checker","checkerDate","jezik","recordStatus");

	public $domain_fields_array = array("id","user","price","to_company","to_us","duration_days","number_of_passes","start_date","end_date","purchase_type","company_flag","po_name","po_address","po_city","po_postal","card_package","user_card","card_active_token","returnUrl","merchantPaymentId","apiMerchantId","paymentSystem","paymentSystemType","paymentSystemEftCode","pgTranDate","pgTranId","pgTranRefId","pgOrderId","customerId","amount","installment","sessionToken","random_string","SD_SHA512","sdSha512","pgTranErrorText","pgTranErrorCode","errorCode","responseCode","responseMsg","company_location","po_payment_date","po_payment_name");

	private $display_elements_formats = array();
	public $format_options = NULL; 
	
	//Constructor and Domain name
	public function __construct($id = 0, $user = 0, $price = 0, $to_company = "", $to_us = "", $duration_days = "", $number_of_passes = 0, $start_date = "", $end_date = "", $purchase_type = "", $company_flag = "", $po_name = "", $po_address = "", $po_city = "", $po_postal = "", $card_package = 0, $user_card = 0, $card_active_token = "", $returnUrl = "", $merchantPaymentId = "", $apiMerchantId = "", $paymentSystem = "", $paymentSystemType = "", $paymentSystemEftCode = "", $pgTranDate = "", $pgTranId = "", $pgTranRefId = "", $pgOrderId = "", $customerId = "", $amount = "", $installment = "", $sessionToken = "", $random_string = "", $SD_SHA512 = "", $sdSha512 = "", $pgTranErrorText = "", $pgTranErrorCode = "", $errorCode = "", $responseCode = "", $responseMsg = "", $company_location = 0, $po_payment_date = "", $po_payment_name = "", $maker = "",$makerDate = "",$checker = "",$checkerDate = "",$pozicija="",$jezik="",$recordStatus="",$modNumber="",$multilang_id = 0)
	{
		if(is_numeric($id)){ $this->id = $id;}else{$this->id = 0;}
		if(is_numeric($user)){ $this->user = $user;}else{$this->user = 0;}
		if(is_numeric($price)){ $this->price = $price;}else{$this->price = 0;}
		$this->to_company = $to_company;
		$this->to_us = $to_us;
		$this->duration_days = $duration_days;
		if(is_numeric($number_of_passes)){ $this->number_of_passes = $number_of_passes;}else{$this->number_of_passes = 0;}
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->purchase_type = $purchase_type;
		$this->company_flag = $company_flag;
		$this->po_name = $po_name;
		$this->po_address = $po_address;
		$this->po_city = $po_city;
		$this->po_postal = $po_postal;
		if(is_numeric($card_package)){ $this->card_package = $card_package;}else{$this->card_package = 0;}
		if(is_numeric($user_card)){ $this->user_card = $user_card;}else{$this->user_card = 0;}
		$this->card_active_token = $card_active_token;
		$this->returnUrl = $returnUrl;
		$this->merchantPaymentId = $merchantPaymentId;
		$this->apiMerchantId = $apiMerchantId;
		$this->paymentSystem = $paymentSystem;
		$this->paymentSystemType = $paymentSystemType;
		$this->paymentSystemEftCode = $paymentSystemEftCode;
		$this->pgTranDate = $pgTranDate;
		$this->pgTranId = $pgTranId;
		$this->pgTranRefId = $pgTranRefId;
		$this->pgOrderId = $pgOrderId;
		$this->customerId = $customerId;
		$this->amount = $amount;
		$this->installment = $installment;
		$this->sessionToken = $sessionToken;
		$this->random_string = $random_string;
		$this->SD_SHA512 = $SD_SHA512;
		$this->sdSha512 = $sdSha512;
		$this->pgTranErrorText = $pgTranErrorText;
		$this->pgTranErrorCode = $pgTranErrorCode;
		$this->errorCode = $errorCode;
		$this->responseCode = $responseCode;
		$this->responseMsg = $responseMsg;
		if(is_numeric($company_location)){ $this->company_location = $company_location;}else{$this->company_location = 0;}
		$this->po_payment_date = $po_payment_date;
		$this->po_payment_name = $po_payment_name;
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
		return "`id`,`user`,`price`,`to_company`,`to_us`,`duration_days`,`number_of_passes`,`start_date`,`end_date`,`purchase_type`,`company_flag`,`po_name`,`po_address`,`po_city`,`po_postal`,`card_package`,`user_card`,`card_active_token`,`returnUrl`,`merchantPaymentId`,`apiMerchantId`,`paymentSystem`,`paymentSystemType`,`paymentSystemEftCode`,`pgTranDate`,`pgTranId`,`pgTranRefId`,`pgOrderId`,`customerId`,`amount`,`installment`,`sessionToken`,`random_string`,`SD_SHA512`,`sdSha512`,`pgTranErrorText`,`pgTranErrorCode`,`errorCode`,`responseCode`,`responseMsg`,`company_location`,`po_payment_date`,`po_payment_name`,`maker`,`makerDate`,`checker`,`checkerDate`,`pozicija`,`jezik`,`recordStatus`,`modNumber`,`multilang_id`";
	}

	public function get_attribute_values()
	{
		return "NULL,{$this->user},{$this->price},'{$this->to_company}','{$this->to_us}','{$this->duration_days}',{$this->number_of_passes},'{$this->start_date}','{$this->end_date}','{$this->purchase_type}','{$this->company_flag}','{$this->po_name}','{$this->po_address}','{$this->po_city}','{$this->po_postal}',{$this->card_package},{$this->user_card},'{$this->card_active_token}','{$this->returnUrl}','{$this->merchantPaymentId}','{$this->apiMerchantId}','{$this->paymentSystem}','{$this->paymentSystemType}','{$this->paymentSystemEftCode}','{$this->pgTranDate}','{$this->pgTranId}','{$this->pgTranRefId}','{$this->pgOrderId}','{$this->customerId}','{$this->amount}','{$this->installment}','{$this->sessionToken}','{$this->random_string}','{$this->SD_SHA512}','{$this->sdSha512}','{$this->pgTranErrorText}','{$this->pgTranErrorCode}','{$this->errorCode}','{$this->responseCode}','{$this->responseMsg}',{$this->company_location},'{$this->po_payment_date}','{$this->po_payment_name}','{$this->maker}','{$this->makerDate}','{$this->checker}','{$this->checkerDate}',{$this->pozicija},'{$this->jezik}','{$this->recordStatus}','{$this->modNumber}','{$this->multilang_id}'";
	}
	
	public function get_object($row)
	{
		$new_object = new purchase($row['id'],$row['user'],$row['price'],$row['to_company'],$row['to_us'],$row['duration_days'],$row['number_of_passes'],$row['start_date'],$row['end_date'],$row['purchase_type'],$row['company_flag'],$row['po_name'],$row['po_address'],$row['po_city'],$row['po_postal'],$row['card_package'],$row['user_card'],$row['card_active_token'],$row['returnUrl'],$row['merchantPaymentId'],$row['apiMerchantId'],$row['paymentSystem'],$row['paymentSystemType'],$row['paymentSystemEftCode'],$row['pgTranDate'],$row['pgTranId'],$row['pgTranRefId'],$row['pgOrderId'],$row['customerId'],$row['amount'],$row['installment'],$row['sessionToken'],$row['random_string'],$row['SD_SHA512'],$row['sdSha512'],$row['pgTranErrorText'],$row['pgTranErrorCode'],$row['errorCode'],$row['responseCode'],$row['responseMsg'],$row['company_location'],$row['po_payment_date'],$row['po_payment_name'],$row["maker"],$row["makerDate"],$row["checker"],$row["checkerDate"],$row["pozicija"],$row["jezik"],$row["recordStatus"],$row["modNumber"],$row["multilang_id"]);
	
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
		return "`user` = {$this->user},`price` = {$this->price},`to_company` = '{$this->to_company}',`to_us` = '{$this->to_us}',`duration_days` = '{$this->duration_days}',`number_of_passes` = {$this->number_of_passes},`start_date` = '{$this->start_date}',`end_date` = '{$this->end_date}',`purchase_type` = '{$this->purchase_type}',`company_flag` = '{$this->company_flag}',`po_name` = '{$this->po_name}',`po_address` = '{$this->po_address}',`po_city` = '{$this->po_city}',`po_postal` = '{$this->po_postal}',`card_package` = {$this->card_package},`user_card` = {$this->user_card},`card_active_token` = '{$this->card_active_token}',`returnUrl` = '{$this->returnUrl}',`merchantPaymentId` = '{$this->merchantPaymentId}',`apiMerchantId` = '{$this->apiMerchantId}',`paymentSystem` = '{$this->paymentSystem}',`paymentSystemType` = '{$this->paymentSystemType}',`paymentSystemEftCode` = '{$this->paymentSystemEftCode}',`pgTranDate` = '{$this->pgTranDate}',`pgTranId` = '{$this->pgTranId}',`pgTranRefId` = '{$this->pgTranRefId}',`pgOrderId` = '{$this->pgOrderId}',`customerId` = '{$this->customerId}',`amount` = '{$this->amount}',`installment` = '{$this->installment}',`sessionToken` = '{$this->sessionToken}',`random_string` = '{$this->random_string}',`SD_SHA512` = '{$this->SD_SHA512}',`sdSha512` = '{$this->sdSha512}',`pgTranErrorText` = '{$this->pgTranErrorText}',`pgTranErrorCode` = '{$this->pgTranErrorCode}',`errorCode` = '{$this->errorCode}',`responseCode` = '{$this->responseCode}',`responseMsg` = '{$this->responseMsg}',`company_location` = {$this->company_location},`po_payment_date` = '{$this->po_payment_date}',`po_payment_name` = '{$this->po_payment_name}',`maker` = '{$this->maker}',`makerDate` = '{$this->makerDate}',`checker` = '{$this->checker}',`checkerDate` = '{$this->checkerDate}',`pozicija` = '{$this->pozicija}',`jezik` = '{$this->jezik}',`recordStatus` = '{$this->recordStatus}',`modNumber` = '{$this->modNumber}',`multilang_id` = '{$this->multilang_id}'";
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