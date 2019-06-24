<?php 
class controller
{	
	private $broker;
	
	public function __construct($broker)
	{
		$this->broker = new db_broker();
	}
	
	public function get_all_promoted_data($domain_object,$language = false)
	{
		$domain_object->add_condition("checker","!=","");
		$domain_object->add_condition("recordStatus","=","O");
		if($language == "sc")	$language = "rs";
		if($language != false)	$domain_object->add_condition("jezik","=",$language);
		if($domain_object->get_limit() != 600)
			return $this->broker->get_all_data_condition_limited($domain_object);
		else	return $this->broker->get_all_data_condition($domain_object);
	}

	public function get_json($object_array){
		$json_array = Array();
		for($i=0;$i<sizeof($object_array);$i++){
			$json_array[] = $object_array[$i]->get_fields_array();
		}
		return json_encode($json_array);
	}
	
	public function get_menu($menu,$submenu,$language = false)
	{
		$all_menu = $this->get_all_promoted_data($menu,$language);
		$all_submenu = $this->get_all_promoted_data($submenu,$language);
		$menu_size = sizeof($all_menu);
		$submenu_size = sizeof($all_submenu);
		for($i=0;$i<$menu_size;$i++)
		{
			$submenu_array = array();
			for($j=0;$j<$submenu_size;$j++)
			{
				$domain_class = get_class($menu);
				if($all_menu[$i]->id == $all_submenu[$j]->$domain_class)
					$submenu_array[] = $all_submenu[$j];
			}
			$domain_class = get_class($submenu);
			$all_menu[$i]->$domain_class = $submenu_array;
		}
		return $all_menu;
	}
	
	public function get_single_page($page_id,$attributes_array,$language = false)
	{
		if($language == false)
		{
			$sp_element = new xenon_module_sp_element();
			$sp_element->set_condition('xenon_module_sp_page','=',$page_id);
			$sp_element = $this->get_all_promoted_data($sp_element);
		}
		else
		{
			$sp_element = new xenon_module_spml_element();
			$sp_element->set_condition('xenon_module_spml_page','=',$page_id);
			$sp_element = $this->get_all_promoted_data($sp_element,$language);
		}
		
		$size_of_attributes_array = sizeof($attributes_array);
		$size_of_sp_element_array = sizeof($sp_element);
		
		$return_array = array();
		for($i=0;$i<$size_of_attributes_array;$i++)
			for($j=0;$j<$size_of_sp_element_array;$j++)
				if($attributes_array[$i] == $sp_element[$j]->element_name)
				{
					$return_array[$i] = $sp_element[$j]->element_value;
					break;
				}
				else $return_array[$i] = "";
		return $return_array;
	}
	
	public function check_id($dc,$id,$broker)
	{
		if($dc!='' && $id!='')
		{	
			$dc=$broker->get_data(new $dc($id));
			if (sizeof($dc->id) != 0)
			{
				return true;
			}
			else
			{
				return false;	
			}
			
		}
	}
	
