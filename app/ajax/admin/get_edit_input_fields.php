<?php

$data = $post_data['data'];
$transaction_id = $data['id'];

global $broker;

$item = new company_transactions($transaction_id);
$item = $broker->get_data($item);

?>

<div class="box-body">
  <input type="hidden" name="edit_transaction_id" value="<?php echo $item->id; ?>">
   <div class="form-group">
    <label for="field_name">Transaction Type</label>
    <select class="form-control" name="edit_transaction_type">
      <option value="">Select Type</option>
      <option value="debit" <?php if('debit' == $item->transaction_type){ ?>selected="selected"<?php } ?>>Payment from company</option>
      <option value="credit" <?php if('credit' == $item->transaction_type){ ?>selected="selected"<?php } ?>>Payment to company</option>
    </select>
  </div>
  <div class="form-group">
    <label for="field_name">Value</label>
    <input type="text" class="form-control" name="edit_transaction_value" id="transaction_value" placeholder="Enter value (e.g. 1000)" value="<?php echo $item->transaction_value; ?>">
  </div>

  <div class="form-group">
    <label for="field_name">Transaction Date</label>
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
      <input type="date" value="<?php echo $item->transaction_date; ?>" name="edit_transaction_date" class="form-control pull-right" id="datepicker">
    </div>
  </div>
</div>
 