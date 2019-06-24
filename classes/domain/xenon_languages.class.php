<?php
require_once 'base_domain_object.php';
class xenon_languages implements base_domain_object
{
	public $id = 0;
	public $name = "";
	public $short = "";
	public $active = 0;
	public $defaultlang = 0;
	public $maker = "";
	public $makerDate = "";
	public $checker = "";
	public $checkerDate = "";
	public $pozicija = "";
	public $condition = "";
	public $order_by  = "id";
	public $limit  = 600;
	public $direction  = "DESC";

	public function __construct($id = 0, $name = "", $short = "", $active = 0, $defaultlang = 0,$maker = "",$makerDate = "",$checker = "",$checkerDate = "",$pozicija="")
	{
		$this->id = $id;
		$this->name = $name;
		$this->short = $short;
		$this->active = $active;
		$this->defaultlang = $defaultlang;
		$this->maker = $maker;
		$this->makerDate = $makerDate;
		$this->checker = $checker;
		$this->checkerDate = $checkerDate;
		$this->pozicija = $pozicija;
	}
	
	public function get_domain_name()
	{
		return strtolower(__CLASS__);
	}
	
	public function get_attribute_list()
	{
	return "`id`,`name`,`short`,`active`,`defaultlang`,`maker`,`makerDate`,`checker`,`checkerDate`,`pozicija`";
	}

	public function get_attribute_values()
	{
		return "NULL,'{$this->name}','{$this->short}','{$this->active}','{$this->defaultlang}','{$this->maker}','{$this->makerDate}','{$this->checker}','{$this->checkerDate}',{$this->pozicija}";
	}
	
	public function get_object($row)
	{
		return new xenon_languages($row['id'],$row['name'],$row['short'],$row['active'],$row['defaultlang'],$row['maker'],$row['makerDate'],$row['checker'],$row['checkerDate'],$row['pozicija']);
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
		$nizVarChar = array('name','short','maker','makerDate','checker','checkerDate');
		if(in_array($item,$nizVarChar))
			$this->condition = $item.' '.$sign." '".$value."'";
		else
			$this->condition = $item.' '.$sign.' '.$value."";
	}
	
	public function add_condition($item,$sign,$value,$mainUslov="AND")
	{
		$nizVarChar = array('name','short','maker','makerDate','checker','checkerDate');
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
		$nizVarChar = array('name','short','maker','makerDate','checker','checkerDate');
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
	
	public function get_update_values()
	{
		return "name = '{$this->name}',short = '{$this->short}',active = '{$this->active}',defaultlang = '{$this->defaultlang}',maker = '{$this->maker}',makerDate = '{$this->makerDate}',checker = '{$this->checker}',checkerDate = '{$this->checkerDate}',pozicija = '{$this->pozicija}'";
	}
}
?>