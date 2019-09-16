<?php
$data=$post_data['data'];
$company_id = $data['id'];

global $broker;

$company_transactions_all = new company_transactions();
$company_transactions_all->set_condition('checker','!=','');
$company_transactions_all->add_condition('recordStatus','=','O');
$company_transactions_all->add_condition('training_school','=',$company_id);
$company_transactions_all->add_condition('transaction_date', '>=' , $data['date_from']);
$company_transactions_all->add_condition('transaction_date', '<=' , $data['date_to']);
$company_transactions_all->set_order_by('transaction_date','DESC');
$list = $broker->get_all_data_condition($company_transactions_all);

for($i=0;$i<sizeof($list);$i++){
  if($list[$i]->training_school !=''){$list[$i]->company = $broker->get_data(new training_school($list[$i]->training_school));}

  $list[$i]->transaction_value = $list[$i]->transaction_type == 'credit' ? $list[$i]->transaction_value*-1 : $list[$i]->transaction_value;

  
  
  $list[$i]->transaction_value = number_format($list[$i]->transaction_value,2,',','.');
  $list[$i]->transaction_type = $list[$i]->transaction_type == 'credit' ? 'Payment to company' : 'Payment from company';
}

?>
<table class="table table-striped all_items">
  <tbody><tr>
    <th style="width: 10px">#</th>
    <th>Trn. Date</th>
    <th>Trn. Type</th>
    <th>Value</th>
    <th style="width: 150px">Actions</th>
  </tr>
  <?php for ($i=0; $i < sizeof($list); $i++) { ?>
    <tr>
      <td><?php echo $i+1; ?>.</td>
      <td><?php echo date('d.m.Y.',strtotime($list[$i]->transaction_date)); ?></td>
      <td><?php echo $list[$i]->transaction_type; ?></td>
      <td><?php echo $list[$i]->transaction_value; ?></td>
      <td>
          <a href="javascript:void(0)>" class="btn btn-primary" data-toggle="modal" data-target="#modal_company_transaction_edit" onclick="get_edit_input_fields(<?php echo $list[$i]->id; ?>)">
            <i class="fa fa-edit" title="edit"></i>
          </a>
           <a href="javascript:void(0)>" class="btn btn-primary" data-toggle="modal" data-target="#modal_company_transaction_delete" onclick="set_transaction_id(<?php echo $list[$i]->id; ?>)">
            <i class="fa fa-trash" title="delete"></i>
          </a>
        </td>
    </tr>
      </td>
    </tr>
  <?php } ?>
  
</tbody></table>