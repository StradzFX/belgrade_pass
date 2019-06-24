<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/admin_reports.class.php";
require_once "php/functions.php";
$broker = new db_broker();
if($_POST)
{
	$admin_reports = new admin_reports();
	
	$admin_reports->page= str_replace('.php','',$_POST['page']);
	$admin_reports->display_name=$_POST['display_name'];
	$admin_reports->custom_sql=$_POST['custom_sql'];
	$admin_reports->instruction=$_POST['instruction'];
	$admin_reports->recordStatus='O';
	$admin_reports->maker='website';
	$admin_reports->makerDate=date('c');
	$admin_reports->checker='website';
	$admin_reports->checkerDate=date('c');
	$admin_reports->jezik='en';
	$admin_existing_reports = new admin_reports();
	$admin_existing_reports->add_condition('page','=',$admin_reports->page);
	$admin_existing_reports = $broker->get_all_data_condition($admin_existing_reports);
	if (sizeof($admin_existing_reports)==0){
		$admin_reports=$broker->insert($admin_reports);
			$success_message = $ap_lang["New reports page successfully added"];
	}else{
		if (sizeof($admin_existing_reports)!=0){
			$error_message = $ap_lang["Reports page already exists"];
		}
	}
		
	$admin_reports_string .= '
<?php
//=============================== PLACE FOR STANDARD FUNCTIONALITY ================================
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".."){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}

include_once "php/functions.php";
$broker = new db_broker();


$admin_reports_display = new admin_reports();
$admin_reports_display->add_condition("page","=",$_GET["page"]);
$admin_reports_display = $broker->get_all_data_condition($admin_reports_display);
$admin_reports_display=$admin_reports_display[0];

//==================================== PLACE FOR CUSTOM REPORT ====================================



//======================================= END CUSTOM REPORT =======================================
?>
<style>
	table{
		font-size:13px;
		margin:0px 0px 0px 20px;
	}
	
	table th{
		border-bottom:1px solid #666;
		padding:0px 10px 0px 10px;
	}
	
	table td{
		border-bottom:1px solid #CCC;
		padding:0px 10px 0px 10px;
	}
</style>

<div id="container">
	<div id="top">
		<h1><?php echo $admin_reports_display->display_name;?></h1>
	</div><!--top-->
	<div id="left_menu">
		<?php	include_once "php/reports_menu.php";	?>
	</div><!--left_menu-->
	<div id="right_domain_object">	
    <br />
	
<?php if (strip_tags($admin_reports_display->instruction)!=""){?>
    	<div style="color:#999;font-size:14px;padding:20px;word-wrap:break-word;">
        	<strong><?php echo $ap_lang["Instruction:"];?> </strong><?php echo $admin_reports_display->instruction;?>
		</div>
	<?php }?>
    
<?php if ($admin_reports_display->custom_sql!=""){
	$sql=$admin_reports_display->custom_sql;
	$result = $broker->execute_sql_get_array($sql);
	if(sizeof($result) > 0){
		$result_keys = array_keys($result[0]);
		}?>
		
            
	<?php if(sizeof($result) > 0){ ?>
    <table border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
        <?php foreach($result_keys as $element){ ?>
		<th><strong><?php echo ucfirst(str_replace("_"," ",$element)); ?></strong></th>
        <?php } ?>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0; $i<sizeof($result); $i++){ ?>
        	<tr>
            
			 <?php foreach($result_keys as $element){ ?>
				<td align="center"><?php 
				if(strpos($element,"date") > 0 || strpos($element,"Date") > 0){
					echo date("d.m.Y H:i:s",strtotime($result[$i][$element]));
				}else{
					echo $result[$i][$element];
				}
				 ?></td>
        	<?php } ?>
          
            </tr>
        <?php } ?>
    	</tbody>
 	</table>
    <?php }else{ ?>
    <center>
    	<div style="color:#666;font-size:24px;margin:20px 0px 0px 0px">There are no results</div>
    </center>
    <?php } ?>
			</div> 

<?php }else{ ?>


<?php } ?>		
				</div><!--right_see_all-->
	<div style="clear:both"></div>
</div><!--container-->	

	
		';
	$admin_reports_creation_folder = 'php/reports/'.$admin_reports->page.'.php';
	$fh = fopen($admin_reports_creation_folder, 'w') or die("can't open file");
	fwrite($fh, $admin_reports_string);
	fclose($fh);
	if($error_message == ''){
		unset($_POST);
	}
	
	
}

?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(function() {new nicEditor({fullPanel : true}).panelInstance("instruction");});</script>

<div id="container">
	<div id="top">
	<h1>Insert new report</h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <button type="button" onclick="location.href='index.php?type=s&page=reports_configuration'" class="general"><?php echo $ap_lang["Back"];?></button>

        <form action="" method="post" enctype="multipart/form-data">
		<table>
            <tr>
				<td><?php echo $ap_lang["Page"];?>:</td>
                <td><input type="text" name="page" value="<?php echo $_POST['page']; ?>"/> 
                (name of page in reports folder)</td>
			</tr>
            <tr>
				<td><?php echo $ap_lang["Name"];?>:</td>
                <td><input type="text" name="display_name" value="<?php echo $_POST['display_name']; ?>" style="width:200px"/> 
                (display name in reports page)</td>
			</tr>
            <tr>
				<td><?php echo $ap_lang["Custom SQL"];?>:</td>
                <td><textarea name="custom_sql" style="height:400px; width:600px;"><?php echo $_POST['custom_sql']; ?></textarea></td>
			</tr>
            <tr>
				<td><?php echo $ap_lang["Instruction:"];?></td>
                <td><textarea id="instruction" name="instruction" style="height:400px; width:600px;"><?php echo $_POST['instruction']; ?></textarea></td>
			</tr>
        <div style="clear:both;"></div>
        	<tr>
        		<td></td>
            	<td><button type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
        </table>
		</form>
        <br />
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
