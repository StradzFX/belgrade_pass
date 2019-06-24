<?php

if(!$_SESSION['company']){
  header('Location:'.$base_url.'company_panel/');
  die();
}

$company = $broker->get_session('company');

if($company->type != 'location'){
  header('Location:'.$base_url.'company_home/');
  die();
}

//======== CARDS TO FILL ===========
$cards_to_fill = new user_card();
$cards_to_fill->set_condition('checker','!=','');
$cards_to_fill->add_condition('recordStatus','=','O');
$cards_to_fill->add_condition('partner_id','=',$company->id);
$cards_to_fill->add_condition('company_location','=',$company->location->id);
$cards_to_fill->add_condition('parent_first_name','=','');
$cards_to_fill->add_condition('delivery_method','=','partner');
$cards_to_fill->set_order_by('id','ASC');
$cards_to_fill = $broker->get_all_data_condition($cards_to_fill);

for($i=0;$i<sizeof($cards_to_fill);$i++){

}

?>
<?php if(sizeof($cards_to_fill) > 0){ ?>
<table>
  <tr>
    <td>Broj kartice</td>
    <td>Ime roditelja</td>
    <td>Ime deteta</td>
    <td>&nbsp;</td>
  </tr>
  <?php for ($i=0; $i < sizeof($cards_to_fill); $i++) { ?> 
    <tr id="fill_card_<?php echo $cards_to_fill[$i]->card_number; ?>">
      <td>
        <?php echo $cards_to_fill[$i]->card_number; ?>
      </td>
      <td>-</td>
      <td>-</td>
      <td>
        <a href="javascript:void(0)" onclick="get_card_edit_form('<?php echo $cards_to_fill[$i]->card_number; ?>')" title="Izmenite podatke za karticu">
          <i class="fas fa-edit"></i>
        </a>
      </td>
    </tr>
  <?php } ?>
</table>
<?php }else{ ?>
<div class="hello">
    Trenutno nemate ni jednu karticu za dopunu podataka
</div>
<?php } ?>
