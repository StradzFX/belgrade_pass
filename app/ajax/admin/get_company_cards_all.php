<?php
global $broker;
$data=$post_data['data'];
$list = CardModule::list_companies_admin();
?>

<table class="table table-striped">
	<tbody><tr>
	  <th style="width: 10px">#</th>
	  <th>Company</th>
	  <th>Number of cards</th>
	  <th>Actions</th>
	</tr>
	<?php for ($i=0; $i < sizeof($list); $i++) { ?>
	  <tr>
	    <td><?php echo $i+1; ?>.</td>
	    <td><?php echo $list[$i]['company']->name; ?></td>
	    <td><?php echo $list[$i]['total']; ?></td>
	    <td>
	        <a href="company_cards_view/<?php echo $list[$i]['company']->id; ?>">
	          <div class="btn btn-primary">
	            <i class="fa fa-eye"title="View info"></i>
	          </div>
	        </a>
	    </td>
	  </tr>
	<?php } ?>

	</tbody></table>