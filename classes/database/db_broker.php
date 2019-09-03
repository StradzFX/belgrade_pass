<?php 
class db_broker
{
	public $instance = NULL;
	protected $db_user  = DBUSER;
	protected $db_pass  = DBPASS;
	protected $db_name  = DBNAME;
	protected $db_host  = DBHOST;
	protected $format_options  = NULL;
	public $debugger = false;
	
	//================================== DEBUGGING FUNCTIONS ======================================
	public function start_debugger()
	{
		$this->debugger = true;
	}
	public function stop_debugger()
	{
		$this->debugger = false;
	}
	
	public function set_format_options($format_options){
		$this->format_options = $format_options;
	}
	
	//========================================= CONSTRUCT =========================================
	public function __construct($data=null)
	{
		global $_global_config;
		
		if($data){
			$this->instance = mysqli_connect($data['server'], $data['username'], $data['password'], $data['db_name']);
		}else{
			$this->instance = mysqli_connect($_global_config['DBHOST'], $_global_config['DBUSER'], $_global_config['DBPASS'], $_global_config['DBNAME']);
		}
		
	}
	
	public function execute_query($sql, $affect = false)
	{
		$this->instance->query("SET NAMES UTF8");
		if($this->debugger)	echo $sql.'<br/>';
		if(!$affect)	return $this->instance->query($sql);
		else
		{
			$this->instance->query($sql);
			return $this->instance->affected_rows;
		}
	}
	
	public function execute_sql_get_array($sql)
	{
		$this->instance->query("SET NAMES UTF8");
		if($this->debugger)	echo $sql.'<br/>';
		$result = $this->instance->query($sql);
		if($result)
		{
			while($row = $result->fetch_assoc()) 
				$result_array[] = $row;
			return $result_array;
		}
		else return false;
	}
	
	//========================================================= INSERT ====================================================
	public function insert($domain_object,$return_object=true,$return_no_of_rows=false,$return_id=false)
	{
		if(strpos("xenon",substr($domain_object->get_domain_name(), 0, 5)) === false)
		{
			if($domain_object->pozicija == "")		$domain_object->pozicija = $this->get_max_position($domain_object)+1;
			if($domain_object->multilang_id == "")	$domain_object->multilang_id = $this->get_max_language_id($domain_object)+1;
		}
		$this->instance->query("SET NAMES UTF8");
		$sql = "INSERT INTO `".$domain_object->get_domain_name()."` (".$domain_object->get_attribute_list().") VALUES(".$domain_object->get_attribute_values().")";
		if($this->debugger)	echo $sql.'<br/>';
		$query = $this->instance->query($sql);
		if($return_object)
			if($query == 1)
				return $domain_object->get_object($this->instance->query("SELECT * FROM `".$domain_object->get_domain_name()."` ORDER BY id DESC LIMIT 1")->fetch_assoc());
			else return NULL;
		
		if($return_no_of_rows)	return $this->instance->affected_rows;
		if($return_id)			return $this->instance->insert_id;
		return 'Error: no return type specified.';
	}
	
