<?php if($reg_user->user_type == 'pravno'){ ?>
<div class="user_menu">
	<div class="container">	
		<a href="profile/" class="btn <?php if($page == 'profile'){ ?>selected<?php } ?>">Početna</a>
		<a href="user_new_card/" class="btn <?php if($page == 'user_new_card'){ ?>selected<?php } ?>">Nova kartica</a>
		<a href="my_card/" class="btn <?php if($page == 'my_card'){ ?>selected<?php } ?>">Kartice</a>
		<a href="buy_credits_company/" class="btn <?php if($page == 'my_transactions'){ ?>selected<?php } ?>">Kupi kredit</a>
		<a href="my_transactions" class="btn <?php if($page == 'my_transactions'){ ?>selected<?php } ?>">Transakcije</a>
		<a href="logout/" class="btn">Izloguj se</a>
	</div>
</div>
<?php } ?>

<?php if($reg_user->user_type == 'fizicko'){ ?>
<div class="user_menu">
	<div class="container">	
		<a href="profile/" class="btn <?php if($page == 'profile'){ ?>selected<?php } ?>">Početna</a>
		<a href="buy_credits/" class="btn <?php if($page == 'buy_credits'){ ?>selected<?php } ?>">Kupi kredit</a>
		<a href="my_transactions" class="btn <?php if($page == 'my_transactions'){ ?>selected<?php } ?>">Transakcije</a>
		<a href="logout/" class="btn">Izloguj se</a>
	</div>
</div>
<?php } ?>
