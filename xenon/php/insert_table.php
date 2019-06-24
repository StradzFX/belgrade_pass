<?php
include_once('install/install.php');
include_once('../classes/database/db_broker.php');
include_once('../classes/domain/xenon_menu.class.php');
$broker = new db_broker();

$database = DBNAME;
$dirname = 'install';

$res = $broker->execute_query('SHOW DATABASES');

while ($row = $res->fetch_assoc()) {
    $db_list[] = $row['Database'];
}

for($i=0; $i<sizeof($db_list); $i++)
{
	$pos = strrpos($db_list[$i], $database);
	if($pos !== false)
		$database = $db_list[$i];
}
	
/*pravljenje novog foldera za novi domenski objekat*/
$dc_target_folder = 'dc_forms/'.$dc_name;
if(!file_exists($dc_target_folder))
{
	mkdir($dc_target_folder, 0777);
	chmod($dc_target_folder, 0755);
}

/*kopiranje svih fajlova iz zip fajla na potrebna mesta*/
if (is_dir($dirname))
      $dir_handle = opendir($dirname);
if (!$dir_handle)
      return false;
while($file = readdir($dir_handle)) 
	if ($file != "." && $file != "..")
	{
		if(strcmp($file,$dc_name.'.class.php') == 0)
			copy($dirname .'/'. $file, '../classes/domain/'.$dc_name.'.class.php');
		else if(strcmp($file,'install.php') != 0)
			copy($dirname .'/'. $file, 'dc_forms/'.$dc_name.'/'.$file);
	}

//SQL CREATE TABLE FOR NEW DOMAIN OBJECT 
	$pkey_array = array();
	$fkey_array = array();
	$ekey_array = array();
	
	$sql = 'CREATE TABLE IF NOT EXISTS '.$dc_name.' (';
	for($i = 0 ; $i < sizeof($new_table_struct); $i++){
		$sql .= $new_table_struct[$i]["field"].' '.$new_table_struct[$i]["type"];
		
		if($new_table_struct[$i]["ai"])													
			$sql .= ' AUTO_INCREMENT';
		if($new_table_struct[$i]["key"] == "1" && $new_table_struct[$i]["ai"] == "1")	
			$pkey_array[] = $new_table_struct[$i]["field"];
		if($new_table_struct[$i]["key"] == "1" && $new_table_struct[$i]["ai"] == "0" && $new_table_struct[$i]["extendclass"] == "none")
			$fkey_array[] = $new_table_struct[$i]["field"];
		if($new_table_struct[$i]["key"] == "1" && $new_table_struct[$i]["ai"] == "0" && $new_table_struct[$i]["extendclass"] != "none")		
			$ekey_array[] = array("table_name" => $new_table_struct[$i]["extendclass"],"table_field" => $new_table_struct[$i]["extendid"]);
			
		$sql .= ',';  
	}
	if(sizeof($pkey_array) > 0)
	{	
		$pkey_string = ',PRIMARY KEY (';
		for($j = 0; $j<sizeof($pkey_array); $j++)
			$pkey_string .= $pkey_array[$j].',';
		$pkey_string = substr($pkey_string,0,-1) . ')';
	}
	if(sizeof($fkey_array) > 0)
	{	
		$fkey_string = ',';
		for($j = 0; $j<sizeof($fkey_array); $j++)
			$fkey_string .= 'INDEX ('.$fkey_array[$j].'),';
		$fkey_string = substr($fkey_string,0,-1);
	}
	if(sizeof($ekey_array) > 0)
	{	
		$ekey_string = ',';
		for($j = 0; $j<sizeof($ekey_array); $j++)
			$ekey_string .= 'CONSTRAINT '.$dc_name.'_'.$ekey_array[$j]['table_name'].' FOREIGN KEY ('.$ekey_array[$j]['table_name'].') REFERENCES '.$ekey_array[$j]['table_name'].'('.$ekey_array[$j]['table_field'].') ON DELETE CASCADE ON UPDATE CASCADE,';
		$ekey_string = substr($ekey_string,0,-1);
	}
	
	$sql .= 'maker VARCHAR(150) NOT NULL,makerDate DATETIME NOT NULL,checker VARCHAR(150),checkerDate DATETIME,pozicija INT,jezik VARCHAR(3),recordStatus VARCHAR(1),modNumber INT NOT NULL,multilang_id INT NOT NULL'.$pkey_string.$fkey_string.$ekey_string.') ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';
	
	/*konekcija na bazu radi unosa podataka u tabelu*/
	if($broker->execute_query($sql)) 
	{
    	$xenon_menu = new xenon_menu();
		$xenon_menu->set_condition("name","=",$dc_name);
		$xenon_menu = $broker->get_all_data_condition($xenon_menu);
		if(sizeof($xenon_menu) == 0)
		{
			$xenon_menu_max_pozicija = $broker->get_max_position(new xenon_menu());
			$broker->insert(new xenon_menu('',$dc_name,$dc_namemenu,$dc_showindashboard,"default.png","xenon_core",date("Y-m-d"),"xenon_core",date("Y-m-d"),$xenon_menu_max_pozicija+1));
		}
	}else
		$error_message = $ap_lang["There was an error while installing new object!"];
		
	if(sizeof($ekey_array) > 0)
	{
		for($j = 0; $j<sizeof($ekey_array); $j++)
		{
			$sql = "
			CREATE TRIGGER ".$dc_name."_".$ekey_array[$j]['table_name']." BEFORE UPDATE ON ".$ekey_array[$j]['table_name']."
			FOR EACH ROW
			BEGIN
				IF (OLD.recordStatus != NEW.recordStatus)  THEN
					IF NEW.recordStatus = 'C' THEN
						UPDATE ".$dc_name." SET recordStatus = 'C' WHERE ".$ekey_array[$j]['table_name']." = OLD.".$ekey_array[$j]['table_field'].";
					ELSEIF NEW.recordStatus = 'O' THEN
						UPDATE ".$dc_name." SET recordStatus = 'O' WHERE ".$ekey_array[$j]['table_name']." = OLD.".$ekey_array[$j]['table_field'].";
					END IF;
				END IF;
			END;
			";
			$broker->instance->multi_query($sql);
    		$broker->instance;
		}
	}	
?>