	public function check_name_by_id($dc,$id,$name,$seo_value,$seo,$broker)
	{	
		if($dc!='' && $id!='' && $name!='' && $seo_value!='')
		{
			$dc=$broker->get_data(new $dc($id));
			if ($dc->$name!='')
			{	
				$seo = new seo_generator();
				if ( $seo->create_seo_title($dc->$name) == $seo_value )
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	public function check_pagination($dc,$elements_per_page,$page_number,$broker)
	{
		if($dc!='' && $elements_per_page!='' && $page_number!='')
		{
			$dc=$broker->get_all_data(new $dc());
			if (sizeof($dc)!=0)
			{
				if ( (ceil (sizeof($dc)/$elements_per_page) ) >= $page_number)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	/* PREVIEW AND NEXT DATA - EDIT */
	public function generate_pagination($elements_per_page,$total_elements,$current_page,$url_template,$prev_next=false,$prev_data='<',$next_data='>')
	{
		if($elements_per_page!='' && $total_elements!='' && $current_page!='' && $url_template!='' && $total_elements>1){
			$number_of_pages = ceil($total_elements/$elements_per_page);
			if($number_of_pages>1){
								
				// PREVIOUS PAGE
				if($prev_next==true){
					if($current_page!=1){
						$url_previous = '<div class="left_arrow">'.str_replace('{page}', $current_page-1 ,$url_template).'</div>';
						$url_pagination .= str_replace(($current_page-1).'</a>', $prev_data.'</a>' ,$url_previous);
					}
				}
				// FOR 10 PAGES OR LESS
				if ($number_of_pages<=10){
					for($i=1;$i<=$number_of_pages;$i++){
						if($current_page==$i){
							$url_pagination .= '<div class="current_page">'.$i.'</div>';
						}else{
							$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $i ,$url_template).'</div>';
						}
					}
				}else{
					// TEMPLATE 1 - IF CURRENT PAGE IS LESS THAN 5
					if($current_page<=4){
						for($i=1;$i<=5;$i++){
							if($current_page==$i){
								$url_pagination .= '<div class="current_page">'.$i.'</div>';
							}else{
								$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $i ,$url_template).'</div>';
							}						
						}
						$url_pagination .= '<div class="pagination_btn">...</div>';
						$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $number_of_pages ,$url_template).'</div>';
					}
					// TEMPLATE 2 - IF CURRENT PAGE IS IN THE MIDDLE
					if($current_page>4 && $current_page<$number_of_pages-4){					
						$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', 1 ,$url_template).'</div>';
						$url_pagination .= '<div class="pagination_btn">...</div>';
						for($i=$current_page-2;$i<=$current_page+2;$i++){
							if($current_page==$i){
								$url_pagination .= '<div class="current_page">'.$i.'</div>';
							}else{
								$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $i ,$url_template).'</div>';
							}						
						}
						$url_pagination .= '<div class="pagination_btn">...</div>';					
						$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $number_of_pages ,$url_template).'</div>';
					}
					// TEMPLATE 3 - IF CURRENT PAGE IS IN THE LAST 4 ELEMENTS
					if($current_page>=$number_of_pages-4){
						$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', 1 ,$url_template).'</div>';
						$url_pagination .= '<div class="pagination_btn">...</div>';
						for($i=$number_of_pages-5;$i<=$number_of_pages;$i++){
							if($current_page==$i){
								$url_pagination .= '<div class="current_page">'.$i.'</div>';
							}else{
								$url_pagination .= '<div class="pagination_btn">'.str_replace('{page}', $i ,$url_template).'</div>';
							}						
						}
						
					}
				}
				// NEXT PAGE
				if($prev_next==true){
					if($current_page!=$number_of_pages){
						$url_next = '<div class="right_arrow">'.str_replace('{page}', $current_page+1 ,$url_template).'</div>';
						$url_pagination .= str_replace(($current_page+1).'</a>', $next_data.'</a>' ,$url_next);
					}
				}
				
				return $url_pagination.'<div style="clear:both"></div>';
			  }else{
			  return '';
		  }
		}else{
			return '';
		}
	}	

}

class website_functions{
	public $form_validator;
	
	public function __construct(){
		$this->form_validator = new form_validator();
	}
}

class form_validator{
	private $rules;
	private $success = false;
	private $error_validator = 'validator was not run';
	
	public $rule_empty_field = 'empty_field';
	public $rule_email = 'email';
	public $rule_numeric = 'numeric';
	public $rule_greater = 'greater';
	
	public function __construct(){
		$this->rules = array();
	}
	
	public function add_rule($field_value,$rule,$error_message,$extra_data=""){
		$this->rules[] = array('field_value'=>$field_value,'rule'=>$rule,'error_message'=>$error_message,'extra_data'=>$extra_data);
	}
	
	public function run_validator(){
		for($i=0;$i<sizeof($this->rules);$i++){
			switch($this->rules[$i]['rule']){
				case 'empty_field':{
					if(trim($this->rules[$i]['field_value']) == ''){
						$this->error_validator = $this->rules[$i]['error_message'];return NULL;
					}
				};break;
				
				case 'email':{
					if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$this->rules[$i]['field_value']) != ''){
						$this->error_validator = $this->rules[$i]['error_message'];return NULL;
					}
				};break;
				
				case 'numeric':{
					if(!is_numeric($this->rules[$i]['field_value'])){
						$this->error_validator = $this->rules[$i]['error_message'];return NULL;
					}
				};break;
				
				case 'greater':{
					if($this->rules[$i]['field_value'] < $this->rules[$i]['extra_data']){
						$this->error_validator = $this->rules[$i]['error_message'];return NULL;
					}
				};break;
				
				default : {$this->error_validator = "rule '".$this->rules[$i]['rule']."' is not suporrted.";return NULL;};break;
			}
		}
		$this->success = true;
	}
	
	public function is_valid_form(){
		return $this->success;
	}
	
	public function error_message(){
		return $this->error_validator;
	}
}

?>