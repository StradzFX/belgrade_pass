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

/*kopiranje svih fajlova iz zip fajla na potrebna mesta*/
if (is_dir($dirname))
      $dir_handle = opendir($dirname);
if (!$dir_handle)
      return false;
while($file = readdir($dir_handle)) 
	if ($file != "." && $file != "..")
	{
		if(strcmp($file,$dc_name.'.class.php')==0)
			copy($dirname .'/'. $file, '../classes/domain/'.$dc_name.'.class.php');
		else if(strcmp($file,'install.php')!=0)
				copy($dirname .'/'. $file, 'dc_forms/'.$dc_name.'/'.$file);
	}

//SQL CREATE TABLE FOR UPDATE DOMAIN OBJECT 
	$old_array = array();
	
	$rows = $broker->execute_query("SHOW COLUMNS FROM ".$dc_name);
	while($pickrow = $rows->fetch_assoc()) 
    	$old_array[] = $pickrow;
   
	if(sizeof($old_array) > 0) 
	{
		$array_not_to_look = array('maker','makerDate','checker','checkerDate','pozicija','jezik','recordStatus','modNumber','multilang_id');
   		for($i=0;$i<sizeof($old_array);$i++)
			if(!in_array($old_array[$i]['Field'],$array_not_to_look))
				$old_table_struct[] = array("field" => $old_array[$i]['Field'], "type" => $old_array[$i]['Type'], "key" => $old_array[$i]['Key'], "ai" => $old_array[$i]['Extra']);
	}

	$izmena = update_database_table($old_table_struct,$new_table_struct,$dc_name,$broker,$database);
	if(!$izmena)
		$error_message = $ap_lang["Something went wrong while updating object!"];

$xenon_menu = new xenon_menu();
$xenon_menu->set_condition("name","=",$dc_name);
$xenon_menu = $broker->get_data($xenon_menu);
$xenon_menu->showindashboard = $dc_showindashboard;
$xenon_menu->namemenu = $dc_namemenu;
$xenon_menu = $broker->update($xenon_menu);

