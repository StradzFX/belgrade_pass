<?php
require_once "../classes/domain/xenon_menu.class.php";
$xenon_menu = new xenon_menu();
$xenon_menu->set_condition("showindashboard","=","1");
$xenon_menu->set_order_by("pozicija",$direction="ASC"); 
$xenon_menu = $broker->get_all_data_condition($xenon_menu);


require_once "../classes/domain/admin_links.class.php";
$admin_links = $broker->get_all_data(new admin_links);
?>
<div id="container">
    	<div id="header_information">
        	<h1><?php echo $ap_lang["Dashboard"]; ?></h1>
            <p><?php echo $ap_lang["Here you can choose which content you want to manage!"]; ?></p>
        </div><!--header_information-->
        <div id="content">
            <div id="left_dashboard">
                <div id="dashboard_menu">  
                <?php 
				if($_SESSION[ADMINAUTHDC][0] == "All")
				{
					for($i=0; $i<sizeof($xenon_menu); $i++)
					{ ?>
                    <div class="item">
                        <div class="item_icon">
                        <a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".$xenon_menu[$i]->name."&action=all" ?>"><img src="images/dashboard_icons/<?php echo $xenon_menu[$i]->icon; ?>" alt="<?php echo $xenon_menu[$i]->namemenu; ?>" title="<?php echo $xenon_menu[$i]->namemenu; ?>" border="0" /></a>
                        </div>
                        <p><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".$xenon_menu[$i]->name."&action=all" ?>" alt="<?php echo $xenon_menu[$i]->namemenu; ?>" title="<?php echo $xenon_menu[$i]->namemenu; ?>"><?php echo $xenon_menu[$i]->namemenu; ?></a></p>
                    </div>
			  <?php } 
				}
				else
				{ 
					$dc_option_array = $_SESSION[ADMINAUTHDC];
					$visible_dc_classes_name = array();
					$visible_dc_classes_namemenu = array();
					$visible_dc_classes_icon = array();
					for($i=0; $i<sizeof($xenon_menu); $i++)
						for($j=0; $j<sizeof($dc_option_array); $j++)
							if(strcmp($xenon_menu[$i]->name,$dc_option_array[$j])==0)
							{	
								$visible_dc_classes_name[] = $xenon_menu[$i]->name;
								$visible_dc_classes_namemenu[] = $xenon_menu[$i]->namemenu;
								$visible_dc_classes_icon[] = $xenon_menu[$i]->icon;
							}
					for($i=0; $i<sizeof($visible_dc_classes_name); $i++)
					{ 
					?>
                    <div class="item">
                        <div class="item_icon">
                        <a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".$visible_dc_classes_name[$i]."&action=all" ?>"><img src="images/dashboard_icons/<?php echo $visible_dc_classes_icon[$i]; ?>" alt="<?php echo $visible_dc_classes_namemenu[$i]; ?>" title="<?php echo $visible_dc_classes_namemenu[$i]; ?>" border="0" /></a>
                        </div>
                        <p><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=dc&page=".$visible_dc_classes_name[$i]."&action=all" ?>" alt="<?php echo $visible_dc_classes_namemenu[$i]; ?>" title="<?php echo $visible_dc_classes_namemenu[$i]; ?>"><?php echo $visible_dc_classes_namemenu[$i]; ?></a>
                        </p>
                    </div>
			  <?php }
				}?>
                
                
                <!------------------------------------------------ LINKS ------------------------------------------------>
              <div style="margin:0px 0px 50px 0px;width:690px;">
              	  <?php if(sizeof($admin_links)!=0){?>
                        <h1 style="font-size: 22px;color:#f8379b">
                            <div style="float:left;margin:5px 10px 0px 0px;"><img src="images/link_icon.png" /></div>
                            <div style="float:left"><?php echo $ap_lang["Links"];?></div>
                            <div style="clear:left"></div>
                        </h1>
                        <hr color="#CCCCCC" />	
                        <?php }?>                  
                    
                    <?php for ($i=0;$i<sizeof($admin_links);$i++){?>
                    <div class="custom_links">
                    <?php echo $i+1; ?>. <a href="<?php echo str_replace("{lang}", $_SESSION[ADMINPANELLANG], $admin_links[$i]->link); ?>" class="" target="_blank">
                    <?php echo $admin_links[$i]->name; ?>
                    </a>
                    </div><div style="clear:both"></div>
                    <?php }?>
                    <div style="clear:both;"></div>
                     </div>
                
                
                
                
                
                
                
                
                
                
                
                </div><!--dashboard_menu-->
            </div><!--left_dashboard-->
            <?php include_once 'php/dc_right_dashboard.php';?>
            <div style="clear:both"></div>
        </div><!--content-->    
    </div><!--container-->

