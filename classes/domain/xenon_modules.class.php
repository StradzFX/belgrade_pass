<?php
require_once "base_domain_object.php";
class xenon_modules implements base_domain_object
{
	
	public $id = 0;
	public $name = "";
	public $tablename = "";
	public $version = "";
	
	//Properties
	public $condition = "";
	public $customSQL = "";
	public $order_by  = "id";
	public $limit  = 600;
	public $direction  = "DESC";

	public function __construct($id = 0, $name = "", $tablename = "", $version = "")
	{
		$this->id = $id;
		$this->name = $name;
		$this->tablename = $tablename;
		$this->version = $version;
	}
	
	public function get_domain_name()
	{
		return strtolower(__CLASS__);
	}
	
	public function get_attribute_list()
	{
	return "`id`,`name`,`tablename`,`version`";
	}

	public function get_attribute_values()
	{
		return "NULL,'{$this->name}','{$this->tablename}','{$this->version}'";
	}
	
	public function get_object($row)
	{
		return new xenon_modules($row['id'],$row['name'],$row['tablename'],$row['version']);
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
	
	public function add_order_by($order_by,$direction="")
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

	public function set_limit($limit,$from=0)
	{
		$this->limit = $from.",".$limit;
	}
	
	public function get_condition()
	{
		if($this->condition != "")		return $this->condition;
		else							return "id = ".$this->id;
	}
	
	public function set_condition($item,$sign,$value)
	{
		$nizVarChar = array("name","tablename","version");
		if(in_array($item,$nizVarChar))	$this->condition = $item." ".$sign." '".$value."'";
		else							$this->condition = $item." ".$sign.' '.$value."";
	}
	
	public function add_condition($item,$sign,$value,$mainUslov="AND")
	{
		$nizVarChar = array("name","tablename","version");
		if(in_array($item,$nizVarChar))
			if($this->condition == "")	$this->condition = $item." ".$sign." '".$value."'";
			else						$this->condition .= " ".$mainUslov." ".$item." ".$sign." '".$value."'";
		else
			if($this->condition == "")	$this->condition = $item." ".$sign." ".$value;
			else						$this->condition .= " ".$mainUslov." ".$item." ".$sign." ".$value;
	}
	
	public function add_group_condition($nizUslova,$mainUslov="AND")
	{
		$nizVarChar = array('name','tablename','version');
		$uslov = " ".$mainUslov." (";
			for($i=0;$i < sizeof($nizUslova);$i++)
				if($i == 0)
					if(in_array($nizUslova[$i][0],$nizVarChar))	
						$uslov.= $nizUslova[$i][0]." ".$nizUslova[$i][1]." '".$nizUslova[$i][2]."'";
					else
						$uslov .= $nizUslova[$i][0]." ".$nizUslova[$i][1]." ".$nizUslova[$i][2]; 
				else
					if(in_array($nizUslova[$i][0],$nizVarChar))
						$uslov.=" ".$nizUslova[$i][3]." ".$nizUslova[$i][0]." ".$nizUslova[$i][1]." '".$nizUslova[$i][2]."'";
					else
						$uslov.= " ".$nizUslova[$i][3]." ".$nizUslova[$i][0]." ".$nizUslova[$i][1]." ".$nizUslova[$i][2];
		$uslov .= ")";
		$this->condition .= $uslov;
	}
	
	public function delete_condition()
	{
		$this->condition = "";
	}
	
	public function set_custom_sql($sql)
	{
		$this->customSQL = $sql;
	}
	
	public function get_custom_sql($sql)
	{
		return $this->customSQL;
	}
	
	public function delete_custom_sql($sql)
	{
		$this->customSQL = "";
	}
	
	public function get_update_values()
	{
		return "name = '{$this->name}',tablename = '{$this->tablename}',version = '{$this->version}'";
	}
}
?>