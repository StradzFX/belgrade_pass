<?php
require_once "../classes/domain/xenon_user.class.php";
require_once "../classes/domain/xenon_privilege.class.php";
require_once "../classes/domain/xenon_languages.class.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);

if($_POST['admin_login'])
{
	$user = new xenon_user();
	$user->set_condition('username','=',$_POST["username"]);
	$user->add_condition('password','=',md5($_POST["password"]));
	$user = $broker->get_data($user);
	
	if($user->id == NULL) 			$error_message = $ap_lang["Wrong username and password!"];
	elseif($user->active == 0) 		$error_message = $ap_lang["Your account is disabled!"];
	else
	{
		$privilege = $broker->get_data(new xenon_privilege($user->privilege));
		$_SESSION[ADMINLOGGEDIN] 	= $user->username;
		$_SESSION[ADMINUSER] 		= serialize($user);
		$_SESSION[ADMINAUTHDC] 		= explode(",",$privilege->dc_auth);
		$_SESSION[ADMINAUTHMODULES] = explode(",",$privilege->module_auth);
		$_SESSION[ADMINMAKER] 		= $privilege->maker;
		$_SESSION[ADMINCHECKER] 	= $privilege->checker;
		setcookie(DBNAME . "_admin_cookie", $user->username, time()+3600*24);
		header('Location: index.php?lang='.$_SESSION[ADMINPANELLANG].'&type=dc');
	}
}
?>
<script>
	$(function() {
		$('[name=fade_click]').click(function(){
			$('#login_form_1').fadeOut('fast', function(){
				$('#login_form_2').fadeIn('fast');
			});
		});
		$('#fade_back_click').click(function(){
			$('#login_form_2').fadeOut('fast', function(){
				$('#login_form_1').fadeIn('fast');
			});
		});
	});
</script>
<div id="login">
	<div id="lleft">
    	<img src="images/xenon-login.png" alt="xenon" /> 
        <p>development by WEB LAB <img src="images/web_lab_logo.png" alt="WEB LAB" /></p>
    </div><!--lleft-->
    <div id="lright">
    <?php if($error_message!=''){ ?><p id="error_message"><?php echo $error_message; ?></p><?php } ?>
    	<form id="form1" name="form1" method="post" action="">
        <div id="login_form_1">
        <fieldset>
        	<legend>Log in</legend>
            <label><?php echo $ap_lang["Username"]; ?>:</label> 
            <input name="username" type="text" size="25" /><br /><br />
            <label><?php echo $ap_lang["Password"]; ?>:</label>
            <input name="password" type="password" size="25" /><br /><br />
            <!--AKO IMA VISE JEZIKA-->    
              <?php if(sizeof($all_active_languages)>1) { ?>
			<label><?php echo $ap_lang["Please choose language"]; ?></label>
            <?php for($i=0;$i<sizeof($all_active_languages);$i++){ ?><a href="index.php?lang=<?php echo $all_active_languages[$i]->short; ?>"><img src="lang/icons/<?php echo $all_active_languages[$i]->short; ?>.png" alt="<?php echo $all_active_languages[$i]->name; ?>" title="<?php echo $all_active_languages[$i]->name; ?>" border="0"/></a><?php } ?><br />
			<div style="margin:10px 0 0 0;"></div>
     		<?php } ?>
            <!-- OVDE JE KRAJ SA DELOM ZA ODABIR JEZIKA -->
            <button type="submit" name="admin_login" value="submit"><?php echo $ap_lang["Login"]; ?></button>
        </fieldset>
        <p><a href="javascript:return false" name="fade_click"><?php echo $ap_lang["Lost password?"]; ?></a> <?php echo $ap_lang["or"]; ?> <a href="javascript:return false" name="fade_click"><?php echo $ap_lang["Need help?"]; ?></a></p>
        </div>
        <div id="login_form_2" style="display:none">
    	<fieldset>
        	<legend><?php echo $ap_lang["Contact us"]; ?></legend>
            <p id="contact_us">
            <strong>WEB LAB development</strong><br />
            <?php echo $ap_lang["Business hours: 9 AM - 5 PM"]; ?><br />
            <?php echo $ap_lang["(GMT+01:00) CET - Belgrade"]; ?><br /><br />
            
            <?php echo $ap_lang["Phone"]; ?>: (381) 11 6164 042<br />
            <?php echo $ap_lang["Email"]; ?>: <a href="mailto:office@weblab.us?Subject=Xenon%20Lost%20password%20or%20Need%20help">office@weblab.us</a><br />
            <?php echo $ap_lang["Address"]; ?>: Nehruova 68, 11000 <?php echo $ap_lang["Belgrade"]; ?>, <?php echo $ap_lang["Serbia"]; ?><br />
        	<?php echo $ap_lang["Website"]; ?>: <a href="http://www.weblab.us" target="_blank">www.weblab.us </a>        
            </p>
        </fieldset>
        <p><a href="javascript:return false" id="fade_back_click"><?php echo $ap_lang["Back to Log in page"]; ?></a></p>
        </div>
        </form>
    </div><!--lright-->
    <div style="clear:both;"></div>
</div><!--login-->
