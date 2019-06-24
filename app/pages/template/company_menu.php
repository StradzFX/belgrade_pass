<?php
	$company_menu = $broker->get_session('company');
?>

<?php if($company_menu->type == 'master'){ ?>
<div class="company_menu">
	<div class="container">	

		
		<a href="company_home/" class="btn <?php if($page == 'company_home'){ ?>selected<?php } ?>">Početna</a>
			<a href="company_transactions/" class="btn <?php if($page == 'company_transactions'){ ?>selected<?php } ?>">Transakcije</a>
		<a href="company_config/" class="btn <?php if($page == 'company_config'){ ?>selected<?php } ?>">Podešavanja</a>
		<a href="company_logout/" class="btn">Izloguj se</a>
	</div>
</div>
<?php } ?>

<?php if($company_menu->type == 'location'){ ?>
<div class="company_menu">
	<div class="container">	
		<a href="company_home/" class="btn <?php if($page == 'company_home'){ ?>selected<?php } ?>">Početna</a>
		<a href="company_approval/" class="btn <?php if($page == 'company_approval'){ ?>selected<?php } ?>">Naplata</a>

		<a href="company_logout/" class="btn">Izloguj se</a>
	</div>
</div>
<?php } ?>
