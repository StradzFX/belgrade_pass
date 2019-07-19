<?php if($reg_user->user_type == 'pravno'){ ?>
<div class="row">
	<div class="col-12 col-sm-6">
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Poslednjih 5 kartica</div>
				<table class="table">
					<tr>
						<th>Kartica</th>
						<th>Kredita</th>
						<th>Ime i prezime</th>
						<th>Email</th>
					</tr>
					<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
					<tr>
						<td><?php echo $card_list[$i]->card_number; ?></td>
						<td>0</td>
						<td><?php echo $card_list[$i]->parent_first_name; ?> <?php echo $card_list[$i]->parent_last_name; ?></td>
						<td><?php echo $card_list[$i]->email; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6">
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Potrošnja kartica</div>
				<table class="table">
					<tr>
						<th>Kartica</th>
						<th>Kredita</th>
						<th>Datum</th>
					</tr>
					<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
					<tr>
						<td><?php echo $card_list[$i]->card_number; ?></td>
						<td>250</td>
						<td><?php echo date('d.m.Y.'); ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6">
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Računi</div>
				<table class="table">
					<tr>
						<th>Porudžbina</th>
						<th>Datum</th>
						<th>Kredita</th>
						<th>Status</th>
					</tr>
					<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
					<tr>
						<td><?php echo $i+1; ?>/2019</td>
						<td><?php echo date('d.m.Y.'); ?></td>
						<td>5500</td>
						<td>Nije plaćeno</td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6">
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Kartice sa 0 kredita</div>
				<table class="table">
					<tr>
						<th>Kartica</th>
						<th>Kredita</th>
						<th>Ime i prezime</th>
						<th>Email</th>
					</tr>
					<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
					<tr>
						<td><?php echo $card_list[$i]->card_number; ?></td>
						<td>0</td>
						<td><?php echo $card_list[$i]->parent_first_name; ?> <?php echo $card_list[$i]->parent_last_name; ?></td>
						<td><?php echo $card_list[$i]->email; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>