	//========================================================= INSERT OBJECTS ====================================================
	public function insert_objects($domain_object_array,$return_no_of_rows=true,$return_bool=false)
	{
		if(sizeof($domain_object_array) > 0)
		{
			if(strpos("xenon",substr($domain_object_array[0]->get_domain_name(), 0, 5)) === false)
			{
				$max_position = $this->get_max_position($domain_object_array[0]);
				$max_language_id = $this->get_max_language_id($domain_object_array[0]);
				for($i=0;$i<sizeof($domain_object_array);$i++)
				{
					if($domain_object_array[$i]->pozicija == "")		
						$domain_object_array[$i]->pozicija = $max_position+1;
					if($domain_object_array[$i]->multilang_id == "")	
						$domain_object_array[$i]->multilang_id = $max_language_id+1;
				}
			}
			$this->instance->query("SET NAMES UTF8");
			$sql = "INSERT INTO `".$domain_object_array[0]->get_domain_name()."` (".$domain_object_array[0]->get_attribute_list().") VALUES";
			for($i=0;$i<sizeof($domain_object_array);$i++)
				$sql .= "(".$domain_object_array[$i]->get_attribute_values()."),";
			$sql = substr($sql,0,-1);
			if($this->debugger)	echo $sql.'<br/>';
			$this->instance->query($sql);
			if($return_no_of_rows)	return $this->instance->affected_rows;
			if($return_bool)		return $this->instance->affected_rows == sizeof($domain_object_array);
			return 'Error: no return type specified.';
		}
		else	return 'Error: Array has 0 elements.';
	}
	//================================================= DELETE ========================================================
	public function delete($domain_object,$return_no_of_rows=true)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "DELETE FROM ".$domain_object->get_domain_name()." WHERE ".$domain_object->get_condition();
		if($this->debugger)	echo $sql.'<br/>';
		$this->instance->query($sql);
		if($return_no_of_rows)
			return $this->instance->affected_rows;
		return 'Error: no return type specified.';
	}
	
	//================================================= DELETE OBJECTS ================================================
	public function delete_objects($domain_object_array,$return_no_of_rows=true)
	{
		if(sizeof($domain_object_array) > 0){
			$this->instance->query("SET NAMES UTF8");
			$sql = "DELETE FROM ".$domain_object_array[0]->get_domain_name()." WHERE ";
			for($i=0;$i<sizeof($domain_object_array);$i++)
				$sql .= $domain_object_array[$i]->get_condition().' OR ';
			$sql = substr($sql,0,-4);
			if($this->debugger)	echo $sql.'<br/>';
			$this->instance->query($sql);
			if($return_no_of_rows)
				return $this->instance->affected_rows;
			return 'Error: no return type specified.';
		}
		else	return 'Error: Array has 0 elements.';
	}
	//================================================= UPDATE ================================================
	public function update($domain_object,$return_no_of_rows=true)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "UPDATE `".$domain_object->get_domain_name()."` SET ".$domain_object->get_update_values()." WHERE ".$domain_object->get_condition();
		if($this->debugger)	echo $sql.'<br/>';
		$this->instance->query($sql);
		if($return_no_of_rows)
			return $this->instance->affected_rows;
		return 'Error: no return type specified.';
	}
	//================================================= UPDATE OBJECTS================================================
	public function update_objects($domain_object_array,$return_no_of_rows=true)
	{
		if(sizeof($domain_object_array) > 0)
		{
			$updated_rows = 0;
			for($i=0;$i<sizeof($domain_object_array);$i++){
				$this->instance->query("SET NAMES UTF8");
				$sql = "UPDATE `".$domain_object_array[$i]->get_domain_name()."` SET ".$domain_object_array[$i]->get_update_values()." WHERE ".$domain_object_array[$i]->get_condition();
				if($this->debugger)	echo $sql.'<br/>';
				$this->instance->query($sql);
				$updated_rows += $this->instance->affected_rows;
			}
			if($return_no_of_rows)
				return $updated_rows;
			return 'Error: no return type specified.';
		}else	return 'Error: Array has 0 elements.';
	}
	//================================================= GET DATA ================================================
	public function get_data($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		//================== SQL QUERY =========================
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE ".$domain_object->get_condition()." ORDER BY ".$domain_object->get_order_by()." ";
		
		//================== DEBUGGER OPTIONS ==================
		if($this->debugger)	echo $sql.'<br/>';
		
		//================== FORMAT OPTIONS ====================
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		
		//================== EXECUTE OPERATION =================
		return $domain_object->get_object($this->instance->query($sql)->fetch_assoc());
		
		
	}
	//================================================= GET ALL DATA ================================================
	public function get_all_data($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` ORDER BY ".$domain_object->get_order_by()." ";
		if($this->debugger)	echo $sql.'<br/>';
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}

	//================================================= GET ALL DATA CONDITION ================================================
	public function get_all_data_condition($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		
		//================== SQL QUERY =========================
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE ".$domain_object->get_condition()." ORDER BY ".$domain_object->get_order_by()." ";
		
		//================== DEBUGGER OPTIONS ==================
		if($this->debugger)	echo $sql.'<br/>';	
		
		//================== EXECUTE OPERATION =================
		try{
			$results = $this->instance->query($sql);
		}catch (Exception $e) {
			$broker_exception = new db_broker_exception('SQL query is not valid. Generic error'.$e->getMessage(),$sql,'$broker->get_all_data_condtion',get_class($domain_object));
			$broker_exception->errorMessage();
		}
		$domain_objects = array();
		
		//================== FORMAT OPTIONS ====================
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		
		
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}

	//================================================= GET ALL LIMITED ================================================
	public function get_all_data_limited($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` ORDER BY ".$domain_object->get_order_by()." "." LIMIT ".$domain_object->get_limit();
		if($this->debugger)	echo $sql.'<br/>';	
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}
	//================================================= GET ALL DATA CONDITION LIMITED ===========================
	public function get_all_data_condition_limited($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql  = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE ".$domain_object->get_condition()." ORDER BY ".$domain_object->get_order_by()." "." LIMIT ".$domain_object->get_limit();
		if($this->debugger)	echo $sql.'<br/>';	
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}

	//================================================= GET COUNT ================================================
	public function get_count($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT count(*) AS total FROM `".$domain_object->get_domain_name()."` LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET COUNT CONDITION ================================================
	public function get_count_condition($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT count(*) AS total FROM ".$domain_object->get_domain_name()." WHERE ".$domain_object->get_condition()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET MIN POSITION ================================================
	public function get_min_position($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT min(`pozicija`) AS total FROM ".$domain_object->get_domain_name()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET MAX POSITION ================================================
	public function get_max_position($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT max(`pozicija`) AS total FROM ".$domain_object->get_domain_name()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET MIN POSITION CONDITION ================================================
	public function get_min_position_condition($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql    = "SELECT min(`pozicija`) AS total FROM ".$domain_object->get_domain_name()." WHERE ".$domain_object->get_condition()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET MAX POSITION CONDITION ================================================
	public function get_max_position_condition($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT max(`pozicija`) AS total FROM ".$domain_object->get_domain_name()." WHERE ".$domain_object->get_condition()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//============================================== GET CUSTOM SQL ================================================
	public function get_custom_sql($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = $domain_object->get_custom_sql();
		if($this->debugger)	echo $sql.'<br/>';
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}
	
	//================================================= GET MAX LANGUAGE ID ================================================
	public function get_max_language_id($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT max(`multilang_id`) AS total FROM ".$domain_object->get_domain_name()." LIMIT 1";
		if($this->debugger)	echo $sql.'<br/>';	
		$row = $this->instance->query($sql)->fetch_assoc();
		return $row["total"];
	}
	
	//================================================= GET ALL DATA RANDOM ==============================
	public function get_all_data_random($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` ORDER BY RAND()";
		if($this->debugger)	echo $sql.'<br/>';
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}

	//================================================= GET ALL DATA RANDOM CONDITION =======================
	public function get_all_data_random_condition($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE ".$domain_object->get_condition()." ORDER BY RAND()";
		if($this->debugger)	echo $sql.'<br/>';	
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}

	//================================================= GET ALL RANDOM LIMITED ==================================
	public function get_all_data_random_limited($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql = "SELECT * FROM `".$domain_object->get_domain_name()."` ORDER BY RAND() LIMIT ".$domain_object->get_limit();
		if($this->debugger)	echo $sql.'<br/>';	
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}
	//================================================= GET ALL DATA CONDITION RANDOM LIMITED ===============
	public function get_all_data_random_condition_limited($domain_object)
	{
		$this->instance->query("SET NAMES UTF8");
		$sql  = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE ".$domain_object->get_condition()." ORDER BY RAND() LIMIT ".$domain_object->get_limit();
		if($this->debugger)	echo $sql.'<br/>';	
		$results = $this->instance->query($sql);
		$domain_objects = array();
		if($this->format_options != NULL){
			$domain_object->set_format_options($this->format_options);
		}
		while($row = $results->fetch_assoc())
			$domain_objects[] = $domain_object->get_object($row);
		return $domain_objects;
	}
	
	public function does_key_exists($domain_object){
		$sql  = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE id = ".$domain_object->id;
		$result = $this->instance->query($sql)->fetch_assoc();
		//=============== VALIDATION OF RESULT =================
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	public function does_multilang_key_exists($domain_object){
		$sql  = "SELECT * FROM `".$domain_object->get_domain_name()."` WHERE multilang_id = ".$domain_object->multilang_id.' AND jezik = `'.$domain_object->jezik.'`';
		$result = $this->instance->query($sql)->fetch_assoc();
		//=============== VALIDATION OF RESULT =================
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	//============================================== INFO AND TRANSACTIONS ================================================
	public function get_connection_data()
	{
		echo '[host:'.$this->db_host.'] , [database name:'.$this->db_name.'] , [username:'.$this->db_user.'] , [password:'.sha1($this->db_pass).']';
	}
	
	public function begin_transaction()
	{
		if($this->instance != NULL)
		{
			$this->instance->autocommit(FALSE);
			return true;
		}
		else	die('Error: Instance not populated. Function [begin transaction].');
	}
	
	public function commit_transaction()
	{
		if($this->instance != NULL)
		{
			$this->instance->commit();
			return true;
		}
		else	die('Error: Instance not populated. Function [commit transaction].');
	}
	
	public function rollback_transaction()
	{
		if($this->instance != NULL)	$this->instance->rollback();
		else	die('Error: Instance not populated. Function [roll back transaction].');
	}
	//================================== SESSION FUNCTIONS ==================================
	public function set_session($session_name, $domain_object)
	{
		if($domain_object != NULL)	$_SESSION[$session_name] = serialize($domain_object);
		return unserialize($_SESSION[$session_name]);
	}
	
	public function get_session($session_name)
	{
		return unserialize($_SESSION[$session_name]);
	}
}

class db_broker_exception extends Exception{
	
	public $error_comment = '';
	public $error_sql = '';
	public $error_sql_command = '';
	public $error_domain_object = '';
	
	public function __construct($error_comment,$error_sql,$error_sql_command,$error_domain_object){
		$this->error_comment = $error_comment;
		$this->error_sql = $error_sql;
		$this->error_sql_command = $error_sql_command;
		$this->error_domain_object = $error_domain_object;
	}
	
	public function errorMessage() {
		$error_message  = '==================================================';
		$error_message .= 'DataBase Broker exception:<br />';
		$error_message .= 'General explanation: '.$this->error_comment.'<br />';
		$error_message .= 'Domain Object: '.$this->error_domain_object.'<br />';
		$error_message .= 'DataBase Broker function: '.$this->error_sql_command.'<br />';
		$error_message .= 'DataBase Broker SQL: '.$this->error_sql.'<br />';
		$error_message .= '==================================================';
		echo $error_message;
		die();
	}
}
?>