<?php
require_once 'base_domain_object.php';
class xenon_user implements base_domain_object
{
	public $id = 0;
	public $username = "";
	public $password = "";
	public $active = 0;
	public $privilege = 0;
	public $see_other_data = 0;
	public $condition = "";
	public $order_by  = "id";
	public $limit  = 600;
	public $direction  = "DESC";

	public function __construct($id = 0, $username = "", $password = "", $active = 0, $privilege = 0,$see_other_data = 0)
	{
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->active = $active;
		$this->privilege = $privilege;
		$this->see_other_data = $see_other_data;
	}
	
	public function get_domain_name()
	{
		return strtolower(__CLASS__);
	}
	
	public function get_attribute_list(){
		return "`id`,`username`,`password`,`active`,`privilege`,`see_other_data`";
	}

	public function get_attribute_values()
	{
		return "NULL,'{$this->username}','{$this->password}','{$this->active}','{$this->privilege}','{$this->see_other_data}'";
	}
	
	public function get_object($row)
	{
		return new xenon_user($row['id'],$row['username'],$row['password'],$row['active'],$row['privilege'],$row['see_other_data']);
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
		if($this->order_by == '')
			return $this->order_by.' '.$this->direction;
		else
			return $this->order_by;
	}

	public function set_order_by($order_by,$direction="")
	{
		$this->order_by = $order_by.' '.$direction;
	}
	
	public function add_order_by($order_by,$direction="")
	{
		if($this->order_by == '')
			$this->order_by = $order_by.' '.$direction;
		else
			$this->order_by .= ','.$order_by.' '.$direction;
	}
	
	public function delete_order_by()
	{
		$this->order_by = "";
	}

	public function get_limit()
	{
		return $this->limit;
	}

	public function set_limit($limit,$from=0)
	{
		$this->limit = $from.",".$limit;
	}
	
	public function get_condition()
	{
		if($this->condition != "")
			return $this->condition;
		else
			return "id = ".$this->id;
	}
	
	public function set_condition($item,$sign,$value)
	{
		$nizVarChar = array('username','password');
		if(in_array($item,$nizVarChar))
			$this->condition = $item.' '.$sign." '".$value."'";
		else
			$this->condition = $item.' '.$sign.' '.$value."";
	}
	
	public function add_condition($item,$sign,$value,$mainUslov="AND"){
		$nizVarChar = array('username','password');
		if(in_array($item,$nizVarChar))
			if($this->condition == "")
				$this->condition = $item." ".$sign." '".$value."'";
			else
				$this->condition .= " ".$mainUslov." ".$item." ".$sign." '".$value."'";
		else
			if($this->condition == "")
				$this->condition = $item." ".$sign." ".$value;
			else
				$this->condition .= " ".$mainUslov." ".$item." ".$sign." ".$value;
	}
	
	public function add_group_condition($nizUslova,$mainUslov="AND")
	{
		$nizVarChar = array('username','password');
		$uslov = " ".$mainUslov." (";
			for($i=0;$i < sizeof($nizUslova);$i++)
				if($i == 0)
					if(in_array($nizUslova[$i][0],$nizVarChar))
						$uslov.= $nizUslova[$i][0].' '.$nizUslova[$i][1]." '".$nizUslova[$i][2]."'";
					else 
						$uslov .= $nizUslova[$i][0].' '.$nizUslova[$i][1].' '.$nizUslova[$i][2]; 
				else
					if(in_array($nizUslova[$i][0],$nizVarChar))
						$uslov.=' '.$nizUslova[$i][3].' '.$nizUslova[$i][0].' '.$nizUslova[$i][1]." '".$nizUslova[$i][2]."'";
					else
						$uslov.= ' '.$nizUslova[$i][4].' '.$nizUslova[$i][0].' '.$nizUslova[$i][1].' '.$nizUslova[$i][2];
		$uslov .= ")";
		$this->condition .= $uslov;
	}
	
	public function delete_condition()
	{
		$this->condition = "";
	}
	
	public function get_update_values()
	{
		return "username = '{$this->username}',password = '{$this->password}',active = '{$this->active}',privilege = '{$this->privilege}',see_other_data = '{$this->see_other_data}'";
	}
}
?>