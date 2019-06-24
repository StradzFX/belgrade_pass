<?php

$post_data = $_POST;
$data = $post_data['data'];

$id = $data['id'];
if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new transactions($id))){
  include_once 'template/header.php';
  include_once 'error_pages/error404.php';
  include_once 'template/footer.php';
  die();
}
$transactions = $broker->get_data(new transactions($id));
if($transactions->user != ''){$transactions->user = $broker->get_data(new user($transactions->user));}

if($transactions->transaction_type == 'purchase_post_office'){
	$purchase = $broker->get_data(new purchase($transactions->tranaction_id));
	$transactions->po_image = 'public/images/post_office/'.$purchase->id.'.jpg';
}

?>
<table class="table transaction_details_modal">
  <tbody>
  	<tr>
      <th scope="row">Tip</th>
      <td><?php echo $tr_types[$transactions->transaction_type]; ?></td>
    </tr>
    <tr>
      <th scope="row">Datum</th>
      <td><?php echo date('d.m.Y H:i:s',strtotime($transactions->makerDate)); ?></td>
    </tr>

    <?php if($transactions->transaction_type == 'purchase_post_office'){ ?> 
  	<tr>
        <th scope="row">Uplatnica</th>
        <td>
        	<img src="<?php echo $transactions->po_image; ?>" />
        </td>
      </tr>
  	<?php } ?>
  </tbody>
</table>

<style type="text/css">
	.transaction_details_modal img{
		max-width: 100%;
	}
</style>