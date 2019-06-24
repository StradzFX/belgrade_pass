<?php
require_once "../classes/domain/xenon_menu.class.php";
$xenon_menu = new xenon_menu();
$xenon_menu->set_condition("showindashboard","=","1");
$xenon_menu->set_order_by("namemenu",$direction="ASC");
$xenon_menu = $broker->get_all_data_condition($xenon_menu);
?>
<menu>
	<li class="title"><?php echo $ap_lang["Objects"]; ?></li>
     <?php
		$dc_option_array = $_SESSION[ADMINAUTHDC];
        if(sizeof($dc_option_array)==0)
            $error_message = $ap_lang["You don't have any content in database!"];
		else
		{
			$visible_dc_classes_namemenu = array();
			$visible_dc_classes_name = array();
			for($i=0; $i<sizeof($xenon_menu); $i++)
				for($j=0; $j<sizeof($dc_option_array); $j++)
					if(strcmp($xenon_menu[$i]->name,$dc_option_array[$j])==0)
					{	
						$visible_dc_classes_namemenu[] = $xenon_menu[$i]->namemenu;
						$visible_dc_classes_name[] = $xenon_menu[$i]->name;
					}
			if($_SESSION[ADMINAUTHDC][0] == "All")
			{
				for($i=0; $i<sizeof($xenon_menu); $i++) 
				{ ?>
				<li <?php if(strcmp($xenon_menu[$i]->name,$_GET["page"]) == 0){ ?>id="active" <?php } if($i == sizeof($xenon_menu)-1){ ?>class="last"<?php } ?>><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".$xenon_menu[$i]->name."&action=all" ?>"><?php echo $xenon_menu[$i]->namemenu; ?></a></li>
                <?php	$domain_class = $xenon_menu[$i];
				}
			}
			else
			{	
				for($i=0; $i<sizeof($visible_dc_classes_name); $i++)
				{ ?>
                <li <?php if(strcmp($visible_dc_classes_name[$i],$_GET["page"]) == 0){ ?>id="active" <?php } if($i == sizeof($visible_dc_classes_name)-1){ ?>class="last"<?php } ?>><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".strtolower($visible_dc_classes_name[$i])."&action=all" ?>"><?php echo $visible_dc_classes_namemenu[$i]; ?></a></li>
				<?php	$domain_class = $visible_dc_classes_name[$i];
				}
			}
		}		
		?>
</menu>