/*funkcija za izbacivanje kolona iz niza i ubacivanje novih kolona*/
function update_database_table($old_table_struct,$new_table_struct,$dbtable,$dblink,$database)
{		
	for($i=0; $i<sizeof($new_table_struct); $i++)
	{
		if($new_table_struct[$i]['key'] == '1' && $new_table_struct[$i]['ai'] == '1')	
		{
			$new_table_struct[$i]['key'] = 'PRI';
			$new_table_struct[$i]['ai'] = 'auto_increment';
		}	
		elseif($new_table_struct[$i]['key'] == '1' && $new_table_struct[$i]['ai'] == '0')
		{
			$new_table_struct[$i]['key'] = 'MUL';
			$new_table_struct[$i]['ai'] = '';
		}
		else
		{
			$new_table_struct[$i]['key'] = '';
			$new_table_struct[$i]['ai'] = '';
		}	
	}
	
	$insert_column_array = array();
	$delete_column_array = array();
	
	$change_key_array = array();
	$change_type_array = array();
	
	$insert_ext_column_array = array();
	$delete_ext_column_array = array();
	
	$insert_fk_column_array = array();
	$delete_fk_column_array = array();
	
	//CHECKING FOR FOREIGN KEYS
	for($i = 0; $i < sizeof($new_table_struct); $i++)
	{	
		if($new_table_struct[$i]['key'] == '' && $new_table_struct[$i]['extendclass'] == 'none')
		{
			$result = $dblink->execute_query("
					SELECT * 
					FROM information_schema.key_column_usage
					WHERE referenced_table_name IS NOT NULL 
					AND REFERENCED_TABLE_SCHEMA = '".$database."'
					AND CONSTRAINT_NAME = '".$dbtable."_".$new_table_struct[$i]['field']."'
					");
			
			if($result->num_rows == 1)
			{
				$row = $result->fetch_assoc();
				$new_table_struct[$i]['extendclass'] = $row['REFERENCED_TABLE_NAME'];
				$new_table_struct[$i]['extendid'] = $row['REFERENCED_COLUMN_NAME'];
			}
		}
	}
	
	//algoritam za izbacivanje kolone iz starog niza
	for($i=0; $i<sizeof($old_table_struct); $i++)
	{
		$izbaci = true;
		for($j=0; $j<sizeof($new_table_struct); $j++)
			if(strcmp($old_table_struct[$i]['field'],$new_table_struct[$j]['field']) == 0)
				$izbaci = false;
		if($izbaci && $old_table_struct[$i]['key'] != 'MUL')
			$delete_column_array[] = $old_table_struct[$i];
		if($izbaci && $old_table_struct[$i]['key'] == 'MUL' && $new_table_struct[$i]['extendclass'] != 'none')
			$delete_ext_column_array[] = $old_table_struct[$i];
		if($izbaci && $old_table_struct[$i]['key'] == 'MUL' && $new_table_struct[$i]['extendclass'] == 'none')
			$delete_fk_column_array[] = $old_table_struct[$i];
	}
	
	//algoritam za ubacivanje kolone iz novog niza
	for($i=0; $i<sizeof($new_table_struct); $i++)
	{
		$ubaci = true;
		for($j=0; $j<sizeof($old_table_struct); $j++)
			if(strcmp($new_table_struct[$i]['field'],$old_table_struct[$j]['field']) == 0)
				$ubaci = false;
		if($ubaci && $old_table_struct[$i]['key'] != 'MUL')
			$insert_column_array[] = $new_table_struct[$i];
		if($ubaci && $new_table_struct[$i]['key'] == 'MUL' && $new_table_struct[$i]['extendclass'] != 'none')
			$insert_ext_column_array[] = $new_table_struct[$i];
		if($ubaci && $new_table_struct[$i]['key'] == 'MUL' && $new_table_struct[$i]['extendclass'] == 'none')
			$insert_fk_column_array[] = $new_table_struct[$i];
	}
	
	//algoritam za promenu kljuca i tipa i brisanje i editovanje ext i fk kljuceva
	for($i=0; $i<sizeof($new_table_struct); $i++)
	{
		for($j=0; $j<sizeof($old_table_struct); $j++)
		{
			if(strcmp($new_table_struct[$i]['field'],$old_table_struct[$j]['field']) == 0)
			{	
				if(strcmp($new_table_struct[$i]['type'],$old_table_struct[$j]['type']) != 0 ||
					strcmp($new_table_struct[$i]['ai'],$old_table_struct[$j]['ai']) != 0)
						if($old_table_struct[$j]['key'] != 'MUL')
							$change_type_array[] = $new_table_struct[$i];
							
				if($old_table_struct[$i]['key']!='PRI' && $new_table_struct[$i]['key']=='PRI' ||
		   			$old_table_struct[$i]['key']=='PRI' && $new_table_struct[$i]['key']!='PRI')
						$change_key_array[] = $new_table_struct[$i]; 
						
				if(strcmp($new_table_struct[$i]['key'],$old_table_struct[$j]['key']) != 0)
				{	
					if($new_table_struct[$i]['key'] == 'MUL')
					{	
						if($new_table_struct[$i]['extendclass'] != 'none')
							$insert_ext_column_array[] = $new_table_struct[$i];
						
						if($new_table_struct[$i]['extendclass'] == 'none')
							$insert_fk_column_array[] = $new_table_struct[$i];
					}
					if($new_table_struct[$i]['key'] == '')
					{	
						if($new_table_struct[$i]['extendclass'] == 'none')
							$delete_fk_column_array[] = $new_table_struct[$i];
						if($new_table_struct[$i]['extendclass'] != 'none')
							$delete_ext_column_array[] = $new_table_struct[$i];
					}
				}	
			} 		
		}
	}
	
	$querry = "ALTER TABLE ".$dbtable." ";
	if(sizeof($delete_column_array)!=0)
		for($i=0; $i<sizeof($delete_column_array); $i++)
			$querry = $querry."DROP ".$delete_column_array[$i]["field"].",";
			
	if(sizeof($insert_column_array)!=0)
	{
		$last_identifier = "";
		for($i=0; $i<sizeof($old_table_struct); $i++)
			for($j=0; $j<sizeof($new_table_struct); $j++)
				if(strcmp($old_table_struct[$i]['field'],$new_table_struct[$j]['field']) == 0)
				{
					$last_identifier = $old_table_struct[$i]['field'];
					break;	
				}
		for($i=0; $i<sizeof($insert_column_array); $i++)
		{	
			$field_type = strtoupper(substr($insert_column_array[$i]["type"],0,strpos($insert_column_array[$i]["type"], "(")));
			if($field_type == "INT" || $field_type == "DECIMAL")	$default_value = "DEFAULT 0";
			if($i!=0)												$last_identifier = $insert_column_array[$i-1]["field"];	
			$querry = $querry."ADD ".$insert_column_array[$i]["field"]." ".$insert_column_array[$i]["type"]." ".$insert_column_array[$i]["ai"].$default_value." AFTER ".$last_identifier.",";
		}
	}
			
	if(sizeof($change_type_array)!=0)
		for($i=0; $i<sizeof($change_type_array); $i++)
			$querry = $querry.'CHANGE '.$change_type_array[$i]["field"].' '.$change_type_array[$i]["field"].' '.$change_type_array[$i]["type"].' '.$change_type_array[$i]["ai"].",";
	
	if(sizeof($change_key_array)!=0)
	{
		$has_old_key = false;
		for($i=0; $i<sizeof($old_table_struct); $i++)
			if($old_table_struct[$i]["key"]=='PRI')
			{
				$has_old_key = true;
				break;
			}
		
		$has_new_key = false;
		for($i=0; $i<sizeof($new_table_struct); $i++)
			if($new_table_struct[$i]["key"]=='PRI')
			{
				$has_new_key = true;
				break;
			}
		
		if($has_old_key)
			$querry = $querry.'DROP PRIMARY KEY,';
		if($has_new_key)
		{
			$querry = $querry.'ADD PRIMARY KEY(';
			for ($i=0; $i<sizeof($change_key_array); $i++)
				$querry = $querry . $change_key_array[$i]["field"] . ",";
			$querry = substr($querry,0,-1);
			$querry = $querry . ")";
		}
		else
		{
			$querry = substr($querry,0,-1);
			$querry = $querry . ")";
		}
		if(!$dblink->execute_query($querry))
			return false;
	}
	else
	{
		$querry = substr($querry,0,-1);
		if(!$dblink->execute_query($querry))
			return false;
	}
	
	//algoritam za brisanje i dodavanje eksternih spoljnih kljuceva
	if(sizeof($insert_ext_column_array)>0)
	{
		$querry = 'ALTER TABLE '.$dbtable;
		for($i=0; $i<sizeof($insert_ext_column_array); $i++)
			$querry .= ' ADD CONSTRAINT '.$dbtable.'_'. $insert_ext_column_array[$i]["extendclass"] .' FOREIGN KEY(' . $insert_ext_column_array[$i]["extendclass"] . ') REFERENCES '. $insert_ext_column_array[$i]["extendclass"] .'('.$insert_ext_column_array[$i]["extendid"].') ON UPDATE CASCADE ON DELETE CASCADE,';
		$querry = substr($querry,0,-1);
		if(!$dblink->execute_query($querry))
			return false;
		for($j = 0; $j<sizeof($insert_ext_column_array); $j++)
		{
			$sql = "
				CREATE TRIGGER ".$dbtable."_".$insert_ext_column_array[$j]["extendclass"]." BEFORE UPDATE ON ".$insert_ext_column_array[$j]["extendclass"]."
				FOR EACH ROW
				BEGIN
					IF (OLD.recordStatus != NEW.recordStatus)  THEN
						IF NEW.recordStatus = 'C' THEN
							UPDATE ".$dbtable." SET recordStatus = 'C' WHERE ".$insert_ext_column_array[$j]["extendclass"]." = OLD.".$insert_ext_column_array[$j]["extendid"].";
						ELSEIF NEW.recordStatus = 'O' THEN
							UPDATE ".$dbtable." SET recordStatus = 'O' WHERE ".$insert_ext_column_array[$j]["extendclass"]." = OLD.".$insert_ext_column_array[$j]["extendid"].";
						END IF;
					END IF;
				END;
				"; 
			$dblink->instance->multi_query($sql);
			$dblink->instance;
		}	
	}
	
	if(sizeof($delete_ext_column_array)>0)
	{
		$querry = "ALTER TABLE ".$dbtable." ";
		for($i=0; $i<sizeof($delete_ext_column_array); $i++)
			$querry .= "DROP FOREIGN KEY ".$dbtable."_".$delete_ext_column_array[$i]["field"].",DROP INDEX ".$dbtable."_".$delete_ext_column_array[$i]["field"].',';
		$querry = substr($querry,0,-1);
		if(!$dblink->execute_query($querry))
			return false;
			
		$querry = "";	
		for($i=0; $i<sizeof($delete_ext_column_array); $i++)
			$querry = "DROP TRIGGER ".$dbtable."_".$delete_ext_column_array[$i]["extendclass"].",";
		$querry = substr($querry,0,-1);
		
		if(!$dblink->execute_query($querry))
			return false;
	}
	if(sizeof($insert_fk_column_array)>0)
	{
		$querry = "ALTER TABLE ".$dbtable." ";
		for($i=0; $i<sizeof($insert_fk_column_array); $i++)
			$querry .= "ADD INDEX (".$insert_fk_column_array[$i]["field"].'),';
		$querry = substr($querry,0,-1);
		if(!$dblink->execute_query($querry))
			return false;
	}
	if(sizeof($delete_fk_column_array)>0)
	{
		$querry = "ALTER TABLE ".$dbtable." ";
		for($i=0; $i<sizeof($delete_fk_column_array); $i++)
			$querry .= "DROP INDEX ".$delete_fk_column_array[$i]["field"].',';
		$querry = substr($querry,0,-1);
		if(!$dblink->execute_query($querry))
			return false;
	}
	return true;
}
?>