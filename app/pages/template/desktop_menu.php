<?php /*
<a href="<?php echo $language_link; ?>consultants/" class="hide-on-med-and-down <?php if($page == 'consultants' || $page == 'consultant' || $page == 'consultant_category'){ ?>selected<?php } ?>" >Consultants</a>
<a href="<?php echo $language_link; ?>projects/" 	class="hide-on-med-and-down <?php if($page == 'projects' || $page == 'project' || $page == 'project_category'){ ?>selected<?php } ?>">Projects</a>
<a href="<?php echo $language_link; ?>blog/" 		class="hide-on-med-and-down <?php if($page == 'blog' || $page == 'article' || $page == 'blog-category'){ ?>selected<?php } ?>">BLOG</a>

*/ 
$reg_user = $broker->get_session('user');
if($reg_user){
	$reg_user->avatar = 'public/images/default_user_icon.png';
}

$reg_company = $broker->get_session('company');
if($reg_company){
	$reg_company->avatar = 'public/images/default_user_icon.png';
}

?>


<?php if(!$reg_company){ ?>
	<?php if(!$reg_user){ ?>
		<a href="registracija/">
			<i class="material-icons">account_circle</i>
		</a>
	<?php }else{ ?>
		<a href="profile/">
			<i class="material-icons">account_circle</i>
		</a>
		<!-- /.profile-picture -->
	<?php } ?>
<?php }else{ ?>
	<a href="company_home/">
		<i class="material-icons">account_circle</i>
	</a>
	<!-- /.profile-picture -->
<?php } ?>

<a data-activates="slide-out" class="button-collapse waves-effect waves-light hide-on-large-only" style="padding: 0px 10px;">
	<i class="material-icons">reorder</i>
</a>
